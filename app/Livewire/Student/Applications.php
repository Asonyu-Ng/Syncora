<?php

namespace App\Livewire\Student;

use App\Models\Application;
use App\Models\StudentProfile;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Applications extends Component
{
    use WithPagination;

    #[Url]
    public string $status = 'all';

    #[Url]
    public string $search = '';

    #[Url]
    public int $perPage = 10;

    public function withdraw(int $applicationId): void
    {
        $profile = $this->ensureStudentProfile();

        $application = Application::query()
            ->whereKey($applicationId)
            ->where('student_profile_id', $profile->id)
            ->firstOrFail();

        if (! in_array($application->status, ['pending', 'applied', 'under_review'], true)) {
            return;
        }

        $application->update([
            'status' => 'withdrawn',
        ]);

        session()->flash('message', 'Application withdrawn.');
        $this->resetPage();
    }

    public function viewOffer(int $applicationId): void
    {
        $profile = $this->ensureStudentProfile();

        Application::query()
            ->whereKey($applicationId)
            ->where('student_profile_id', $profile->id)
            ->where('status', 'accepted')
            ->firstOrFail();

        session()->flash('message', 'Offer details are coming soon.');
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $profile = $this->ensureStudentProfile();
        $counts = $this->statusCounts($profile->id);

        return view('livewire.student.applications', [
            'title' => 'Applications',
            'applications' => $this->applicationsPaginator($profile->id),
            'statusTabs' => $this->statusTabs($counts),
            'statusCounts' => $counts,
        ])->extends('layouts.dashboard')->section('content');
    }

    private function applicationsPaginator(int $studentProfileId): LengthAwarePaginator
    {
        $perPage = max(1, min(50, $this->perPage));

        return $this->applicationsQuery($studentProfileId)
            ->paginate($perPage)
            ->through(function (Application $application): array {
                $company = $application->internship?->companyProfile?->company_name;
                $company = $company !== null && $company !== '' ? $company : '—';

                return [
                    'id' => $application->id,
                    'internship_id' => $application->internship_id,
                    'company' => $company,
                    'position' => $application->internship?->title ?? '—',
                    'status' => $this->statusLabel($application->status),
                    'status_key' => $application->status,
                    'applied_on' => $application->created_at?->toDateString(),
                ];
            });
    }

    private function applicationsQuery(int $studentProfileId): Builder
    {
        $query = Application::query()
            ->with(['internship.companyProfile'])
            ->where('student_profile_id', $studentProfileId);

        $query = $this->applyStatusFilter($query);
        $query = $this->applySearchFilter($query);

        return $query->orderByDesc('created_at');
    }

    private function applyStatusFilter(Builder $query): Builder
    {
        return match ($this->status) {
            'pending' => $query->whereIn('status', ['pending', 'applied']),
            'under_review' => $query->where('status', 'under_review'),
            'accepted' => $query->where('status', 'accepted'),
            'rejected' => $query->where('status', 'rejected'),
            'withdrawn' => $query->where('status', 'withdrawn'),
            default => $query,
        };
    }

    private function applySearchFilter(Builder $query): Builder
    {
        $term = trim($this->search);

        if ($term === '') {
            return $query;
        }

        $like = '%' . $this->escapeLike($term) . '%';

        return $query->whereHas('internship', function (Builder $internshipQuery) use ($like): void {
            $internshipQuery->where(function (Builder $nested) use ($like): void {
                $nested
                    ->where('title', 'like', $like)
                    ->orWhereHas('companyProfile', fn (Builder $companyQuery) => $companyQuery->where('company_name', 'like', $like));
            });
        });
    }

    private function statusCounts(int $studentProfileId): array
    {
        $raw = Application::query()
            ->where('student_profile_id', $studentProfileId)
            ->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status')
            ->all();

        $pending = (int) ($raw['pending'] ?? 0) + (int) ($raw['applied'] ?? 0);

        return [
            'all' => array_sum(array_map('intval', $raw)),
            'pending' => $pending,
            'under_review' => (int) ($raw['under_review'] ?? 0),
            'accepted' => (int) ($raw['accepted'] ?? 0),
            'rejected' => (int) ($raw['rejected'] ?? 0),
            'withdrawn' => (int) ($raw['withdrawn'] ?? 0),
        ];
    }

    private function statusTabs(array $counts): array
    {
        return [
            ['key' => 'all', 'label' => 'All Applications', 'count' => $counts['all'] ?? 0],
            ['key' => 'pending', 'label' => 'Pending', 'count' => $counts['pending'] ?? 0],
            ['key' => 'under_review', 'label' => 'Under Review', 'count' => $counts['under_review'] ?? 0],
            ['key' => 'accepted', 'label' => 'Accepted', 'count' => $counts['accepted'] ?? 0],
            ['key' => 'rejected', 'label' => 'Rejected', 'count' => $counts['rejected'] ?? 0],
            ['key' => 'withdrawn', 'label' => 'Withdrawn', 'count' => $counts['withdrawn'] ?? 0],
        ];
    }

    private function statusLabel(?string $status): string
    {
        return match ($status) {
            'pending', 'applied' => 'Pending',
            'under_review' => 'Under Review',
            'accepted' => 'Accepted',
            'rejected' => 'Rejected',
            'withdrawn' => 'Withdrawn',
            default => $status ? Str::headline($status) : '—',
        };
    }

    private function ensureStudentProfile(): StudentProfile
    {
        $user = auth()->user();

        return $user->studentProfile()->firstOrCreate();
    }

    private function escapeLike(string $value): string
    {
        return addcslashes($value, "\\%_");
    }
}
