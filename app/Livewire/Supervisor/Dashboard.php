<?php

namespace App\Livewire\Supervisor;

use App\Models\Internship;
use App\Models\Logbook;
use App\Models\StudentProfile;
use App\Models\SupervisorProfile;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class Dashboard extends Component
{
    public function render(): View
    {
        $user = auth()->user();
        $supervisorProfile = SupervisorProfile::query()->firstOrCreate([
            'user_id' => $user?->id,
        ]);

        $internshipIds = Internship::query()
            ->where('supervisor_profile_id', $supervisorProfile->id)
            ->pluck('id');

        $studentProfiles = $this->supervisedStudents($internshipIds);
        $studentProfileIds = $studentProfiles->pluck('id');

        $pendingApprovals = $internshipIds->isEmpty()
            ? 0
            : Logbook::query()
                ->whereIn('internship_id', $internshipIds)
                ->where('status', 'submitted')
                ->count();

        $tasksAssigned = Task::query()
            ->where('assigned_by_user_id', $user?->id)
            ->count();

        $tasksCompleted = Task::query()
            ->where('assigned_by_user_id', $user?->id)
            ->where('status', 'completed')
            ->whereNotNull('completed_at')
            ->whereBetween('completed_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->count();

        $completionRate = $this->completionRate($internshipIds, $studentProfileIds);

        $progress = $this->studentsProgress($internshipIds, $studentProfileIds);
        $pendingLogbooks = $this->pendingLogbooks($internshipIds);
        $upcomingDeadlines = $this->upcomingDeadlines($internshipIds, $studentProfileIds);
        $recentActivity = $this->recentActivity($internshipIds, $studentProfileIds);
        $schedule = $this->scheduleItems();

        return view('livewire.supervisor.dashboard', [
            'title' => 'Supervisor Dashboard',
            'summary' => [
                'greeting' => $this->greeting((string) ($user?->name ?? 'Supervisor')),
                'date_range_label' => $this->dateRangeLabel(),
            ],
            'stats' => [
                'students' => $studentProfiles->count(),
                'pending_approvals' => $pendingApprovals,
                'tasks_assigned' => $tasksAssigned,
                'tasks_completed' => $tasksCompleted,
                'completion_rate' => $completionRate,
            ],
            'progress' => $progress,
            'pending_logbooks' => $pendingLogbooks,
            'upcoming_deadlines' => $upcomingDeadlines,
            'recent_activity' => $recentActivity,
            'schedule' => $schedule,
        ])->extends('layouts.dashboard')->section('content');
    }

    private function supervisedStudents(Collection $internshipIds): Collection
    {
        if ($internshipIds->isEmpty()) {
            return collect();
        }

        return StudentProfile::query()
            ->with(['user'])
            ->whereHas('applications', function ($query) use ($internshipIds): void {
                $query->whereIn('internship_id', $internshipIds)
                    ->where('status', 'accepted');
            })
            ->get();
    }

    private function completionRate(Collection $internshipIds, Collection $studentProfileIds): int
    {
        if ($internshipIds->isEmpty() || $studentProfileIds->isEmpty()) {
            return 0;
        }

        $total = Task::query()
            ->whereIn('internship_id', $internshipIds)
            ->whereIn('student_profile_id', $studentProfileIds)
            ->count();

        if ($total <= 0) {
            return 0;
        }

        $completed = Task::query()
            ->whereIn('internship_id', $internshipIds)
            ->whereIn('student_profile_id', $studentProfileIds)
            ->where('status', 'completed')
            ->count();

        return (int) round(($completed / $total) * 100);
    }

    private function studentsProgress(Collection $internshipIds, Collection $studentProfileIds): array
    {
        $completed = 0;
        $inProgress = 0;
        $notStarted = 0;

        if ($internshipIds->isEmpty() || $studentProfileIds->isEmpty()) {
            return $this->progressPayload($completed, $inProgress, $notStarted);
        }

        $rows = Task::query()
            ->selectRaw('student_profile_id, count(*) as total, sum(case when status = ? then 1 else 0 end) as completed', ['completed'])
            ->whereIn('internship_id', $internshipIds)
            ->whereIn('student_profile_id', $studentProfileIds)
            ->groupBy('student_profile_id')
            ->get();

        $totals = $rows->keyBy('student_profile_id');

        foreach ($studentProfileIds as $studentProfileId) {
            $row = $totals->get($studentProfileId);
            $totalTasks = (int) ($row?->total ?? 0);
            $completedTasks = (int) ($row?->completed ?? 0);

            if ($totalTasks <= 0) {
                $notStarted++;
                continue;
            }

            $ratio = $completedTasks / $totalTasks;

            if ($ratio >= 0.8) {
                $completed++;
            } elseif ($ratio > 0) {
                $inProgress++;
            } else {
                $notStarted++;
            }
        }

        return $this->progressPayload($completed, $inProgress, $notStarted);
    }

    private function progressPayload(int $completed, int $inProgress, int $notStarted): array
    {
        $total = $completed + $inProgress + $notStarted;
        $avg = $total > 0 ? (int) round((($completed * 1.0) + ($inProgress * 0.5)) / $total * 100) : 0;

        $segments = [
            [
                'label' => 'Completed',
                'count' => $completed,
                'color' => '#34D399',
                'legend_class' => 'bg-success-400',
            ],
            [
                'label' => 'In Progress',
                'count' => $inProgress,
                'color' => '#60A5FA',
                'legend_class' => 'bg-info-400',
            ],
            [
                'label' => 'Not Started',
                'count' => $notStarted,
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
            'average' => $avg,
            'total' => $total,
            'segments' => $segments,
            'style' => $this->donutStyle($segments),
        ];
    }

    private function pendingLogbooks(Collection $internshipIds): Collection
    {
        if ($internshipIds->isEmpty()) {
            return collect();
        }

        return Logbook::query()
            ->with(['studentProfile.user', 'internship'])
            ->whereIn('internship_id', $internshipIds)
            ->where('status', 'submitted')
            ->orderByDesc('updated_at')
            ->limit(4)
            ->get()
            ->map(function (Logbook $logbook): array {
                return [
                    'student_name' => (string) ($logbook->studentProfile?->user?->name ?? 'Student'),
                    'label' => $logbook->entry_date?->format('M j, Y') ?? 'Logbook',
                    'internship_title' => (string) ($logbook->internship?->title ?? ''),
                    'status_label' => 'Pending',
                    'status_class' => 'bg-warning-100 text-warning-700',
                    'submitted_label' => $logbook->updated_at?->diffForHumans() ?? '',
                ];
            });
    }

    private function upcomingDeadlines(Collection $internshipIds, Collection $studentProfileIds): Collection
    {
        if ($internshipIds->isEmpty() || $studentProfileIds->isEmpty()) {
            return collect();
        }

        return Task::query()
            ->with(['internship'])
            ->whereIn('internship_id', $internshipIds)
            ->whereIn('student_profile_id', $studentProfileIds)
            ->whereNotIn('status', ['completed'])
            ->whereNotNull('due_at')
            ->orderBy('due_at')
            ->limit(4)
            ->get()
            ->map(function (Task $task): array {
                $due = $task->due_at instanceof Carbon ? $task->due_at : null;
                $daysLeft = $due ? Carbon::now()->startOfDay()->diffInDays($due->startOfDay(), false) : null;

                $meta = null;
                $metaClass = 'text-neutral-500';

                if ($daysLeft !== null) {
                    if ($daysLeft < 0) {
                        $meta = 'Overdue';
                        $metaClass = 'text-danger-600';
                    } elseif ($daysLeft === 0) {
                        $meta = 'Due today';
                        $metaClass = 'text-warning-700';
                    } else {
                        $meta = $daysLeft . ' day' . ($daysLeft === 1 ? '' : 's') . ' left';
                        $metaClass = $daysLeft <= 3 ? 'text-warning-700' : 'text-neutral-500';
                    }
                }

                return [
                    'title' => (string) $task->title,
                    'subtitle' => (string) ($task->internship?->title ?? ''),
                    'due_label' => $due?->format('M j, Y') ?? '—',
                    'meta' => $meta,
                    'meta_class' => $metaClass,
                ];
            });
    }

    private function recentActivity(Collection $internshipIds, Collection $studentProfileIds): Collection
    {
        if ($internshipIds->isEmpty() || $studentProfileIds->isEmpty()) {
            return collect();
        }

        $logbookActivity = Logbook::query()
            ->with(['studentProfile.user', 'internship'])
            ->whereIn('internship_id', $internshipIds)
            ->whereIn('student_profile_id', $studentProfileIds)
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get()
            ->map(function (Logbook $logbook): array {
                return [
                    'time' => $logbook->updated_at?->timestamp ?? 0,
                    'student_name' => (string) ($logbook->studentProfile?->user?->name ?? 'Student'),
                    'activity' => $logbook->status === 'submitted' ? 'Submitted logbook entry' : 'Updated logbook entry',
                    'internship' => (string) ($logbook->internship?->title ?? ''),
                    'time_label' => $logbook->updated_at?->diffForHumans() ?? '',
                ];
            });

        $taskActivity = Task::query()
            ->with(['studentProfile.user', 'internship'])
            ->whereIn('internship_id', $internshipIds)
            ->whereIn('student_profile_id', $studentProfileIds)
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get()
            ->map(function (Task $task): array {
                $label = match ($task->status) {
                    'completed' => 'Completed task',
                    'in_progress' => 'Started task',
                    default => 'Updated task',
                };

                return [
                    'time' => $task->updated_at?->timestamp ?? 0,
                    'student_name' => (string) ($task->studentProfile?->user?->name ?? 'Student'),
                    'activity' => $label . ': ' . $task->title,
                    'internship' => (string) ($task->internship?->title ?? ''),
                    'time_label' => $task->updated_at?->diffForHumans() ?? '',
                ];
            });

        return $logbookActivity
            ->concat($taskActivity)
            ->sortByDesc('time')
            ->take(6)
            ->values()
            ->map(function (array $row): array {
                unset($row['time']);

                return $row;
            });
    }

    private function scheduleItems(): Collection
    {
        return collect([
            [
                'title' => 'Logbook Review Session',
                'subtitle' => 'Review pending logbooks',
                'time' => '09:00 – 10:00',
                'tag' => 'Today',
                'dot' => 'bg-primary-500',
            ],
            [
                'title' => 'Student Meeting',
                'subtitle' => 'Discuss progress with students',
                'time' => '11:00 – 12:00',
                'tag' => 'Today',
                'dot' => 'bg-info-500',
            ],
            [
                'title' => 'Department Meeting',
                'subtitle' => 'Internship program updates',
                'time' => '14:00 – 15:00',
                'tag' => 'Tomorrow',
                'dot' => 'bg-warning-500',
            ],
            [
                'title' => 'Evaluation Review',
                'subtitle' => 'Review mid-term evaluations',
                'time' => '16:00 – 17:00',
                'tag' => 'May 22',
                'dot' => 'bg-success-500',
            ],
        ]);
    }

    private function greeting(string $name): string
    {
        $hour = (int) Carbon::now()->format('G');
        $time = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');

        return $time . ', ' . $name;
    }

    private function dateRangeLabel(): string
    {
        $start = Carbon::now()->subDays(6)->startOfDay();
        $end = Carbon::now()->endOfDay();

        return $start->format('M j') . ' – ' . $end->format('M j, Y');
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
