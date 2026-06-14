<?php

namespace App\Livewire\Supervisor;

use App\Livewire\Concerns\QueuesExports;
use App\Models\Application;
use App\Models\CompanyProfile;
use App\Models\Evaluation;
use App\Models\Internship;
use App\Models\Report;
use App\Models\SupervisorProfile;
use App\Models\Task;
use App\Services\ReportService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ReportsReview extends Component
{
    use WithPagination;
    use QueuesExports;

    #[Url]
    public string $tab = 'standard';

    #[Url]
    public string $from = '';

    #[Url]
    public string $to = '';

    #[Url]
    public string $internship = '';

    #[Url]
    public string $company = '';

    #[Url]
    public string $supervisor = '';

    #[Url]
    public string $customReportType = '';

    #[Url]
    public int $perPage = 10;

    public function mount(): void
    {
        if (! in_array($this->tab, ['standard', 'custom', 'saved'], true)) {
            $this->tab = 'standard';
        }

        $supervisorProfileId = $this->ensureSupervisorProfile()->id;

        if ($this->supervisor === '' || (int) $this->supervisor !== $supervisorProfileId) {
            $this->supervisor = (string) $supervisorProfileId;
        }

        if ($this->customReportType === '') {
            $this->customReportType = (string) $this->defaultCustomReportType();
        }
    }

    public function updatedTab(): void
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

    public function updatedInternship(): void
    {
        $this->resetPage();
    }

    public function updatedCompany(): void
    {
        $this->resetPage();
    }

    public function updatedSupervisor(): void
    {
        $this->resetPage();

        $supervisorProfileId = $this->ensureSupervisorProfile()->id;
        $this->supervisor = (string) $supervisorProfileId;
    }

    public function updatedCustomReportType(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function selectDefinition(string $type): void
    {
        $this->customReportType = $type;
        $this->tab = 'custom';
    }

    public function exportCustomReport(): void
    {
        $supervisorProfileId = $this->ensureSupervisorProfile()->id;

        $filters = [
            'supervisor_profile_id' => $supervisorProfileId,
            'internship_id' => $this->internship,
            'company_id' => $this->company,
            'from' => $this->from,
            'to' => $this->to,
            'type' => $this->customReportType,
        ];

        if ($filters['type'] === '') {
            unset($filters['type']);
        }

        $this->queueExport('reports', $filters, 'Report export queued.');
    }

    public function render(): View
    {
        $supervisorProfile = $this->ensureSupervisorProfile();

        $internships = Internship::query()
            ->where('supervisor_profile_id', $supervisorProfile->id)
            ->orderBy('title')
            ->get(['id', 'title', 'company_profile_id']);

        $companies = CompanyProfile::query()
            ->whereIn('id', $internships->pluck('company_profile_id')->filter()->unique()->values())
            ->orderBy('company_name')
            ->get(['id', 'company_name']);

        $supervisors = SupervisorProfile::query()
            ->whereKey($supervisorProfile->id)
            ->with('user')
            ->get();

        $reportDefinitions = app(ReportService::class)->supervisorReportDefinitions();
        $tabs = $this->tabsPayload($supervisorProfile->id, $reportDefinitions);

        return view('livewire.supervisor.reports-review', [
            'title' => 'Reports Review',
            'tabs' => $tabs,
            'internships' => $internships,
            'companies' => $companies,
            'supervisors' => $supervisors,
            'reportDefinitions' => $reportDefinitions,
            'metrics' => $this->metricsPayload($supervisorProfile->id),
            'customReports' => $this->tab === 'custom' ? $this->reportsPaginator($supervisorProfile->id) : null,
            'savedReports' => $this->tab === 'saved' ? $this->savedPaginator($supervisorProfile->id) : null,
            'panel' => $this->panelPayload($supervisorProfile->id),
        ])->extends('layouts.dashboard')->section('content');
    }

    private function ensureSupervisorProfile(): SupervisorProfile
    {
        $user = auth()->user();

        return SupervisorProfile::query()->firstOrCreate([
            'user_id' => $user?->id,
        ]);
    }

    private function defaultCustomReportType(): string
    {
        $definitions = app(ReportService::class)->supervisorReportDefinitions();

        $first = collect($definitions)->first();
        $type = is_array($first) ? (string) ($first['type'] ?? '') : '';

        return $type !== '' ? $type : 'monthly';
    }

    private function tabsPayload(int $supervisorProfileId, array $definitions): array
    {
        $customCount = $this->reportsQueryForPanel($supervisorProfileId)->count();

        $savedCount = $this->reportsQueryForPanel($supervisorProfileId)
            ->where('status', 'ready')
            ->count();

        return [
            [
                'key' => 'standard',
                'label' => 'Standard',
                'count' => count($definitions),
            ],
            [
                'key' => 'custom',
                'label' => 'Custom',
                'count' => $customCount,
            ],
            [
                'key' => 'saved',
                'label' => 'Saved',
                'count' => $savedCount,
            ],
        ];
    }

    private function reportsPaginator(int $supervisorProfileId): LengthAwarePaginator
    {
        $perPage = max(5, min(50, $this->perPage));

        $query = $this->reportsQuery($supervisorProfileId);

        if ($this->customReportType !== '') {
            $query->where('type', $this->customReportType);
        }

        $paginator = $query
            ->orderByDesc(DB::raw('coalesce(generated_at, created_at)'))
            ->orderByDesc('id')
            ->paginate($perPage);

        $paginator->setCollection(
            $paginator->getCollection()->map(fn (Report $report): array => $this->presentReportRow($report))
        );

        return $paginator;
    }

    private function savedPaginator(int $supervisorProfileId): LengthAwarePaginator
    {
        $perPage = max(5, min(50, $this->perPage));

        $paginator = $this->reportsQuery($supervisorProfileId)
            ->where('status', 'ready')
            ->orderByDesc(DB::raw('coalesce(generated_at, created_at)'))
            ->orderByDesc('id')
            ->paginate($perPage);

        $paginator->setCollection(
            $paginator->getCollection()->map(fn (Report $report): array => $this->presentReportRow($report))
        );

        return $paginator;
    }

    private function reportsQuery(int $supervisorProfileId): Builder
    {
        $query = Report::query()
            ->with(['studentProfile.user', 'internship.companyProfile'])
            ->whereHas('internship', fn (Builder $builder): Builder => $builder->where('supervisor_profile_id', $supervisorProfileId));

        if ($this->internship !== '') {
            $query->where('internship_id', (int) $this->internship);
        }

        if ($this->company !== '') {
            $companyId = (int) $this->company;
            $query->whereHas('internship', fn (Builder $builder): Builder => $builder->where('company_profile_id', $companyId));
        }

        if ($this->from !== '') {
            $query->where(function (Builder $builder): void {
                $builder->whereDate('generated_at', '>=', $this->from)
                    ->orWhereDate('created_at', '>=', $this->from);
            });
        }

        if ($this->to !== '') {
            $query->where(function (Builder $builder): void {
                $builder->whereDate('generated_at', '<=', $this->to)
                    ->orWhereDate('created_at', '<=', $this->to);
            });
        }

        return $query;
    }

    private function presentReportRow(Report $report): array
    {
        $student = $report->studentProfile?->user;
        $studentName = (string) ($student?->name ?? 'Student');
        $studentEmail = (string) ($student?->email ?? '');
        $initial = strtoupper(substr($studentName, 0, 1));
        $initial = $initial !== '' ? $initial : 'S';

        $generatedAt = $report->generated_at ?: $report->created_at;
        $generatedLabel = $generatedAt ? $generatedAt->format('M j, Y') : '—';

        $type = (string) ($report->type ?? '');

        return [
            'id' => $report->id,
            'name' => (string) $report->name,
            'type' => $type !== '' ? $type : '—',
            'status' => (string) $report->status,
            'student_name' => $studentName,
            'student_email' => $studentEmail !== '' ? $studentEmail : '—',
            'student_initial' => $initial,
            'internship_title' => (string) ($report->internship?->title ?? '—'),
            'company_name' => (string) ($report->internship?->companyProfile?->company_name ?? '—'),
            'generated_label' => $generatedLabel,
        ];
    }

    private function metricsPayload(int $supervisorProfileId): array
    {
        $applications = $this->applicationsBaseQuery($supervisorProfileId);

        if ($this->internship !== '') {
            $applications->where('internship_id', (int) $this->internship);
        }

        if ($this->company !== '') {
            $companyId = (int) $this->company;
            $applications->whereHas('internship', fn (Builder $builder): Builder => $builder->where('company_profile_id', $companyId));
        }

        $expr = $this->lastActivityExpression();
        [$activeCutoff, $inactiveCutoff] = $this->activityCutoffs();

        $active = (clone $applications)->whereRaw($expr . ' >= ?', [$activeCutoff])->count();
        $inactive = (clone $applications)->whereRaw($expr . ' < ? and ' . $expr . ' >= ?', [$activeCutoff, $inactiveCutoff])->count();
        $notActive = (clone $applications)->whereRaw($expr . ' < ?', [$inactiveCutoff])->count();
        $total = (clone $applications)->count();

        [$startDate, $endDate, $startTs, $endTs] = $this->dateRangeWindow();

        $tasksCompleted = Task::query()
            ->whereNotNull('completed_at')
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
            ->when($startTs !== null, fn (Builder $builder): Builder => $builder->where('completed_at', '>=', $startTs))
            ->when($endTs !== null, fn (Builder $builder): Builder => $builder->where('completed_at', '<=', $endTs))
            ->count();

        $avgScore = Evaluation::query()
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
                    ->whereColumn('applications.student_profile_id', 'evaluations.student_profile_id')
                    ->whereColumn('applications.internship_id', 'evaluations.internship_id')
                    ->where('applications.status', 'accepted');
            })
            ->when($startTs !== null, fn (Builder $builder): Builder => $builder->where('evaluated_at', '>=', $startTs))
            ->when($endTs !== null, fn (Builder $builder): Builder => $builder->where('evaluated_at', '<=', $endTs))
            ->avg('score');

        return [
            'total_interns' => $total,
            'active' => $active,
            'inactive' => $inactive + $notActive,
            'tasks_completed' => $tasksCompleted,
            'avg_evaluation_score' => $avgScore !== null ? round((float) $avgScore, 1) : 0,
            'range_label' => $startDate && $endDate ? $startDate->format('M j') . ' - ' . $endDate->format('M j') : null,
        ];
    }

    private function applicationsBaseQuery(int $supervisorProfileId): Builder
    {
        return Application::query()
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

    private function panelPayload(int $supervisorProfileId): array
    {
        $base = $this->reportsQueryForPanel($supervisorProfileId);

        $typeCounts = (clone $base)
            ->selectRaw('coalesce(type, ?) as report_type, count(*) as total', ['other'])
            ->groupBy('report_type')
            ->orderByDesc('total')
            ->get()
            ->mapWithKeys(fn ($row): array => [(string) $row->report_type => (int) $row->total])
            ->all();

        $segments = collect($typeCounts)
            ->map(function (int $count, string $type): array {
                $palette = [
                    'monthly' => ['#60A5FA', 'bg-info-400'],
                    'technical' => ['#34D399', 'bg-success-400'],
                    'final' => ['#FBBF24', 'bg-warning-400'],
                    'other' => ['#CBD5E1', 'bg-neutral-300'],
                ];

                [$color, $legend] = $palette[$type] ?? $palette['other'];

                return [
                    'label' => ucfirst($type),
                    'key' => $type,
                    'count' => $count,
                    'color' => $color,
                    'legend_class' => $legend,
                ];
            })
            ->values()
            ->all();

        $total = (int) collect($segments)->sum('count');

        $segments = collect($segments)
            ->map(function (array $segment) use ($total): array {
                $segment['percent'] = $total > 0 ? (int) round(($segment['count'] / $total) * 100) : 0;
                return $segment;
            })
            ->all();

        $donutStyle = $this->donutStyle($segments);

        $popular = (clone $base)
            ->selectRaw('name, count(*) as total')
            ->groupBy('name')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(fn ($row): array => [
                'name' => (string) $row->name,
                'count' => (int) $row->total,
            ])
            ->all();

        $recent = (clone $base)
            ->with(['studentProfile.user', 'internship.companyProfile'])
            ->orderByDesc(DB::raw('coalesce(generated_at, created_at)'))
            ->limit(5)
            ->get()
            ->map(fn (Report $report): array => $this->presentRecentRow($report))
            ->all();

        return [
            'total_reports' => $total,
            'donut' => [
                'segments' => $segments,
                'style' => $donutStyle,
            ],
            'popular' => $popular,
            'recent' => $recent,
        ];
    }

    private function reportsQueryForPanel(int $supervisorProfileId): Builder
    {
        $query = Report::query()
            ->whereHas('internship', fn (Builder $builder): Builder => $builder->where('supervisor_profile_id', $supervisorProfileId));

        if ($this->internship !== '') {
            $query->where('internship_id', (int) $this->internship);
        }

        if ($this->company !== '') {
            $query->whereHas('internship', fn (Builder $builder): Builder => $builder->where('company_profile_id', (int) $this->company));
        }

        if ($this->from !== '') {
            $query->where(function (Builder $builder): void {
                $builder->whereDate('generated_at', '>=', $this->from)
                    ->orWhereDate('created_at', '>=', $this->from);
            });
        }

        if ($this->to !== '') {
            $query->where(function (Builder $builder): void {
                $builder->whereDate('generated_at', '<=', $this->to)
                    ->orWhereDate('created_at', '<=', $this->to);
            });
        }

        return $query;
    }

    private function presentRecentRow(Report $report): array
    {
        $student = $report->studentProfile?->user;
        $studentName = (string) ($student?->name ?? 'Student');

        $stamp = $report->generated_at ?: $report->created_at;
        $timeLabel = $stamp ? $stamp->diffForHumans() : '—';

        return [
            'name' => (string) $report->name,
            'student_name' => $studentName,
            'internship_title' => (string) ($report->internship?->title ?? '—'),
            'company_name' => (string) ($report->internship?->companyProfile?->company_name ?? '—'),
            'time_label' => $timeLabel,
        ];
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

    private function dateRangeWindow(): array
    {
        $startDate = $this->from !== '' ? Carbon::parse($this->from)->startOfDay() : null;
        $endDate = $this->to !== '' ? Carbon::parse($this->to)->endOfDay() : null;

        return [
            $startDate,
            $endDate,
            $startDate?->format('Y-m-d H:i:s'),
            $endDate?->format('Y-m-d H:i:s'),
        ];
    }
}
