<?php

namespace App\Livewire\Student;

use App\Models\StudentProfile;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TaskBoard extends Component
{
    use WithPagination;

    #[Url]
    public string $tab = 'all';

    #[Url]
    public string $sort = 'due_asc';

    #[Url]
    public int $perPage = 6;

    public function updatedTab(): void
    {
        $this->resetPage();
    }

    public function updatedSort(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function toggleComplete(int $taskId): void
    {
        $profile = $this->ensureStudentProfile();

        $task = Task::query()
            ->whereKey($taskId)
            ->where('student_profile_id', $profile->id)
            ->firstOrFail();

        if ($task->status === 'completed') {
            $task->forceFill([
                'status' => 'todo',
                'completed_at' => null,
            ])->save();

            return;
        }

        $task->forceFill([
            'status' => 'completed',
            'completed_at' => Carbon::now(),
        ])->save();
    }

    public function render(): View
    {
        $profile = $this->ensureStudentProfile();
        $counts = $this->taskCounts($profile->id);
        $progress = $this->taskProgressSnapshot($counts);

        return view('livewire.student.task-board', [
            'title' => 'Task Board',
            'tasks' => $this->tasksPaginator($profile->id),
            'tabs' => $this->tabs($counts),
            'counts' => $counts,
            'upcomingDeadlines' => $this->upcomingDeadlines($profile->id),
            'progress' => $progress,
        ])->extends('layouts.dashboard')->section('content');
    }

    private function tasksPaginator(int $studentProfileId): LengthAwarePaginator
    {
        $perPage = max(1, min(50, $this->perPage));

        return $this->tasksQuery($studentProfileId)
            ->paginate($perPage)
            ->through(fn (Task $task): array => $this->presentTaskRow($task));
    }

    private function tasksQuery(int $studentProfileId): Builder
    {
        $query = Task::query()
            ->with(['internship.companyProfile'])
            ->where('student_profile_id', $studentProfileId);

        $query = $this->applyTabFilter($query);
        $query = $this->applySort($query);

        return $query;
    }

    private function applyTabFilter(Builder $query): Builder
    {
        $now = Carbon::now();

        return match ($this->tab) {
            'todo' => $query->where('status', 'todo'),
            'in_progress' => $query->where('status', 'in_progress'),
            'completed' => $query->where('status', 'completed'),
            'overdue' => $query
                ->where('status', '!=', 'completed')
                ->whereNotNull('due_at')
                ->where('due_at', '<', $now),
            default => $query,
        };
    }

    private function applySort(Builder $query): Builder
    {
        $direction = $this->sort === 'due_desc' ? 'desc' : 'asc';

        return $query
            ->orderByRaw('due_at is null')
            ->orderBy('due_at', $direction)
            ->orderByDesc('created_at');
    }

    private function presentTaskRow(Task $task): array
    {
        $dueAt = $task->due_at instanceof Carbon ? $task->due_at : null;
        $now = Carbon::now();
        $isCompleted = $task->status === 'completed';
        $isOverdue = ! $isCompleted && $dueAt !== null && $dueAt->isPast();

        $priority = $this->priorityForTask($task, $now);
        $dueMeta = $this->dueMeta($task, $now);

        return [
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'internship_title' => $task->internship?->title ?? '—',
            'company_name' => $task->internship?->companyProfile?->company_name,
            'internship_id' => $task->internship_id,
            'due_at' => $dueAt,
            'due_label' => $dueAt?->format('M j, Y') ?? '—',
            'due_meta_label' => $dueMeta['label'],
            'due_meta_class' => $dueMeta['class'],
            'priority' => $priority['label'],
            'priority_key' => $priority['key'],
            'status' => $this->statusLabel($task->status),
            'status_key' => $task->status,
            'is_overdue' => $isOverdue,
            'is_completed' => $isCompleted,
        ];
    }

    private function dueMeta(Task $task, Carbon $now): array
    {
        if ($task->status === 'completed') {
            return ['label' => 'Completed', 'class' => 'text-success-700'];
        }

        $dueAt = $task->due_at instanceof Carbon ? $task->due_at : null;

        if ($dueAt === null) {
            return ['label' => null, 'class' => 'text-neutral-500'];
        }

        $days = $now->startOfDay()->diffInDays($dueAt->copy()->startOfDay(), false);

        if ($days < 0) {
            $count = abs($days);

            return [
                'label' => $count === 1 ? '1 day overdue' : $count . ' days overdue',
                'class' => 'text-danger-700',
            ];
        }

        if ($days === 0) {
            return ['label' => 'Due today', 'class' => 'text-warning-700'];
        }

        $label = $days === 1 ? '1 day left' : $days . ' days left';
        $class = $days <= 2 ? 'text-danger-700' : ($days <= 7 ? 'text-warning-700' : 'text-neutral-500');

        return ['label' => $label, 'class' => $class];
    }

    private function priorityForTask(Task $task, Carbon $now): array
    {
        $dueAt = $task->due_at instanceof Carbon ? $task->due_at : null;

        if ($dueAt === null) {
            return ['key' => 'none', 'label' => '—'];
        }

        if ($task->status !== 'completed' && $dueAt->lt($now)) {
            return ['key' => 'high', 'label' => 'High'];
        }

        $days = $now->diffInDays($dueAt, false);

        if ($days <= 2) {
            return ['key' => 'high', 'label' => 'High'];
        }

        if ($days <= 7) {
            return ['key' => 'medium', 'label' => 'Medium'];
        }

        return ['key' => 'low', 'label' => 'Low'];
    }

    private function statusLabel(?string $status): string
    {
        return match ($status) {
            'todo' => 'To Do',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            default => $status ? Str::headline($status) : '—',
        };
    }

    private function taskCounts(int $studentProfileId): array
    {
        $raw = Task::query()
            ->where('student_profile_id', $studentProfileId)
            ->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status')
            ->all();

        $todo = (int) ($raw['todo'] ?? 0);
        $inProgress = (int) ($raw['in_progress'] ?? 0);
        $completed = (int) ($raw['completed'] ?? 0);

        $overdue = (int) Task::query()
            ->where('student_profile_id', $studentProfileId)
            ->where('status', '!=', 'completed')
            ->whereNotNull('due_at')
            ->where('due_at', '<', Carbon::now())
            ->count();

        return [
            'all' => $todo + $inProgress + $completed + (int) array_sum(array_diff_key($raw, array_flip(['todo', 'in_progress', 'completed']))),
            'todo' => $todo,
            'in_progress' => $inProgress,
            'completed' => $completed,
            'overdue' => $overdue,
        ];
    }

    private function tabs(array $counts): array
    {
        return [
            ['key' => 'all', 'label' => 'All Tasks', 'count' => $counts['all'] ?? 0],
            ['key' => 'todo', 'label' => 'To Do', 'count' => $counts['todo'] ?? 0],
            ['key' => 'in_progress', 'label' => 'In Progress', 'count' => $counts['in_progress'] ?? 0],
            ['key' => 'completed', 'label' => 'Completed', 'count' => $counts['completed'] ?? 0],
            ['key' => 'overdue', 'label' => 'Overdue', 'count' => $counts['overdue'] ?? 0],
        ];
    }

    private function upcomingDeadlines(int $studentProfileId): array
    {
        $now = Carbon::now();

        return Task::query()
            ->with(['internship.companyProfile'])
            ->where('student_profile_id', $studentProfileId)
            ->where('status', '!=', 'completed')
            ->whereNotNull('due_at')
            ->whereBetween('due_at', [$now, $now->copy()->addDays(14)])
            ->orderBy('due_at')
            ->limit(6)
            ->get()
            ->map(fn (Task $task): array => [
                'id' => $task->id,
                'title' => $task->title,
                'internship_title' => $task->internship?->title ?? '—',
                'company_name' => $task->internship?->companyProfile?->company_name,
                'due_label' => $task->due_at?->format('M j, Y') ?? '—',
                'due_at' => $task->due_at,
                'meta' => $this->dueMeta($task, $now),
            ])
            ->all();
    }

    private function taskProgressSnapshot(array $counts): array
    {
        $total = max(0, (int) ($counts['all'] ?? 0));
        $segments = [
            [
                'key' => 'todo',
                'label' => 'To Do',
                'count' => max(0, (int) ($counts['todo'] ?? 0)),
                'color' => '#A78BFA',
                'legend_class' => 'bg-secondary-400',
            ],
            [
                'key' => 'in_progress',
                'label' => 'In Progress',
                'count' => max(0, (int) ($counts['in_progress'] ?? 0)),
                'color' => '#38BDF8',
                'legend_class' => 'bg-info-400',
            ],
            [
                'key' => 'completed',
                'label' => 'Completed',
                'count' => max(0, (int) ($counts['completed'] ?? 0)),
                'color' => '#34D399',
                'legend_class' => 'bg-success-400',
            ],
            [
                'key' => 'overdue',
                'label' => 'Overdue',
                'count' => max(0, (int) ($counts['overdue'] ?? 0)),
                'color' => '#FB7185',
                'legend_class' => 'bg-danger-400',
            ],
        ];

        $segments = collect($segments)
            ->map(function (array $segment) use ($total): array {
                $percent = $total > 0 ? (int) round(($segment['count'] / $total) * 100) : 0;
                $segment['percent'] = $percent;

                return $segment;
            })
            ->all();

        $style = $this->donutStyle($segments);

        return [
            'total' => $total,
            'segments' => $segments,
            'style' => $style,
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

    private function ensureStudentProfile(): StudentProfile
    {
        $user = auth()->user();

        return $user->studentProfile()->firstOrCreate();
    }
}
