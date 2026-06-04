<?php

namespace App\Livewire\Supervisor;

use App\Models\Application;
use App\Models\Internship;
use App\Models\Logbook;
use App\Models\StudentProfile;
use App\Models\SupervisorProfile;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class StudentsManagement extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $internship = '';

    #[Url]
    public string $program = '';

    #[Url]
    public string $status = 'all';

    #[Url]
    public int $perPage = 10;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedInternship(): void
    {
        $this->resetPage();
    }

    public function updatedProgram(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function export(): void
    {
        session()->flash('message', 'Export is coming soon.');
    }

    public function addStudent(): void
    {
        session()->flash('message', 'Add student is coming soon.');
    }

    public function openFilters(): void
    {
        session()->flash('message', 'More filters are coming soon.');
    }

    public function viewStudent(int $studentProfileId): void
    {
        StudentProfile::query()->whereKey($studentProfileId)->firstOrFail();

        session()->flash('message', 'Student profile view is coming soon.');
    }

    public function render(): View
    {
        $user = auth()->user();
        $supervisorProfile = SupervisorProfile::query()->firstOrCreate([
            'user_id' => $user?->id,
        ]);

        $internships = Internship::query()
            ->where('supervisor_profile_id', $supervisorProfile->id)
            ->orderBy('title')
            ->get(['id', 'title', 'status', 'end_date']);

        $internshipIds = $internships->pluck('id');

        return view('livewire.supervisor.students-management', [
            'title' => 'My Students',
            'students' => $this->studentsPaginator($supervisorProfile->id),
            'internships' => $internships,
            'programOptions' => $this->programOptions($supervisorProfile->id),
            'stats' => $this->stats($internshipIds),
        ])->extends('layouts.dashboard')->section('content');
    }

    private function studentsPaginator(int $supervisorProfileId): LengthAwarePaginator
    {
        $perPage = max(1, min(50, $this->perPage));

        $paginator = $this->studentsQuery($supervisorProfileId)
            ->paginate($perPage);

        $students = $paginator->getCollection();

        $pairs = $students
            ->map(function (StudentProfile $profile): array {
                $application = $this->selectedApplication($profile);

                return [
                    'student_profile_id' => $profile->id,
                    'internship_id' => $application?->internship_id,
                ];
            })
            ->filter(fn (array $pair): bool => (bool) $pair['internship_id'])
            ->values();

        $studentProfileIds = $pairs->pluck('student_profile_id')->unique()->values();
        $internshipIds = $pairs->pluck('internship_id')->unique()->values();

        $taskTotals = $this->taskTotals($studentProfileIds, $internshipIds);
        $taskActivity = $this->taskLastActivity($studentProfileIds, $internshipIds);
        $logbookActivity = $this->logbookLastActivity($studentProfileIds, $internshipIds);

        $paginator->setCollection(
            $students->map(function (StudentProfile $profile) use ($taskTotals, $taskActivity, $logbookActivity): array {
                $user = $profile->user;
                $application = $this->selectedApplication($profile);
                $internship = $application?->internship;

                $company = (string) ($internship?->companyProfile?->company_name ?? '');
                $company = $company !== '' ? $company : '—';

                $internshipTitle = (string) ($internship?->title ?? '');
                $internshipTitle = $internshipTitle !== '' ? $internshipTitle : '—';

                $statusKey = $this->internshipStatusKey($internship);
                $badge = $this->statusBadge($statusKey);

                $key = $this->pairKey($profile->id, $internship?->id);
                $totals = $taskTotals[$key] ?? ['total' => 0, 'completed' => 0];

                $totalTasks = (int) ($totals['total'] ?? 0);
                $completedTasks = (int) ($totals['completed'] ?? 0);
                $progress = $totalTasks > 0 ? (int) round(($completedTasks / $totalTasks) * 100) : 0;

                $taskLast = $taskActivity[$key] ?? null;
                $logbookLast = $logbookActivity[$key] ?? null;
                $last = $this->maxDate([$taskLast, $logbookLast]);
                $lastLabel = $last ? $last->diffForHumans() : '—';

                $name = (string) ($user?->name ?? 'Student');
                $email = (string) ($user?->email ?? '');
                $matricule = (string) ($user?->matricule ?? '');

                $initial = strtoupper(substr($name, 0, 1));

                return [
                    'id' => $profile->id,
                    'name' => $name,
                    'email' => $email !== '' ? $email : '—',
                    'matricule' => $matricule !== '' ? $matricule : '—',
                    'initial' => $initial !== '' ? $initial : 'S',
                    'internship' => $internshipTitle,
                    'company' => $company,
                    'program' => (string) ($profile->department ?: '—'),
                    'progress' => $progress,
                    'status_label' => $badge['label'],
                    'status_class' => $badge['class'],
                    'tasks' => $totalTasks,
                    'last_active' => $lastLabel,
                ];
            })
        );

        return $paginator;
    }

    private function studentsQuery(int $supervisorProfileId): Builder
    {
        $query = StudentProfile::query()
            ->with([
                'user',
                'applications' => function ($applications) use ($supervisorProfileId): void {
                    $applications
                        ->where('status', 'accepted')
                        ->whereHas('internship', fn (Builder $q) => $q->where('supervisor_profile_id', $supervisorProfileId))
                        ->with(['internship.companyProfile'])
                        ->orderByDesc('decided_at')
                        ->orderByDesc('created_at');
                },
            ])
            ->whereHas('applications', function (Builder $applications) use ($supervisorProfileId): void {
                $applications
                    ->where('status', 'accepted')
                    ->whereHas('internship', fn (Builder $q) => $q->where('supervisor_profile_id', $supervisorProfileId));
            });

        $query = $this->applyInternshipFilter($query, $supervisorProfileId);
        $query = $this->applyProgramFilter($query);
        $query = $this->applyStatusFilter($query, $supervisorProfileId);
        $query = $this->applySearchFilter($query, $supervisorProfileId);

        return $query->orderByDesc('id');
    }

    private function applyInternshipFilter(Builder $query, int $supervisorProfileId): Builder
    {
        $internshipId = trim($this->internship);

        if ($internshipId === '' || ! ctype_digit($internshipId)) {
            return $query;
        }

        return $query->whereHas('applications', function (Builder $applications) use ($supervisorProfileId, $internshipId): void {
            $applications
                ->where('status', 'accepted')
                ->where('internship_id', (int) $internshipId)
                ->whereHas('internship', fn (Builder $q) => $q->where('supervisor_profile_id', $supervisorProfileId));
        });
    }

    private function applyProgramFilter(Builder $query): Builder
    {
        $program = trim($this->program);

        if ($program === '') {
            return $query;
        }

        return $query->where('department', $program);
    }

    private function applyStatusFilter(Builder $query, int $supervisorProfileId): Builder
    {
        $status = strtolower(trim($this->status));

        if ($status === '' || $status === 'all') {
            return $query;
        }

        $completedStatuses = ['closed', 'completed', 'finished'];
        $onHoldStatuses = ['paused', 'on_hold', 'hold'];
        $today = now()->toDateString();

        return $query->whereHas('applications', function (Builder $applications) use ($supervisorProfileId, $status, $completedStatuses, $onHoldStatuses, $today): void {
            $applications
                ->where('status', 'accepted')
                ->whereHas('internship', function (Builder $internship) use ($supervisorProfileId, $status, $completedStatuses, $onHoldStatuses, $today): void {
                    $internship->where('supervisor_profile_id', $supervisorProfileId);

                    if ($status === 'completed') {
                        $internship->where(function (Builder $nested) use ($completedStatuses, $today): void {
                            $nested
                                ->whereIn('status', $completedStatuses)
                                ->orWhereDate('end_date', '<', $today);
                        });

                        return;
                    }

                    if ($status === 'on_hold') {
                        $internship->whereIn('status', $onHoldStatuses);

                        return;
                    }

                    if ($status === 'active') {
                        $internship
                            ->whereNotIn('status', array_merge($completedStatuses, $onHoldStatuses))
                            ->where(function (Builder $nested) use ($today): void {
                                $nested->whereNull('end_date')->orWhereDate('end_date', '>=', $today);
                            });
                    }
                });
        });
    }

    private function applySearchFilter(Builder $query, int $supervisorProfileId): Builder
    {
        $term = trim($this->search);

        if ($term === '') {
            return $query;
        }

        $like = '%' . $this->escapeLike($term) . '%';

        return $query->where(function (Builder $nested) use ($like, $supervisorProfileId): void {
            $nested
                ->where('department', 'like', $like)
                ->orWhere('university', 'like', $like)
                ->orWhereHas('user', function (Builder $userQuery) use ($like): void {
                    $userQuery
                        ->where('name', 'like', $like)
                        ->orWhere('email', 'like', $like)
                        ->orWhere('matricule', 'like', $like);
                })
                ->orWhereHas('applications', function (Builder $applications) use ($like, $supervisorProfileId): void {
                    $applications
                        ->where('status', 'accepted')
                        ->whereHas('internship', function (Builder $internship) use ($like, $supervisorProfileId): void {
                            $internship
                                ->where('supervisor_profile_id', $supervisorProfileId)
                                ->where(function (Builder $internshipNested) use ($like): void {
                                    $internshipNested
                                        ->where('title', 'like', $like)
                                        ->orWhereHas('companyProfile', fn (Builder $company) => $company->where('company_name', 'like', $like));
                                });
                        });
                });
        });
    }

    private function selectedApplication(StudentProfile $profile): ?Application
    {
        $application = $profile->applications->first();

        return $application instanceof Application ? $application : null;
    }

    private function stats(Collection $internshipIds): array
    {
        if ($internshipIds->isEmpty()) {
            return [
                'total' => 0,
                'active' => 0,
                'completed' => 0,
                'on_hold' => 0,
            ];
        }

        $base = Application::query()
            ->whereIn('internship_id', $internshipIds)
            ->where('status', 'accepted');

        $completedStatuses = ['closed', 'completed', 'finished'];
        $onHoldStatuses = ['paused', 'on_hold', 'hold'];
        $today = now()->toDateString();

        $total = (clone $base)
            ->distinct('student_profile_id')
            ->count('student_profile_id');

        $completed = (clone $base)
            ->whereHas('internship', function (Builder $internship) use ($completedStatuses, $today): void {
                $internship->where(function (Builder $nested) use ($completedStatuses, $today): void {
                    $nested
                        ->whereIn('status', $completedStatuses)
                        ->orWhereDate('end_date', '<', $today);
                });
            })
            ->distinct('student_profile_id')
            ->count('student_profile_id');

        $onHold = (clone $base)
            ->whereHas('internship', fn (Builder $internship) => $internship->whereIn('status', $onHoldStatuses))
            ->distinct('student_profile_id')
            ->count('student_profile_id');

        $active = (clone $base)
            ->whereHas('internship', function (Builder $internship) use ($completedStatuses, $onHoldStatuses, $today): void {
                $internship
                    ->whereNotIn('status', array_merge($completedStatuses, $onHoldStatuses))
                    ->where(function (Builder $nested) use ($today): void {
                        $nested->whereNull('end_date')->orWhereDate('end_date', '>=', $today);
                    });
            })
            ->distinct('student_profile_id')
            ->count('student_profile_id');

        return [
            'total' => $total,
            'active' => $active,
            'completed' => $completed,
            'on_hold' => $onHold,
        ];
    }

    private function programOptions(int $supervisorProfileId): array
    {
        return StudentProfile::query()
            ->whereHas('applications', function (Builder $applications) use ($supervisorProfileId): void {
                $applications
                    ->where('status', 'accepted')
                    ->whereHas('internship', fn (Builder $q) => $q->where('supervisor_profile_id', $supervisorProfileId));
            })
            ->select('department')
            ->whereNotNull('department')
            ->where('department', '!=', '')
            ->distinct()
            ->orderBy('department')
            ->pluck('department')
            ->values()
            ->all();
    }

    private function taskTotals(Collection $studentProfileIds, Collection $internshipIds): array
    {
        if ($studentProfileIds->isEmpty() || $internshipIds->isEmpty()) {
            return [];
        }

        return Task::query()
            ->selectRaw('student_profile_id, internship_id, count(*) as total, sum(case when status = ? then 1 else 0 end) as completed', ['completed'])
            ->whereIn('student_profile_id', $studentProfileIds)
            ->whereIn('internship_id', $internshipIds)
            ->groupBy('student_profile_id', 'internship_id')
            ->get()
            ->mapWithKeys(function ($row): array {
                $key = $this->pairKey((int) $row->student_profile_id, (int) $row->internship_id);

                return [
                    $key => [
                        'total' => (int) ($row->total ?? 0),
                        'completed' => (int) ($row->completed ?? 0),
                    ],
                ];
            })
            ->all();
    }

    private function taskLastActivity(Collection $studentProfileIds, Collection $internshipIds): array
    {
        if ($studentProfileIds->isEmpty() || $internshipIds->isEmpty()) {
            return [];
        }

        return Task::query()
            ->selectRaw('student_profile_id, internship_id, max(updated_at) as last_activity')
            ->whereIn('student_profile_id', $studentProfileIds)
            ->whereIn('internship_id', $internshipIds)
            ->groupBy('student_profile_id', 'internship_id')
            ->get()
            ->mapWithKeys(function ($row): array {
                $key = $this->pairKey((int) $row->student_profile_id, (int) $row->internship_id);
                $value = $row->last_activity ? Carbon::parse($row->last_activity) : null;

                return [$key => $value];
            })
            ->all();
    }

    private function logbookLastActivity(Collection $studentProfileIds, Collection $internshipIds): array
    {
        if ($studentProfileIds->isEmpty() || $internshipIds->isEmpty()) {
            return [];
        }

        return Logbook::query()
            ->selectRaw('student_profile_id, internship_id, max(updated_at) as last_activity')
            ->whereIn('student_profile_id', $studentProfileIds)
            ->whereIn('internship_id', $internshipIds)
            ->groupBy('student_profile_id', 'internship_id')
            ->get()
            ->mapWithKeys(function ($row): array {
                $key = $this->pairKey((int) $row->student_profile_id, (int) $row->internship_id);
                $value = $row->last_activity ? Carbon::parse($row->last_activity) : null;

                return [$key => $value];
            })
            ->all();
    }

    private function internshipStatusKey(?Internship $internship): string
    {
        if (! $internship) {
            return 'active';
        }

        $status = strtolower(trim((string) ($internship->status ?? '')));

        $completedStatuses = ['closed', 'completed', 'finished'];
        $onHoldStatuses = ['paused', 'on_hold', 'hold'];

        if (in_array($status, $onHoldStatuses, true)) {
            return 'on_hold';
        }

        $end = $internship->end_date ? Carbon::parse($internship->end_date) : null;

        if ($end && $end->isPast()) {
            return 'completed';
        }

        if (in_array($status, $completedStatuses, true)) {
            return 'completed';
        }

        return 'active';
    }

    private function statusBadge(string $key): array
    {
        return match ($key) {
            'completed' => [
                'label' => 'Completed',
                'class' => 'bg-info-50 text-info-700 ring-1 ring-inset ring-info-200',
            ],
            'on_hold' => [
                'label' => 'On Hold',
                'class' => 'bg-warning-50 text-warning-700 ring-1 ring-inset ring-warning-200',
            ],
            default => [
                'label' => 'Active',
                'class' => 'bg-success-50 text-success-700 ring-1 ring-inset ring-success-200',
            ],
        };
    }

    private function pairKey(int $studentProfileId, ?int $internshipId): string
    {
        return $studentProfileId . ':' . ($internshipId ?? 0);
    }

    private function maxDate(array $values): ?Carbon
    {
        $dates = collect($values)
            ->filter(fn ($value): bool => $value instanceof Carbon);

        return $dates->isEmpty() ? null : $dates->max();
    }

    private function escapeLike(string $value): string
    {
        return addcslashes($value, "\\%_");
    }
}
