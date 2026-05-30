<?php

namespace App\Livewire\Student;

use App\Models\Application;
use App\Models\Internship;
use App\Models\Logbook;
use App\Models\StudentProfile;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class LogbookSubmission extends Component
{
    use WithPagination;

    #[Url]
    public string $tab = 'all';

    #[Url]
    public string $sort = 'newest';

    #[Url]
    public string $q = '';

    #[Url]
    public int $perPage = 5;

    public ?int $editingLogbookId = null;

    public ?int $detailsLogbookId = null;

    public string $entryDate = '';

    public string $entryTitle = '';

    public string $entryBody = '';

    public function updatedTab(): void
    {
        $this->resetPage();
    }

    public function updatedSort(): void
    {
        $this->resetPage();
    }

    public function updatedQ(): void
    {
        $this->resetPage();
    }

    public function openNewEntryModal(): void
    {
        $this->editingLogbookId = null;
        $this->entryDate = Carbon::now()->toDateString();
        $this->entryTitle = '';
        $this->entryBody = '';
        $this->resetValidation();
        $this->dispatch('open-modal', 'logbook-entry');
    }

    public function openEditEntryModal(int $logbookId): void
    {
        $profile = $this->ensureStudentProfile();

        $logbook = Logbook::query()
            ->whereKey($logbookId)
            ->where('student_profile_id', $profile->id)
            ->firstOrFail();

        $parsed = $this->parseContent((string) $logbook->content);

        $this->editingLogbookId = $logbook->id;
        $this->entryDate = $logbook->entry_date?->toDateString() ?? Carbon::now()->toDateString();
        $this->entryTitle = $parsed['title'];
        $this->entryBody = $parsed['body'];
        $this->resetValidation();
        $this->dispatch('open-modal', 'logbook-entry');
    }

    public function saveEntry(): void
    {
        $this->validate([
            'entryDate' => ['required', 'date'],
            'entryTitle' => ['required', 'string', 'max:120'],
            'entryBody' => ['required', 'string', 'max:5000'],
        ]);

        $profile = $this->ensureStudentProfile();
        $internship = $this->currentInternship($profile);

        if (! $internship) {
            $this->addError('entryDate', 'No internship found for this logbook entry.');

            return;
        }

        $entryDate = Carbon::parse($this->entryDate)->toDateString();

        $logbook = Logbook::query()
            ->where('student_profile_id', $profile->id)
            ->where('internship_id', $internship->id)
            ->whereDate('entry_date', $entryDate)
            ->first();

        if ($this->editingLogbookId) {
            $logbook = Logbook::query()
                ->whereKey($this->editingLogbookId)
                ->where('student_profile_id', $profile->id)
                ->firstOrFail();
        }

        $payload = trim($this->entryTitle) . "\n\n" . trim($this->entryBody);

        if ($logbook) {
            $logbook->forceFill([
                'entry_date' => $entryDate,
                'content' => $payload,
                'status' => $logbook->status === 'approved' ? 'approved' : ($logbook->status === 'returned' ? 'returned' : 'draft'),
            ])->save();
        } else {
            Logbook::create([
                'internship_id' => $internship->id,
                'student_profile_id' => $profile->id,
                'entry_date' => $entryDate,
                'content' => $payload,
                'status' => 'draft',
            ]);
        }

        $this->editingLogbookId = null;
        $this->dispatch('close-modal', 'logbook-entry');
        $this->resetPage();
    }

    public function submitEntry(int $logbookId): void
    {
        $profile = $this->ensureStudentProfile();

        $logbook = Logbook::query()
            ->whereKey($logbookId)
            ->where('student_profile_id', $profile->id)
            ->firstOrFail();

        if (! in_array($logbook->status, ['draft', 'returned'], true)) {
            return;
        }

        $logbook->forceFill([
            'status' => 'submitted',
            'approved_by_user_id' => null,
            'approved_at' => null,
        ])->save();
    }

    public function openDetailsModal(int $logbookId): void
    {
        $this->detailsLogbookId = $logbookId;
        $this->dispatch('open-modal', 'logbook-details');
    }

    public function closeDetailsModal(): void
    {
        $this->detailsLogbookId = null;
        $this->dispatch('close-modal', 'logbook-details');
    }

    public function render(): View
    {
        $profile = $this->ensureStudentProfile();
        $internship = $this->currentInternship($profile);
        $internshipCard = $internship ? $this->presentInternshipCard($internship) : null;
        $counts = $this->logbookCounts($profile->id, $internship?->id);

        return view('livewire.student.logbook-submission', [
            'title' => 'Logbook Submission',
            'internshipCard' => $internshipCard,
            'entries' => $this->entriesPaginator($profile->id, $internship?->id),
            'tabs' => $this->tabs($counts),
            'counts' => $counts,
            'weeklyProgress' => $this->weeklyProgress($profile->id, $internship?->id),
            'stats' => $this->logbookStats($counts),
            'details' => $this->detailsPayload($profile->id),
        ])->extends('layouts.dashboard')->section('content');
    }

    private function entriesPaginator(int $studentProfileId, ?int $internshipId): LengthAwarePaginator
    {
        $perPage = max(1, min(25, $this->perPage));

        return $this->entriesQuery($studentProfileId, $internshipId)
            ->paginate($perPage)
            ->through(fn (Logbook $logbook): array => $this->presentEntryRow($logbook));
    }

    private function entriesQuery(int $studentProfileId, ?int $internshipId): Builder
    {
        $query = Logbook::query()
            ->with(['internship.companyProfile', 'approvedBy'])
            ->where('student_profile_id', $studentProfileId);

        if ($internshipId) {
            $query->where('internship_id', $internshipId);
        }

        $query = $this->applyTabFilter($query);
        $query = $this->applySearch($query);

        $query = $this->sort === 'oldest'
            ? $query->orderBy('entry_date')
            : $query->orderByDesc('entry_date');

        return $query->orderByDesc('updated_at');
    }

    private function applyTabFilter(Builder $query): Builder
    {
        return match ($this->tab) {
            'draft' => $query->where('status', 'draft'),
            'submitted' => $query->where('status', 'submitted'),
            'approved' => $query->where('status', 'approved'),
            'returned' => $query->where('status', 'returned'),
            default => $query,
        };
    }

    private function applySearch(Builder $query): Builder
    {
        $q = trim($this->q);

        if ($q === '') {
            return $query;
        }

        return $query->where(function (Builder $builder) use ($q): void {
            $builder->where('content', 'like', '%' . $q . '%')
                ->orWhereHas('internship', fn (Builder $internship): Builder => $internship->where('title', 'like', '%' . $q . '%'));
        });
    }

    private function presentEntryRow(Logbook $logbook): array
    {
        $parsed = $this->parseContent((string) $logbook->content);
        $date = $logbook->entry_date instanceof Carbon ? $logbook->entry_date : null;
        $status = $this->statusMeta($logbook);

        return [
            'id' => $logbook->id,
            'title' => $parsed['title'],
            'excerpt' => $parsed['excerpt'],
            'body' => $parsed['body'],
            'entry_date_label' => $date?->format('M j, Y') ?? '—',
            'entry_day_label' => $date?->format('l') ?? null,
            'status_label' => $status['label'],
            'status_class' => $status['class'],
            'status_meta' => $status['meta'],
            'action_label' => $logbook->status === 'draft' ? 'Continue' : 'View Details',
            'is_draft' => $logbook->status === 'draft',
            'internship_id' => $logbook->internship_id,
        ];
    }

    private function statusMeta(Logbook $logbook): array
    {
        return match ($logbook->status) {
            'draft' => [
                'label' => 'Draft',
                'class' => 'bg-neutral-100 text-neutral-700 ring-neutral-200',
                'meta' => 'Not submitted',
            ],
            'submitted' => [
                'label' => 'Submitted',
                'class' => 'bg-secondary-50 text-secondary-700 ring-secondary-100',
                'meta' => 'Pending review',
            ],
            'approved' => [
                'label' => 'Approved',
                'class' => 'bg-success-50 text-success-700 ring-success-100',
                'meta' => $logbook->approvedBy ? 'by ' . $logbook->approvedBy->name : null,
            ],
            'returned' => [
                'label' => 'Returned',
                'class' => 'bg-warning-50 text-warning-700 ring-warning-100',
                'meta' => 'Needs updates',
            ],
            default => [
                'label' => Str::headline((string) $logbook->status),
                'class' => 'bg-neutral-100 text-neutral-700 ring-neutral-200',
                'meta' => null,
            ],
        };
    }

    private function parseContent(string $content): array
    {
        $normalized = preg_replace("/\r\n?/", "\n", trim($content)) ?? '';

        if ($normalized === '') {
            return [
                'title' => 'Logbook entry',
                'body' => '',
                'excerpt' => '',
            ];
        }

        $blocks = explode("\n\n", $normalized, 2);
        $candidateTitle = trim($blocks[0] ?? '');
        $body = trim($blocks[1] ?? '');

        if ($body === '' && Str::length($candidateTitle) > 120) {
            $title = Str::limit($normalized, 60, '');
            $body = $normalized;
        } else {
            $title = $candidateTitle === '' ? 'Logbook entry' : Str::limit($candidateTitle, 80, '');
        }

        $excerptSource = $body !== '' ? $body : $normalized;

        return [
            'title' => $title,
            'body' => $body,
            'excerpt' => Str::limit($excerptSource, 110),
        ];
    }

    private function ensureStudentProfile(): StudentProfile
    {
        $user = auth()->user();

        return $user->studentProfile()->firstOrCreate();
    }

    private function currentInternship(StudentProfile $profile): ?Internship
    {
        $application = Application::query()
            ->with(['internship.companyProfile'])
            ->where('student_profile_id', $profile->id)
            ->where('status', 'accepted')
            ->orderByDesc('decided_at')
            ->orderByDesc('updated_at')
            ->first();

        if ($application?->internship) {
            return $application->internship;
        }

        $logbook = Logbook::query()
            ->with(['internship.companyProfile'])
            ->where('student_profile_id', $profile->id)
            ->orderByDesc('entry_date')
            ->first();

        return $logbook?->internship;
    }

    private function presentInternshipCard(Internship $internship): array
    {
        $start = $internship->start_date instanceof Carbon ? $internship->start_date : null;
        $end = $internship->end_date instanceof Carbon ? $internship->end_date : null;
        $now = Carbon::now();

        $progress = 0;

        if ($start && $end && $end->greaterThan($start)) {
            $elapsed = $start->diffInSeconds($now, false);
            $total = $start->diffInSeconds($end, false);
            $progress = (int) round(max(0, min(1, $elapsed / $total)) * 100);
        }

        $status = $end && $now->greaterThanOrEqualTo($end) ? 'Completed' : 'In Progress';

        return [
            'id' => $internship->id,
            'title' => $internship->title,
            'company' => $internship->companyProfile?->company_name,
            'date_range' => $start && $end ? ($start->format('M j, Y') . ' - ' . $end->format('M j, Y')) : null,
            'status' => $status,
            'progress' => $progress,
        ];
    }

    private function logbookCounts(int $studentProfileId, ?int $internshipId): array
    {
        $query = Logbook::query()
            ->where('student_profile_id', $studentProfileId);

        if ($internshipId) {
            $query->where('internship_id', $internshipId);
        }

        $raw = $query->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status')
            ->all();

        $draft = (int) ($raw['draft'] ?? 0);
        $submitted = (int) ($raw['submitted'] ?? 0);
        $approved = (int) ($raw['approved'] ?? 0);
        $returned = (int) ($raw['returned'] ?? 0);

        return [
            'all' => $draft + $submitted + $approved + $returned,
            'draft' => $draft,
            'submitted' => $submitted,
            'approved' => $approved,
            'returned' => $returned,
        ];
    }

    private function tabs(array $counts): array
    {
        return [
            ['key' => 'all', 'label' => 'All Entries', 'count' => $counts['all'] ?? 0],
            ['key' => 'draft', 'label' => 'Drafts', 'count' => $counts['draft'] ?? 0],
            ['key' => 'submitted', 'label' => 'Submitted', 'count' => $counts['submitted'] ?? 0],
            ['key' => 'approved', 'label' => 'Approved', 'count' => $counts['approved'] ?? 0],
            ['key' => 'returned', 'label' => 'Returned', 'count' => $counts['returned'] ?? 0],
        ];
    }

    private function weeklyProgress(int $studentProfileId, ?int $internshipId): array
    {
        $now = Carbon::now();
        $start = $now->copy()->startOfWeek();
        $end = $now->copy()->endOfWeek();

        $query = Logbook::query()
            ->where('student_profile_id', $studentProfileId)
            ->whereBetween('entry_date', [$start->toDateString(), $end->toDateString()]);

        if ($internshipId) {
            $query->where('internship_id', $internshipId);
        }

        $daysLogged = (int) $query->distinct('entry_date')->count('entry_date');
        $daysLogged = max(0, min(7, $daysLogged));
        $remaining = max(0, 7 - $daysLogged);
        $percent = (int) round(($daysLogged / 7) * 100);

        return [
            'range_label' => $start->format('M j') . ' - ' . $end->format('M j, Y'),
            'days_logged' => $daysLogged,
            'remaining' => $remaining,
            'percent' => $percent,
            'style' => 'conic-gradient(#4F46E5 0% ' . $percent . '%, #E2E8F0 ' . $percent . '% 100%)',
        ];
    }

    private function logbookStats(array $counts): array
    {
        return [
            'total' => (int) ($counts['all'] ?? 0),
            'approved' => (int) ($counts['approved'] ?? 0),
            'pending' => (int) ($counts['submitted'] ?? 0),
        ];
    }

    private function detailsPayload(int $studentProfileId): ?array
    {
        if (! $this->detailsLogbookId) {
            return null;
        }

        $logbook = Logbook::query()
            ->with(['internship.companyProfile', 'approvedBy'])
            ->whereKey($this->detailsLogbookId)
            ->where('student_profile_id', $studentProfileId)
            ->first();

        if (! $logbook) {
            return null;
        }

        $parsed = $this->parseContent((string) $logbook->content);
        $status = $this->statusMeta($logbook);

        return [
            'id' => $logbook->id,
            'title' => $parsed['title'],
            'body' => $parsed['body'] !== '' ? $parsed['body'] : $logbook->content,
            'date_label' => $logbook->entry_date?->format('M j, Y'),
            'internship_title' => $logbook->internship?->title,
            'company_name' => $logbook->internship?->companyProfile?->company_name,
            'status_label' => $status['label'],
            'status_class' => $status['class'],
            'status_meta' => $status['meta'],
            'can_submit' => in_array($logbook->status, ['draft', 'returned'], true),
        ];
    }
}
