<?php

namespace App\Livewire\Supervisor;

use App\Livewire\Concerns\QueuesExports;
use App\Models\Application;
use App\Models\CompanyProfile;
use App\Models\Internship;
use App\Models\Logbook;
use App\Models\SupervisorProfile;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class InternshipMonitoring extends Component
{
    use WithPagination;
    use QueuesExports;

    #[Url]
    public string $search = '';

    #[Url]
    public string $internship = '';

    #[Url]
    public string $company = '';

    #[Url]
    public string $status = '';

    #[Url]
    public int $perPage = 10;

    public function mount(): void
    {
        if (! in_array($this->status, ['', 'active', 'inactive', 'not_active'], true)) {
            $this->status = '';
        }
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedInternship(): void
    {
        $this->resetPage();
    }

    public function updatedCompany(): void
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
        $supervisorProfileId = $this->ensureSupervisorProfile()->id;

        $filters = [
            'supervisor_profile_id' => $supervisorProfileId,
            'internship_id' => $this->internship,
            'company_id' => $this->company,
            'status_bucket' => $this->status,
            'q' => $this->search,
        ];

        $this->queueExport('monitoring', $filters, 'Monitoring report queued.');
    }

    public function render(): View
    {
        $supervisorProfile = $this->ensureSupervisorProfile();

        $internships = Internship::query()
            ->where('supervisor_profile_id', $supervisorProfile->id)
            ->orderBy('title')
            ->get(['id', 'title']);

        $companies = CompanyProfile::query()
            ->whereIn(
                'id',
                Internship::query()
                    ->where('supervisor_profile_id', $supervisorProfile->id)
                    ->select('company_profile_id')
            )
            ->orderBy('company_name')
            ->get(['id', 'company_name']);

        return view('livewire.supervisor.internship-monitoring', [
            'title' => 'Internship Monitoring',
            'rows' => $this->applicationsPaginator($supervisorProfile->id),
            'internships' => $internships,
            'companies' => $companies,
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

    private function applicationsPaginator(int $supervisorProfileId): LengthAwarePaginator
    {
        $perPage = max(5, min(50, $this->perPage));

        $paginator = $this->applicationsQuery($supervisorProfileId)->paginate($perPage);

        $stats = $this->pageStats($paginator->getCollection());

        $paginator->setCollection(
            $paginator->getCollection()->map(function (Application $application) use ($stats): array {
                $studentId = (int) $application->student_profile_id;
                $internshipId = (int) $application->internship_id;
                $key = $studentId . ':' . $internshipId;

                return $this->presentRow(
                    $application,
                    $stats['tasks'][$key] ?? null,
                    $stats['logbooks'][$key] ?? null
                );
            })
        );

        return $paginator;
    }

    private function applicationsQuery(int $supervisorProfileId): Builder
    {
        $query = $this->applicationsBaseQuery($supervisorProfileId)
            ->select('applications.*')
            ->addSelect(DB::raw($this->lastActivityExpression() . ' as last_activity_at'));

        if (trim($this->search) !== '') {
            $q = trim($this->search);

            $query->where(function (Builder $builder) use ($q): void {
                $builder
                    ->whereHas('studentProfile.user', fn (Builder $user): Builder => $user
                        ->where('name', 'like', '%' . addcslashes($q, "\\%_") . '%')
                        ->orWhere('email', 'like', '%' . addcslashes($q, "\\%_") . '%'))
                    ->orWhereHas('internship', fn (Builder $internship): Builder => $internship->where('title', 'like', '%' . addcslashes($q, "\\%_") . '%'))
                    ->orWhereHas('internship.companyProfile', fn (Builder $company): Builder => $company->where('company_name', 'like', '%' . addcslashes($q, "\\%_") . '%'));
            });
        }

        if ($this->internship !== '') {
            $query->where('internship_id', (int) $this->internship);
        }

        if ($this->company !== '') {
            $companyId = (int) $this->company;
            $query->whereHas('internship', fn (Builder $builder): Builder => $builder->where('company_profile_id', $companyId));
        }

        if ($this->status !== '') {
            [$activeCutoff, $inactiveCutoff] = $this->activityCutoffs();
            $expr = $this->lastActivityExpression();

            if ($this->status === 'active') {
                $query->whereRaw($expr . ' >= ?', [$activeCutoff]);
            } elseif ($this->status === 'inactive') {
                $query->whereRaw($expr . ' < ? and ' . $expr . ' >= ?', [$activeCutoff, $inactiveCutoff]);
            } elseif ($this->status === 'not_active') {
                $query->whereRaw($expr . ' < ?', [$inactiveCutoff]);
            }
        }

        return $query
            ->orderByDesc('last_activity_at')
            ->orderByDesc('id');
    }

    private function applicationsBaseQuery(int $supervisorProfileId): Builder
    {
        return Application::query()
            ->with(['studentProfile.user', 'internship.companyProfile'])
            ->where('status', 'accepted')
            ->whereHas('internship', fn (Builder $builder): Builder => $builder->where('supervisor_profile_id', $supervisorProfileId));
    }

    private function lastActivityExpression(): string
    {
        $driver = DB::connection()->getDriverName();

        $taskSub = "(select max(updated_at) from tasks where tasks.student_profile_id = applications.student_profile_id and tasks.internship_id = applications.internship_id)";
        $logSub = "(select max(entry_date) from logbooks where logbooks.student_profile_id = applications.student_profile_id and logbooks.internship_id = applications.internship_id)";

        if ($driver === 'mysql' || $driver === 'mariadb') {
            return "greatest(coalesce($taskSub, '1970-01-01 00:00:00'), coalesce(concat($logSub, ' 00:00:00'), '1970-01-01 00:00:00'))";
        }

        if ($driver === 'pgsql') {
            return "greatest(coalesce($taskSub, '1970-01-01 00:00:00'), coalesce($logSub, '1970-01-01 00:00:00'))";
        }

        return "max(coalesce($taskSub, '1970-01-01 00:00:00'), coalesce(datetime($logSub), '1970-01-01 00:00:00'))";
    }

    private function activityCutoffs(): array
    {
        $active = Carbon::now()->subDays(7)->format('Y-m-d H:i:s');
        $inactive = Carbon::now()->subDays(15)->format('Y-m-d H:i:s');

        return [$active, $inactive];
    }

    private function pageStats($applications): array
    {
        $studentIds = $applications->pluck('student_profile_id')->filter()->unique()->values();
        $internshipIds = $applications->pluck('internship_id')->filter()->unique()->values();

        $window = $this->thisWeekWindow();

        $tasks = Task::query()
            ->selectRaw(
                "student_profile_id, internship_id, count(*) as total, sum(case when status = 'completed' then 1 else 0 end) as completed, sum(case when completed_at >= ? and completed_at <= ? then 1 else 0 end) as completed_this_week, max(updated_at) as last_activity",
                [$window['start'], $window['end']]
            )
            ->whereIn('student_profile_id', $studentIds)
            ->whereIn('internship_id', $internshipIds)
            ->groupBy('student_profile_id', 'internship_id')
            ->get()
            ->mapWithKeys(function ($row): array {
                $key = (int) $row->student_profile_id . ':' . (int) $row->internship_id;

                return [
                    $key => [
                        'total' => (int) $row->total,
                        'completed' => (int) $row->completed,
                        'completed_this_week' => (int) $row->completed_this_week,
                        'last_activity' => $row->last_activity,
                    ],
                ];
            })
            ->all();

        $logbooks = Logbook::query()
            ->selectRaw(
                "student_profile_id, internship_id, count(*) as total, sum(case when status = 'approved' then 1 else 0 end) as approved, sum(case when entry_date >= ? and entry_date <= ? then 1 else 0 end) as this_week, max(entry_date) as last_entry",
                [$window['start_date'], $window['end_date']]
            )
            ->whereIn('student_profile_id', $studentIds)
            ->whereIn('internship_id', $internshipIds)
            ->groupBy('student_profile_id', 'internship_id')
            ->get()
            ->mapWithKeys(function ($row): array {
                $key = (int) $row->student_profile_id . ':' . (int) $row->internship_id;

                return [
                    $key => [
                        'total' => (int) $row->total,
                        'approved' => (int) $row->approved,
                        'this_week' => (int) $row->this_week,
                        'last_entry' => $row->last_entry,
                    ],
                ];
            })
            ->all();

        return [
            'tasks' => $tasks,
            'logbooks' => $logbooks,
        ];
    }

    private function presentRow(Application $application, ?array $taskStats, ?array $logbookStats): array
    {
        $student = $application->studentProfile?->user;

        $name = (string) ($student?->name ?? 'Student');
        $email = (string) ($student?->email ?? '');
        $initial = strtoupper(substr($name, 0, 1));
        $initial = $initial !== '' ? $initial : 'S';

        $internshipTitle = (string) ($application->internship?->title ?? '');
        $company = (string) ($application->internship?->companyProfile?->company_name ?? '');

        $taskLast = isset($taskStats['last_activity']) && $taskStats['last_activity'] ? Carbon::parse($taskStats['last_activity']) : null;
        $logLast = isset($logbookStats['last_entry']) && $logbookStats['last_entry'] ? Carbon::parse($logbookStats['last_entry']) : null;

        $last = null;

        if ($taskLast && $logLast) {
            $last = $taskLast->greaterThan($logLast) ? $taskLast : $logLast;
        } else {
            $last = $taskLast ?: $logLast;
        }

        $bucket = $this->statusBucket($last);

        $logbookWeek = (int) ($logbookStats['this_week'] ?? 0);
        $logbookPercent = min(100, (int) round(($logbookWeek / 5) * 100));

        $tasksTotal = (int) ($taskStats['total'] ?? 0);
        $tasksCompleted = (int) ($taskStats['completed'] ?? 0);
        $tasksPercent = $tasksTotal > 0 ? min(100, (int) round(($tasksCompleted / $tasksTotal) * 100)) : 0;

        $activityParts = [];
        if ($logLast) {
            $activityParts[] = 'Logbook ' . $logLast->diffForHumans();
        }
        if ($taskLast) {
            $activityParts[] = 'Task ' . $taskLast->diffForHumans();
        }

        return [
            'application_id' => $application->id,
            'student_name' => $name,
            'student_email' => $email !== '' ? $email : '—',
            'student_initial' => $initial,
            'internship_title' => $internshipTitle !== '' ? $internshipTitle : '—',
            'company_name' => $company !== '' ? $company : '—',
            'status_key' => $bucket['key'],
            'status_label' => $bucket['label'],
            'status_class' => $bucket['class'],
            'last_active_label' => $last ? $last->diffForHumans() : '—',
            'activity_summary' => $activityParts !== [] ? implode(' • ', $activityParts) : 'No recent activity.',
            'logbooks_total' => (int) ($logbookStats['total'] ?? 0),
            'logbooks_approved' => (int) ($logbookStats['approved'] ?? 0),
            'logbooks_week' => $logbookWeek,
            'logbooks_week_percent' => $logbookPercent,
            'tasks_total' => $tasksTotal,
            'tasks_completed' => $tasksCompleted,
            'tasks_percent' => $tasksPercent,
        ];
    }

    private function statusBucket(?Carbon $lastActive): array
    {
        if (! $lastActive) {
            return [
                'key' => 'not_active',
                'label' => 'Not Active (15+ days)',
                'class' => 'bg-danger-50 text-danger-700 ring-danger-100',
            ];
        }

        $days = $lastActive->diffInDays(Carbon::now());

        if ($days <= 7) {
            return [
                'key' => 'active',
                'label' => 'Active',
                'class' => 'bg-success-50 text-success-700 ring-success-100',
            ];
        }

        if ($days <= 15) {
            return [
                'key' => 'inactive',
                'label' => 'Inactive (7+ days)',
                'class' => 'bg-warning-50 text-warning-700 ring-warning-100',
            ];
        }

        return [
            'key' => 'not_active',
            'label' => 'Not Active (15+ days)',
            'class' => 'bg-danger-50 text-danger-700 ring-danger-100',
        ];
    }

    private function thisWeekWindow(): array
    {
        $start = Carbon::now()->startOfWeek();
        $end = Carbon::now()->endOfWeek();

        return [
            'start' => $start->format('Y-m-d H:i:s'),
            'end' => $end->format('Y-m-d H:i:s'),
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
        ];
    }

    private function summaryPayload(int $supervisorProfileId): array
    {
        $base = $this->applicationsBaseQuery($supervisorProfileId);

        if (trim($this->search) !== '') {
            $q = trim($this->search);

            $base->where(function (Builder $builder) use ($q): void {
                $builder
                    ->whereHas('studentProfile.user', fn (Builder $user): Builder => $user
                        ->where('name', 'like', '%' . addcslashes($q, "\\%_") . '%')
                        ->orWhere('email', 'like', '%' . addcslashes($q, "\\%_") . '%'))
                    ->orWhereHas('internship', fn (Builder $internship): Builder => $internship->where('title', 'like', '%' . addcslashes($q, "\\%_") . '%'))
                    ->orWhereHas('internship.companyProfile', fn (Builder $company): Builder => $company->where('company_name', 'like', '%' . addcslashes($q, "\\%_") . '%'));
            });
        }

        if ($this->internship !== '') {
            $base->where('internship_id', (int) $this->internship);
        }

        if ($this->company !== '') {
            $companyId = (int) $this->company;
            $base->whereHas('internship', fn (Builder $builder): Builder => $builder->where('company_profile_id', $companyId));
        }

        [$activeCutoff, $inactiveCutoff] = $this->activityCutoffs();
        $expr = $this->lastActivityExpression();

        $active = (clone $base)->whereRaw($expr . ' >= ?', [$activeCutoff])->count();
        $inactive = (clone $base)->whereRaw($expr . ' < ? and ' . $expr . ' >= ?', [$activeCutoff, $inactiveCutoff])->count();
        $notActive = (clone $base)->whereRaw($expr . ' < ?', [$inactiveCutoff])->count();
        $total = (clone $base)->count();

        $week = $this->thisWeekWindow();

        $logbooksThisWeek = Logbook::query()
            ->whereDate('entry_date', '>=', $week['start_date'])
            ->whereDate('entry_date', '<=', $week['end_date'])
            ->whereHas('internship', function (Builder $builder) use ($supervisorProfileId): Builder {
                $builder->where('supervisor_profile_id', $supervisorProfileId);

                if ($this->internship !== '') {
                    $builder->whereKey((int) $this->internship);
                }

                if ($this->company !== '') {
                    $builder->where('company_profile_id', (int) $this->company);
                }

                return $builder;
            })
            ->whereExists(function ($builder): void {
                $builder
                    ->selectRaw('1')
                    ->from('applications')
                    ->whereColumn('applications.student_profile_id', 'logbooks.student_profile_id')
                    ->whereColumn('applications.internship_id', 'logbooks.internship_id')
                    ->where('applications.status', 'accepted');
            })
            ->count();

        $tasksCompletedThisWeek = Task::query()
            ->whereNotNull('completed_at')
            ->where('completed_at', '>=', $week['start'])
            ->where('completed_at', '<=', $week['end'])
            ->whereHas('internship', function (Builder $builder) use ($supervisorProfileId): Builder {
                $builder->where('supervisor_profile_id', $supervisorProfileId);

                if ($this->internship !== '') {
                    $builder->whereKey((int) $this->internship);
                }

                if ($this->company !== '') {
                    $builder->where('company_profile_id', (int) $this->company);
                }

                return $builder;
            })
            ->whereExists(function ($builder): void {
                $builder
                    ->selectRaw('1')
                    ->from('applications')
                    ->whereColumn('applications.student_profile_id', 'tasks.student_profile_id')
                    ->whereColumn('applications.internship_id', 'tasks.internship_id')
                    ->where('applications.status', 'accepted');
            })
            ->count();

        return [
            'total' => $total,
            'active' => $active,
            'inactive' => $inactive,
            'not_active' => $notActive,
            'logbooks_this_week' => $logbooksThisWeek,
            'tasks_completed_this_week' => $tasksCompletedThisWeek,
        ];
    }
}
