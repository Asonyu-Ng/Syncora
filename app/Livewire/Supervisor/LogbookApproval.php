<?php

namespace App\Livewire\Supervisor;

use App\Livewire\Concerns\QueuesExports;
use App\Models\Internship;
use App\Models\Logbook;
use App\Models\SupervisorProfile;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class LogbookApproval extends Component
{
    use WithPagination;
    use QueuesExports;

    #[Url]
    public string $tab = 'pending';

    #[Url]
    public string $search = '';

    #[Url]
    public string $internship = '';

    #[Url]
    public string $status = '';

    #[Url]
    public string $from = '';

    #[Url]
    public string $to = '';

    #[Url]
    public int $perPage = 10;

    #[Url]
    public string $summaryRange = 'this_week';

    public function mount(): void
    {
        if (! in_array($this->tab, ['pending', 'reviewed', 'all'], true)) {
            $this->tab = 'pending';
        }
    }

    public function updatedTab(): void
    {
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedInternship(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedFrom(): void
    {
        $this->resetPage();
    }

    public function updatedTo(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function approve(int $logbookId): void
    {
        $userId = (int) (auth()->id() ?? 0);

        if ($userId <= 0) {
            return;
        }

        $supervisorProfileId = $this->ensureSupervisorProfile()->id;

        $logbook = Logbook::query()
            ->whereKey($logbookId)
            ->whereHas('internship', fn (Builder $builder): Builder => $builder->where('supervisor_profile_id', $supervisorProfileId))
            ->first();

        if (! $logbook) {
            session()->flash('message', 'Logbook entry not found.');
            return;
        }

        if ($logbook->status !== 'submitted') {
            session()->flash('message', 'Only submitted logbooks can be approved.');
            return;
        }

        $logbook->forceFill([
            'status' => 'approved',
            'approved_by_user_id' => $userId,
            'approved_at' => now(),
        ])->save();

        session()->flash('message', 'Logbook approved.');
        $this->resetPage();
    }

    public function returnEntry(int $logbookId): void
    {
        $supervisorProfileId = $this->ensureSupervisorProfile()->id;

        $logbook = Logbook::query()
            ->whereKey($logbookId)
            ->whereHas('internship', fn (Builder $builder): Builder => $builder->where('supervisor_profile_id', $supervisorProfileId))
            ->first();

        if (! $logbook) {
            session()->flash('message', 'Logbook entry not found.');
            return;
        }

        if ($logbook->status !== 'submitted') {
            session()->flash('message', 'Only submitted logbooks can be returned.');
            return;
        }

        $logbook->forceFill([
            'status' => 'returned',
            'approved_by_user_id' => null,
            'approved_at' => null,
        ])->save();

        session()->flash('message', 'Logbook returned.');
        $this->resetPage();
    }

    public function export(): void
    {
        $supervisorProfileId = $this->ensureSupervisorProfile()->id;

        $filters = [
            'supervisor_profile_id' => $supervisorProfileId,
            'internship_id' => $this->internship,
            'status' => $this->status,
            'from' => $this->from,
            'to' => $this->to,
            'q' => $this->search,
        ];

        if ($filters['status'] === '') {
            $statuses = $this->tabStatuses();
            if ($statuses !== []) {
                $filters['statuses'] = $statuses;
            }
        }

        $this->queueExport('logbooks', $filters, 'Logbooks export queued.');
    }

    public function render(): View
    {
        $supervisorProfile = $this->ensureSupervisorProfile();

        $internships = Internship::query()
            ->where('supervisor_profile_id', $supervisorProfile->id)
            ->orderBy('title')
            ->get(['id', 'title']);

        return view('livewire.supervisor.logbook-approval', [
            'title' => 'Logbook Approval',
            'logbooks' => $this->logbooksPaginator($supervisorProfile->id),
            'internships' => $internships,
            'tabs' => $this->tabsPayload($supervisorProfile->id),
            'summary' => $this->summaryPayload($supervisorProfile->id),
        ])->extends('layouts.dashboard')->section('content');
    }

    private function ensureSupervisorProfile(): SupervisorProfile
    {
        $user = auth()->user();

        return SupervisorProfile::query()->firstOrCreate([
            'user_id' => $user?->id,
        ]);
    }

    private function logbooksPaginator(int $supervisorProfileId): LengthAwarePaginator
    {
        $perPage = max(5, min(50, $this->perPage));

        $paginator = $this->logbooksQuery($supervisorProfileId)->paginate($perPage);

        $paginator->setCollection(
            $paginator->getCollection()->map(fn (Logbook $logbook): array => $this->presentRow($logbook))
        );

        return $paginator;
    }

    private function logbooksQuery(int $supervisorProfileId): Builder
    {
        $query = Logbook::query()
            ->with([
                'studentProfile.user',
                'internship.companyProfile',
                'approvedBy',
            ])
            ->whereHas('internship', fn (Builder $builder): Builder => $builder->where('supervisor_profile_id', $supervisorProfileId));

        if ($this->internship !== '') {
            $query->where('internship_id', (int) $this->internship);
        }

        $tabStatuses = $this->tabStatuses();
        if ($tabStatuses !== []) {
            $query->whereIn('status', $tabStatuses);
        }

        if ($this->status !== '') {
            $query->where('status', $this->status);
        }

        if ($this->from !== '') {
            $query->whereDate('entry_date', '>=', $this->from);
        }

        if ($this->to !== '') {
            $query->whereDate('entry_date', '<=', $this->to);
        }

        if (trim($this->search) !== '') {
            $q = trim($this->search);

            $query->where(function (Builder $builder) use ($q): void {
                $builder->where('content', 'like', '%' . addcslashes($q, "\\%_") . '%')
                    ->orWhereHas('studentProfile.user', fn (Builder $user): Builder => $user->where('name', 'like', '%' . addcslashes($q, "\\%_") . '%'))
                    ->orWhereHas('internship', fn (Builder $internship): Builder => $internship->where('title', 'like', '%' . addcslashes($q, "\\%_") . '%'));
            });
        }

        return $query
            ->orderByDesc('entry_date')
            ->orderByDesc('id');
    }

    private function tabStatuses(): array
    {
        return match ($this->tab) {
            'pending' => ['submitted'],
            'reviewed' => ['approved', 'returned'],
            default => [],
        };
    }

    private function presentRow(Logbook $logbook): array
    {
        $user = $logbook->studentProfile?->user;

        $name = (string) ($user?->name ?? 'Student');
        $email = (string) ($user?->email ?? '');
        $initial = strtoupper(substr($name, 0, 1));
        $initial = $initial !== '' ? $initial : 'S';

        $internshipTitle = (string) ($logbook->internship?->title ?? '');
        $company = (string) ($logbook->internship?->companyProfile?->company_name ?? '');

        $date = $logbook->entry_date instanceof Carbon ? $logbook->entry_date : null;
        $dateLabel = $date?->format('M j, Y') ?? '—';
        $weekLabel = $date ? 'Week ' . $date->isoWeek() : null;

        $content = (string) ($logbook->content ?? '');
        $content = trim($content);
        $excerpt = $content !== '' ? Str::limit(preg_replace("/\r\n?/", ' ', $content) ?? '', 110) : '—';

        $status = $this->statusMeta($logbook);
        $approvedLabel = $logbook->approved_at?->diffForHumans();

        return [
            'id' => $logbook->id,
            'student_name' => $name,
            'student_email' => $email !== '' ? $email : '—',
            'student_initial' => $initial,
            'internship_title' => $internshipTitle !== '' ? $internshipTitle : '—',
            'company_name' => $company !== '' ? $company : '—',
            'entry_date_label' => $dateLabel,
            'week_label' => $weekLabel,
            'excerpt' => $excerpt,
            'status_key' => (string) $logbook->status,
            'status_label' => $status['label'],
            'status_class' => $status['class'],
            'status_meta' => $status['meta'],
            'can_review' => $logbook->status === 'submitted',
            'approved_label' => $approvedLabel,
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

    private function tabsPayload(int $supervisorProfileId): array
    {
        $base = Logbook::query()
            ->whereHas('internship', fn (Builder $builder): Builder => $builder->where('supervisor_profile_id', $supervisorProfileId));

        if ($this->internship !== '') {
            $base->where('internship_id', (int) $this->internship);
        }

        if ($this->from !== '') {
            $base->whereDate('entry_date', '>=', $this->from);
        }

        if ($this->to !== '') {
            $base->whereDate('entry_date', '<=', $this->to);
        }

        if (trim($this->search) !== '') {
            $q = trim($this->search);

            $base->where(function (Builder $builder) use ($q): void {
                $builder->where('content', 'like', '%' . addcslashes($q, "\\%_") . '%')
                    ->orWhereHas('studentProfile.user', fn (Builder $user): Builder => $user->where('name', 'like', '%' . addcslashes($q, "\\%_") . '%'))
                    ->orWhereHas('internship', fn (Builder $internship): Builder => $internship->where('title', 'like', '%' . addcslashes($q, "\\%_") . '%'));
            });
        }

        $pending = (clone $base)->where('status', 'submitted')->count();
        $reviewed = (clone $base)->whereIn('status', ['approved', 'returned'])->count();
        $all = (clone $base)->count();

        return [
            [
                'key' => 'pending',
                'label' => 'Pending Review',
                'count' => $pending,
            ],
            [
                'key' => 'reviewed',
                'label' => 'Reviewed',
                'count' => $reviewed,
            ],
            [
                'key' => 'all',
                'label' => 'All Logbooks',
                'count' => $all,
            ],
        ];
    }

    private function summaryPayload(int $supervisorProfileId): array
    {
        [$start, $end, $label] = $this->summaryWindow();

        $query = Logbook::query()
            ->whereHas('internship', fn (Builder $builder): Builder => $builder->where('supervisor_profile_id', $supervisorProfileId));

        if ($this->internship !== '') {
            $query->where('internship_id', (int) $this->internship);
        }

        if ($start) {
            $query->whereDate('entry_date', '>=', $start->toDateString());
        }

        if ($end) {
            $query->whereDate('entry_date', '<=', $end->toDateString());
        }

        $total = (clone $query)->count();
        $submitted = (clone $query)->where('status', 'submitted')->count();
        $approved = (clone $query)->where('status', 'approved')->count();
        $returned = (clone $query)->where('status', 'returned')->count();
        $draft = (clone $query)->where('status', 'draft')->count();
        $reviewed = $approved + $returned;

        $segments = [
            [
                'label' => 'Reviewed',
                'count' => $reviewed,
                'color' => '#34D399',
                'legend_class' => 'bg-success-400',
            ],
            [
                'label' => 'In Review',
                'count' => $submitted,
                'color' => '#60A5FA',
                'legend_class' => 'bg-info-400',
            ],
            [
                'label' => 'Draft',
                'count' => $draft,
                'color' => '#CBD5E1',
                'legend_class' => 'bg-neutral-300',
            ],
        ];

        $segments = collect($segments)
            ->map(function (array $segment) use ($total): array {
                $segment['percent'] = $total > 0 ? (int) round(($segment['count'] / $total) * 100) : 0;
                return $segment;
            })
            ->all();

        return [
            'range_label' => $label,
            'totals' => [
                'total' => $total,
                'pending' => $submitted,
                'reviewed' => $reviewed,
                'approved' => $approved,
                'returned' => $returned,
            ],
            'donut' => [
                'segments' => $segments,
                'style' => $this->donutStyle($segments),
            ],
        ];
    }

    private function summaryWindow(): array
    {
        $now = Carbon::now();

        return match ($this->summaryRange) {
            'this_month' => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth(), 'This Month'],
            'last_30_days' => [$now->copy()->subDays(29)->startOfDay(), $now->copy()->endOfDay(), 'Last 30 Days'],
            'all_time' => [null, null, 'All Time'],
            default => [$now->copy()->startOfWeek(), $now->copy()->endOfWeek(), 'This Week'],
        };
    }

    private function donutStyle(array $segments): string
    {
        $sum = (float) collect($segments)->sum('percent');

        if ($sum <= 0) {
            return 'conic-gradient(#E2E8F0 0% 100%)';
        }

        $cursor = 0.0;
        $parts = [];

        foreach ($segments as $segment) {
            $percent = (float) ($segment['percent'] ?? 0);
            $slice = ($percent / $sum) * 100;
            $start = $cursor;
            $end = $cursor + $slice;
            $cursor = $end;

            $parts[] = sprintf('%s %.4f%% %.4f%%', $segment['color'], $start, $end);
        }

        return 'conic-gradient(' . implode(', ', $parts) . ')';
    }
}
