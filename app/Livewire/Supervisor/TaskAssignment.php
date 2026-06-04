<?php

namespace App\Livewire\Supervisor;

use App\Models\Internship;
use App\Models\StudentProfile;
use App\Models\SupervisorProfile;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TaskAssignment extends Component
{
    use WithPagination;

    #[Url]
    public string $tab = 'assigned';

    #[Url]
    public string $search = '';

    #[Url]
    public string $status = 'all';

    #[Url]
    public string $internship = '';

    #[Url]
    public string $dueDate = '';

    #[Url]
    public int $perPage = 10;

    public string $newTaskTitle = '';

    public string $newTaskDescription = '';

    public string $newTaskStudentProfileId = '';

    public string $newTaskInternshipId = '';

    public string $newTaskDueDate = '';

    public function updatedTab(): void
    {
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedInternship(): void
    {
        $this->resetPage();
    }

    public function updatedDueDate(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function createNewTask(): void
    {
        $user = auth()->user();
        $supervisorProfile = SupervisorProfile::query()->firstOrCreate([
            'user_id' => $user?->id,
        ]);

        $internships = Internship::query()
            ->where('supervisor_profile_id', $supervisorProfile->id)
            ->pluck('id')
            ->all();

        if (empty($internships)) {
            session()->flash('message', 'No internships assigned to your supervisor profile yet.');

            return;
        }

        $this->validate([
            'newTaskTitle' => ['required', 'string', 'max:255'],
            'newTaskDescription' => ['nullable', 'string'],
            'newTaskStudentProfileId' => ['required', 'integer'],
            'newTaskInternshipId' => ['required', 'integer'],
            'newTaskDueDate' => ['nullable', 'date'],
        ]);

        $internshipId = (int) $this->newTaskInternshipId;
        $studentProfileId = (int) $this->newTaskStudentProfileId;

        if (! in_array($internshipId, $internships, true)) {
            session()->flash('message', 'Invalid internship selected.');

            return;
        }

        $isSupervised = StudentProfile::query()
            ->whereKey($studentProfileId)
            ->whereHas('applications', function (Builder $applications) use ($internshipId): void {
                $applications->where('status', 'accepted')
                    ->where('internship_id', $internshipId);
            })
            ->exists();

        if (! $isSupervised) {
            session()->flash('message', 'Selected student is not assigned to that internship.');

            return;
        }

        $dueAt = $this->newTaskDueDate !== ''
            ? Carbon::parse($this->newTaskDueDate)->endOfDay()
            : null;

        Task::query()->create([
            'internship_id' => $internshipId,
            'student_profile_id' => $studentProfileId,
            'assigned_by_user_id' => $user?->id,
            'title' => trim($this->newTaskTitle),
            'description' => trim($this->newTaskDescription) !== '' ? trim($this->newTaskDescription) : null,
            'status' => 'todo',
            'due_at' => $dueAt,
        ]);

        $this->newTaskTitle = '';
        $this->newTaskDescription = '';
        $this->newTaskStudentProfileId = '';
        $this->newTaskInternshipId = '';
        $this->newTaskDueDate = '';

        session()->flash('message', 'Task created.');
        $this->tab = 'assigned';
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->tab = 'create';
    }

    public function manageTemplates(): void
    {
        session()->flash('message', 'Task templates are coming soon.');
    }

    public function openSettings(): void
    {
        session()->flash('message', 'Task settings are coming soon.');
    }

    public function openFilters(): void
    {
        session()->flash('message', 'More filters are coming soon.');
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
            ->get(['id', 'title']);

        $internshipIds = $internships->pluck('id');

        return view('livewire.supervisor.task-assignment', [
            'title' => 'Tasks',
            'tabs' => $this->tabs($internshipIds),
            'counts' => $this->taskCounts($internshipIds),
            'tasks' => $this->tasksPaginator($internshipIds),
            'internships' => $internships,
            'students' => $this->supervisedStudents($internshipIds),
            'overdueTasks' => $this->overdueTasks($internshipIds),
        ])->extends('layouts.dashboard')->section('content');
    }

    private function tasksPaginator(Collection $internshipIds): LengthAwarePaginator
    {
        $perPage = max(1, min(50, $this->perPage));

        return $this->tasksQuery($internshipIds)
            ->paginate($perPage)
            ->through(fn (Task $task): array => $this->presentTaskRow($task));
    }

    private function tasksQuery(Collection $internshipIds): Builder
    {
        $query = Task::query()
            ->with(['studentProfile.user', 'internship.companyProfile'])
            ->when($internshipIds->isNotEmpty(), fn (Builder $q) => $q->whereIn('internship_id', $internshipIds))
            ->when($internshipIds->isEmpty(), fn (Builder $q) => $q->whereRaw('1 = 0'));

        $query = $this->applyTabFilter($query);
        $query = $this->applyStatusFilter($query);
        $query = $this->applyInternshipFilter($query);
        $query = $this->applyDueDateFilter($query);
        $query = $this->applySearchFilter($query);

        return $query
            ->orderByRaw('due_at is null')
            ->orderBy('due_at')
            ->orderByDesc('created_at');
    }

    private function applyTabFilter(Builder $query): Builder
    {
        return match ($this->tab) {
            'assigned', 'create', 'templates' => $query,
            default => $query,
        };
    }

    private function applyStatusFilter(Builder $query): Builder
    {
        $now = Carbon::now();

        return match ($this->status) {
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

    private function applyInternshipFilter(Builder $query): Builder
    {
        $internship = trim($this->internship);

        if ($internship === '' || ! ctype_digit($internship)) {
            return $query;
        }

        return $query->where('internship_id', (int) $internship);
    }

    private function applyDueDateFilter(Builder $query): Builder
    {
        $dueDate = trim($this->dueDate);

        if ($dueDate === '') {
            return $query;
        }

        return $query->whereDate('due_at', $dueDate);
    }

    private function applySearchFilter(Builder $query): Builder
    {
        $term = trim($this->search);

        if ($term === '') {
            return $query;
        }

        $like = '%' . $this->escapeLike($term) . '%';

        return $query->where(function (Builder $nested) use ($like): void {
            $nested
                ->where('title', 'like', $like)
                ->orWhere('description', 'like', $like)
                ->orWhereHas('studentProfile.user', function (Builder $userQuery) use ($like): void {
                    $userQuery->where('name', 'like', $like)->orWhere('email', 'like', $like)->orWhere('matricule', 'like', $like);
                })
                ->orWhereHas('internship', function (Builder $internshipQuery) use ($like): void {
                    $internshipQuery
                        ->where('title', 'like', $like)
                        ->orWhereHas('companyProfile', fn (Builder $company) => $company->where('company_name', 'like', $like));
                });
        });
    }

    private function presentTaskRow(Task $task): array
    {
        $dueAt = $task->due_at instanceof Carbon ? $task->due_at : null;
        $now = Carbon::now();
        $isCompleted = $task->status === 'completed';
        $isOverdue = ! $isCompleted && $dueAt !== null && $dueAt->isPast();

        $priority = $this->priorityForTask($task, $now);
        $dueMeta = $this->dueMeta($task, $now);
        $progress = $this->progressForTask($task, $isOverdue);

        return [
            'id' => $task->id,
            'title' => (string) $task->title,
            'description' => $task->description,
            'intern_name' => (string) ($task->studentProfile?->user?->name ?? '—'),
            'intern_role' => (string) ($task->studentProfile?->department ?? ''),
            'internship_title' => (string) ($task->internship?->title ?? '—'),
            'company_name' => (string) ($task->internship?->companyProfile?->company_name ?? ''),
            'internship_id' => $task->internship_id,
            'due_label' => $dueAt?->format('M j, Y') ?? '—',
            'due_meta_label' => $dueMeta['label'],
            'due_meta_class' => $dueMeta['class'],
            'status' => $this->statusLabel($task->status),
            'status_key' => (string) $task->status,
            'priority' => $priority['label'],
            'priority_key' => $priority['key'],
            'progress' => $progress,
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

    private function progressForTask(Task $task, bool $isOverdue): int
    {
        if ($task->status === 'completed') {
            return 100;
        }

        if ($isOverdue) {
            return 30;
        }

        return match ($task->status) {
            'in_progress' => 60,
            'todo' => 0,
            default => 40,
        };
    }

    private function statusLabel(?string $status): string
    {
        return match ($status) {
            'todo' => 'Not Started',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            default => $status ? Str::headline($status) : '—',
        };
    }

    private function taskCounts(Collection $internshipIds): array
    {
        if ($internshipIds->isEmpty()) {
            return [
                'all' => 0,
                'todo' => 0,
                'in_progress' => 0,
                'completed' => 0,
                'overdue' => 0,
            ];
        }

        $raw = Task::query()
            ->whereIn('internship_id', $internshipIds)
            ->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status')
            ->all();

        $todo = (int) ($raw['todo'] ?? 0);
        $inProgress = (int) ($raw['in_progress'] ?? 0);
        $completed = (int) ($raw['completed'] ?? 0);

        $overdue = (int) Task::query()
            ->whereIn('internship_id', $internshipIds)
            ->where('status', '!=', 'completed')
            ->whereNotNull('due_at')
            ->where('due_at', '<', Carbon::now())
            ->count();

        return [
            'all' => array_sum(array_map('intval', $raw)),
            'todo' => $todo,
            'in_progress' => $inProgress,
            'completed' => $completed,
            'overdue' => $overdue,
        ];
    }

    private function tabs(Collection $internshipIds): array
    {
        $counts = $this->taskCounts($internshipIds);

        return [
            ['key' => 'assigned', 'label' => 'Assigned Tasks', 'count' => $counts['all'] ?? 0],
            ['key' => 'templates', 'label' => 'Task Templates', 'count' => 0],
            ['key' => 'create', 'label' => 'Create Task', 'count' => 0],
        ];
    }

    private function supervisedStudents(Collection $internshipIds): array
    {
        if ($internshipIds->isEmpty()) {
            return [];
        }

        return StudentProfile::query()
            ->with(['user'])
            ->whereHas('applications', function ($query) use ($internshipIds): void {
                $query->whereIn('internship_id', $internshipIds)->where('status', 'accepted');
            })
            ->orderBy('id')
            ->get()
            ->map(fn (StudentProfile $profile): array => [
                'id' => $profile->id,
                'name' => (string) ($profile->user?->name ?? 'Student'),
                'label' => (string) ($profile->user?->name ?? 'Student') . ($profile->user?->matricule ? ' • ' . $profile->user->matricule : ''),
            ])
            ->all();
    }

    private function overdueTasks(Collection $internshipIds): array
    {
        if ($internshipIds->isEmpty()) {
            return [];
        }

        $now = Carbon::now();

        return Task::query()
            ->with(['studentProfile.user'])
            ->whereIn('internship_id', $internshipIds)
            ->where('status', '!=', 'completed')
            ->whereNotNull('due_at')
            ->where('due_at', '<', $now)
            ->orderBy('due_at')
            ->limit(3)
            ->get()
            ->map(fn (Task $task): array => [
                'id' => $task->id,
                'title' => (string) $task->title,
                'student' => (string) ($task->studentProfile?->user?->name ?? '—'),
                'due_label' => $task->due_at?->format('M j, Y') ?? '—',
            ])
            ->all();
    }

    private function escapeLike(string $value): string
    {
        return addcslashes($value, "\\%_");
    }
}
