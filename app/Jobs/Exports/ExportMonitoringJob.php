<?php

namespace App\Jobs\Exports;

use App\Models\Application;
use App\Models\Logbook;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ExportMonitoringJob extends AbstractCsvExportJob
{
    protected function headers(): array
    {
        return [
            'application_id',
            'student_name',
            'student_email',
            'internship_title',
            'company_name',
            'application_status',
            'logbooks_total',
            'logbooks_approved',
            'tasks_total',
            'tasks_completed',
            'last_activity_at',
        ];
    }

    protected function writeRows($handle): void
    {
        $supervisorProfileId = (int) ($this->filters['supervisor_profile_id'] ?? 0);

        if ($supervisorProfileId <= 0) {
            return;
        }

        $query = Application::query()
            ->select('applications.*')
            ->addSelect(DB::raw($this->lastActivityExpression() . ' as last_activity_at'))
            ->with(['studentProfile.user', 'internship.companyProfile'])
            ->whereHas('internship', fn (Builder $builder): Builder => $builder->where('supervisor_profile_id', $supervisorProfileId));

        if (isset($this->filters['application_status']) && $this->filters['application_status'] !== '') {
            $query->where('status', (string) $this->filters['application_status']);
        } else {
            $query->where('status', 'accepted');
        }

        if (isset($this->filters['internship_id']) && $this->filters['internship_id'] !== '') {
            $query->where('internship_id', (int) $this->filters['internship_id']);
        }

        if (isset($this->filters['company_id']) && $this->filters['company_id'] !== '') {
            $companyId = (int) $this->filters['company_id'];
            if ($companyId > 0) {
                $query->whereHas('internship', fn (Builder $builder): Builder => $builder->where('company_profile_id', $companyId));
            }
        }

        if (isset($this->filters['q']) && trim((string) $this->filters['q']) !== '') {
            $q = trim((string) $this->filters['q']);

            $query->where(function (Builder $builder) use ($q): void {
                $builder->whereHas('studentProfile.user', fn (Builder $user): Builder => $user->where('name', 'like', '%' . addcslashes($q, "\\%_") . '%'))
                    ->orWhereHas('internship', fn (Builder $internship): Builder => $internship->where('title', 'like', '%' . addcslashes($q, "\\%_") . '%'))
                    ->orWhereHas('internship.companyProfile', fn (Builder $company): Builder => $company->where('company_name', 'like', '%' . addcslashes($q, "\\%_") . '%'));
            });
        }

        if (isset($this->filters['status_bucket']) && $this->filters['status_bucket'] !== '') {
            $bucket = (string) $this->filters['status_bucket'];
            $expr = $this->lastActivityExpression();
            $activeCutoff = Carbon::now()->subDays(7)->format('Y-m-d H:i:s');
            $inactiveCutoff = Carbon::now()->subDays(15)->format('Y-m-d H:i:s');

            if ($bucket === 'active') {
                $query->whereRaw($expr . ' >= ?', [$activeCutoff]);
            } elseif ($bucket === 'inactive') {
                $query->whereRaw($expr . ' < ? and ' . $expr . ' >= ?', [$activeCutoff, $inactiveCutoff]);
            } elseif ($bucket === 'not_active') {
                $query->whereRaw($expr . ' < ?', [$inactiveCutoff]);
            }
        }

        $query->orderByDesc('last_activity_at')->orderBy('id')->chunk(250, function ($applications) use ($handle): void {
            $studentIds = $applications->pluck('student_profile_id')->filter()->unique()->values();
            $internshipIds = $applications->pluck('internship_id')->filter()->unique()->values();

            $taskStats = $this->taskStats($studentIds, $internshipIds);
            $logbookStats = $this->logbookStats($studentIds, $internshipIds);

            foreach ($applications as $application) {
                $studentId = (int) $application->student_profile_id;
                $internshipId = (int) $application->internship_id;
                $key = $studentId . ':' . $internshipId;

                $task = $taskStats[$key] ?? ['last_activity' => null, 'total' => 0, 'completed' => 0];
                $logbook = $logbookStats[$key] ?? ['last_entry' => null, 'total' => 0, 'approved' => 0];

                $taskLast = $task['last_activity'] ? Carbon::parse($task['last_activity']) : null;
                $logbookLast = $logbook['last_entry'] ? Carbon::parse($logbook['last_entry']) : null;
                $last = null;

                if ($taskLast && $logbookLast) {
                    $last = $taskLast->greaterThan($logbookLast) ? $taskLast : $logbookLast;
                } else {
                    $last = $taskLast ?: $logbookLast;
                }

                fputcsv($handle, [
                    $application->id,
                    (string) ($application->studentProfile?->user?->name ?? ''),
                    (string) ($application->studentProfile?->user?->email ?? ''),
                    (string) ($application->internship?->title ?? ''),
                    (string) ($application->internship?->companyProfile?->company_name ?? ''),
                    (string) $application->status,
                    (int) $logbook['total'],
                    (int) $logbook['approved'],
                    (int) $task['total'],
                    (int) $task['completed'],
                    $last?->format('Y-m-d H:i:s'),
                ]);
            }
        });
    }

    private function taskStats(Collection $studentIds, Collection $internshipIds): array
    {
        if ($studentIds->isEmpty() || $internshipIds->isEmpty()) {
            return [];
        }

        return Task::query()
            ->selectRaw('student_profile_id, internship_id, max(updated_at) as last_activity, count(*) as total, sum(case when status = \'completed\' then 1 else 0 end) as completed')
            ->whereIn('student_profile_id', $studentIds)
            ->whereIn('internship_id', $internshipIds)
            ->groupBy('student_profile_id', 'internship_id')
            ->get()
            ->mapWithKeys(function ($row): array {
                $key = (int) $row->student_profile_id . ':' . (int) $row->internship_id;
                return [
                    $key => [
                        'last_activity' => $row->last_activity,
                        'total' => (int) $row->total,
                        'completed' => (int) $row->completed,
                    ],
                ];
            })
            ->all();
    }

    private function logbookStats(Collection $studentIds, Collection $internshipIds): array
    {
        if ($studentIds->isEmpty() || $internshipIds->isEmpty()) {
            return [];
        }

        return Logbook::query()
            ->selectRaw('student_profile_id, internship_id, max(entry_date) as last_entry, count(*) as total, sum(case when status = \'approved\' then 1 else 0 end) as approved')
            ->whereIn('student_profile_id', $studentIds)
            ->whereIn('internship_id', $internshipIds)
            ->groupBy('student_profile_id', 'internship_id')
            ->get()
            ->mapWithKeys(function ($row): array {
                $key = (int) $row->student_profile_id . ':' . (int) $row->internship_id;
                return [
                    $key => [
                        'last_entry' => $row->last_entry,
                        'total' => (int) $row->total,
                        'approved' => (int) $row->approved,
                    ],
                ];
            })
            ->all();
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
}
