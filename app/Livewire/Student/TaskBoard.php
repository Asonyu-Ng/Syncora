<?php

namespace App\Livewire\Student;

use App\Models\StudentProfile;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class TaskBoard extends Component
{
    use WithFileUploads;
    use WithPagination;

    #[Url]
    public string $tab = 'all';

    #[Url]
    public string $sort = 'due_asc';

    #[Url]
    public int $perPage = 6;

    public ?int $activeTaskId = null;

    public ?int $submissionTaskId = null;

    public bool $showSubmitModal = false;

    public string $submissionUpdate = '';

    public array $submissionFiles = [];

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

    public function updatedSubmissionFiles(): void
    {
        $this->validate($this->submissionFileRules(), $this->submissionMessages());
    }

    public function updatedSubmissionTaskId(?int $taskId): void
    {
        if ($taskId === null) {
            return;
        }

        $profile = $this->ensureStudentProfile();
        $task = $this->findOwnedTask($profile->id, $taskId);

        Gate::authorize('submit', $task);

        $this->submissionTaskId = $task->id;
    }

    public function selectTask(int $taskId): void
    {
        $profile = $this->ensureStudentProfile();
        $task = $this->findOwnedTask($profile->id, $taskId);

        Gate::authorize('submit', $task);

        $this->activeTaskId = $task->id;
    }

    public function openSubmitModal(?int $taskId = null): void
    {
        $profile = $this->ensureStudentProfile();
        $targetTaskId = $taskId
            ?? $this->activeTaskId
            ?? Task::query()
                ->where('student_profile_id', $profile->id)
                ->orderByRaw('due_at is null')
                ->orderBy('due_at')
                ->orderByDesc('created_at')
                ->value('id');

        if ($targetTaskId !== null) {
            $task = $this->findOwnedTask($profile->id, $targetTaskId);

            Gate::authorize('submit', $task);

            $this->submissionTaskId = $task->id;
        }

        $this->resetSubmissionForm();
        $this->showSubmitModal = true;
    }

    public function closeSubmitModal(): void
    {
        $this->showSubmitModal = false;
        $this->resetSubmissionForm();
    }

    public function submitTaskUpdate(): void
    {
        $profile = $this->ensureStudentProfile();

        if ($this->submissionTaskId === null) {
            $this->addError('submissionTaskId', 'Select a task before submitting an update.');

            return;
        }

        $task = $this->findOwnedTask($profile->id, $this->submissionTaskId);

        Gate::authorize('submit', $task);

        $validated = $this->validate($this->submissionRules(), $this->submissionMessages());

        $attachments = collect($this->dedupeSubmissionFiles($validated['submissionFiles'] ?? []))
            ->map(function ($file) use ($profile, $task): array {
                $path = $file->store('task-submissions/' . $profile->id . '/' . $task->id, 'public');

                return [
                    'path' => $path,
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                ];
            })
            ->values()
            ->all();

        $task->submissions()->create([
            'student_profile_id' => $profile->id,
            'status' => 'pending',
            'update_text' => trim($validated['submissionUpdate']),
            'attachments' => $attachments === [] ? null : $attachments,
            'submitted_at' => now(),
        ]);

        $task->refresh();

        if ($task->status === 'todo') {
            $task->forceFill([
                'status' => 'in_progress',
                'completed_at' => null,
            ])->save();
        }

        $this->activeTaskId = $task->id;
        $this->showSubmitModal = false;
        $this->resetSubmissionForm();
        session()->flash('message', 'Task update submitted successfully.');
    }

    public function toggleComplete(int $taskId): void
    {
        $profile = $this->ensureStudentProfile();
        $task = $this->findOwnedTask($profile->id, $taskId);

        if ($task->status === 'completed') {
            $task->forceFill([
                'status' => 'todo',
                'completed_at' => null,
            ])->save();

            session()->flash('message', 'Task moved back to To Do.');

            return;
        }

        $task->forceFill([
            'status' => 'completed',
            'completed_at' => Carbon::now(),
        ])->save();

        session()->flash('message', 'Task marked as completed.');
    }

    public function render(): View
    {
        $profile = $this->ensureStudentProfile();
        $counts = $this->taskCounts($profile->id);
        $progress = $this->taskProgressSnapshot($counts);
        $dashboardHref = Route::has('student.dashboard') ? route('student.dashboard') : '/student/dashboard';
        $tasksHref = Route::has('student.tasks.board') ? route('student.tasks.board') : '/student/tasks';

        return view('livewire.student.task-board', [
            'title' => 'Task Board',
            'breadcrumbs' => [
                ['label' => 'Dashboards', 'href' => '/__dashboards'],
                ['label' => 'Student Dashboard', 'href' => $dashboardHref],
                ['label' => 'Tasks', 'href' => $tasksHref],
                ['label' => 'Task Board', 'href' => null],
            ],
            'tasks' => $this->tasksPaginator($profile->id),
            'tabs' => $this->tabs($counts),
            'counts' => $counts,
            'upcomingDeadlines' => $this->upcomingDeadlines($profile->id),
            'progress' => $progress,
            'selectedTask' => $this->selectedTaskPayload($profile->id),
            'submissionTask' => $this->submissionTaskPayload($profile->id),
            'submissionTasks' => $this->submissionTaskOptions($profile->id),
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
            ->with(['internship.companyProfile', 'latestSubmission.reviewedBy'])
            ->withCount('submissions')
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
        $latestSubmission = $task->latestSubmission;
        $submissionStatus = $this->submissionStatusMeta($latestSubmission?->status);

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
            'submission_count' => (int) ($task->submissions_count ?? 0),
            'latest_submission_status_label' => $submissionStatus['label'],
            'latest_submission_status_class' => $submissionStatus['class'],
            'latest_submission_feedback' => $latestSubmission?->reviewer_feedback
                ? Str::limit((string) $latestSubmission->reviewer_feedback, 70)
                : null,
            'latest_submission_label' => $latestSubmission?->submitted_at?->format('M j, Y g:i A'),
            'has_submission' => $latestSubmission !== null,
            'is_selected' => $task->id === $this->activeTaskId,
        ];
    }

    private function dueMeta(Task $task, Carbon $now): array
    {
        if ($task->status === 'completed') {
            return ['label' => 'Completed', 'class' => 'text-success-700 dark:text-success-200'];
        }

        $dueAt = $task->due_at instanceof Carbon ? $task->due_at : null;

        if ($dueAt === null) {
            return ['label' => null, 'class' => 'text-neutral-500 dark:text-neutral-400'];
        }

        $days = $now->startOfDay()->diffInDays($dueAt->copy()->startOfDay(), false);

        if ($days < 0) {
            $count = abs($days);

            return [
                'label' => $count === 1 ? '1 day overdue' : $count . ' days overdue',
                'class' => 'text-danger-700 dark:text-danger-300',
            ];
        }

        if ($days === 0) {
            return ['label' => 'Due today', 'class' => 'text-warning-700 dark:text-warning-200'];
        }

        $label = $days === 1 ? '1 day left' : $days . ' days left';
        $class = $days <= 2
            ? 'text-danger-700 dark:text-danger-300'
            : ($days <= 7 ? 'text-warning-700 dark:text-warning-200' : 'text-neutral-500 dark:text-neutral-400');

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

    private function submissionStatusMeta(?string $status): array
    {
        return match ($status) {
            'pending' => [
                'label' => 'Pending',
                'class' => 'bg-warning-50 text-warning-700 ring-warning-100 dark:bg-warning-500/10 dark:text-warning-200 dark:ring-warning-500/20',
            ],
            'reviewed' => [
                'label' => 'Reviewed',
                'class' => 'bg-success-50 text-success-700 ring-success-100 dark:bg-success-500/10 dark:text-success-200 dark:ring-success-500/20',
            ],
            'rework' => [
                'label' => 'Rework',
                'class' => 'bg-danger-50 text-danger-700 ring-danger-100 dark:bg-danger-500/10 dark:text-danger-200 dark:ring-danger-500/20',
            ],
            default => [
                'label' => 'No Submission',
                'class' => 'bg-neutral-100 text-neutral-700 ring-neutral-200 dark:bg-neutral-900 dark:text-neutral-200 dark:ring-neutral-800',
            ],
        };
    }

    private function selectedTaskPayload(int $studentProfileId): ?array
    {
        $task = $this->resolveActiveTask($studentProfileId);

        if (! $task) {
            return null;
        }

        $task->loadMissing(['submissions.reviewedBy', 'internship.companyProfile']);

        $latestSubmission = $task->submissions->first();
        $latestStatus = $this->submissionStatusMeta($latestSubmission?->status);

        return [
            'id' => $task->id,
            'title' => (string) $task->title,
            'description' => $task->description,
            'internship_title' => $task->internship?->title ?? '—',
            'company_name' => $task->internship?->companyProfile?->company_name,
            'due_label' => $task->due_at?->format('M j, Y') ?? '—',
            'status_label' => $this->statusLabel($task->status),
            'submission_count' => (int) $task->submissions->count(),
            'latest_submission_status_label' => $latestStatus['label'],
            'latest_submission_status_class' => $latestStatus['class'],
            'latest_submission_feedback' => $latestSubmission?->reviewer_feedback,
            'latest_submission_label' => $latestSubmission?->submitted_at?->format('M j, Y g:i A'),
            'submit_label' => $task->submissions->isEmpty() ? 'Submit Update' : 'Submit Resubmission',
            'history' => $task->submissions->map(function ($submission, int $index): array {
                $status = $this->submissionStatusMeta($submission->status);

                return [
                    'id' => $submission->id,
                    'status_label' => $status['label'],
                    'status_class' => $status['class'],
                    'submitted_label' => $submission->submitted_at?->format('M j, Y g:i A') ?? '—',
                    'update_text' => (string) $submission->update_text,
                    'reviewer_feedback' => $submission->reviewer_feedback,
                    'reviewer_name' => $submission->reviewedBy?->name,
                    'reviewed_label' => $submission->reviewed_at?->format('M j, Y g:i A'),
                    'attachments' => collect($submission->attachments ?? [])
                        ->map(fn (array $attachment): array => [
                            'name' => $attachment['name'] ?? 'Attachment',
                            'size_label' => $this->formatBytes((int) ($attachment['size'] ?? 0)),
                            'url' => ! empty($attachment['path']) ? Storage::disk('public')->url($attachment['path']) : null,
                        ])
                        ->filter(fn (array $attachment): bool => $attachment['url'] !== null)
                        ->values()
                        ->all(),
                    'is_latest' => $index === 0,
                ];
            })->all(),
        ];
    }

    private function submissionTaskPayload(int $studentProfileId): ?array
    {
        if ($this->submissionTaskId === null) {
            return null;
        }

        $task = Task::query()
            ->with(['internship.companyProfile', 'latestSubmission'])
            ->withCount('submissions')
            ->whereKey($this->submissionTaskId)
            ->where('student_profile_id', $studentProfileId)
            ->first();

        if (! $task) {
            return null;
        }

        return [
            'id' => $task->id,
            'title' => (string) $task->title,
            'internship_title' => $task->internship?->title ?? '—',
            'company_name' => $task->internship?->companyProfile?->company_name,
            'due_label' => $task->due_at?->format('M j, Y') ?? '—',
            'status_label' => $this->statusLabel($task->status),
            'submission_count' => (int) ($task->submissions_count ?? 0),
            'submit_label' => $task->submissions_count > 0 ? 'Submit Resubmission' : 'Submit Update',
            'latest_submission_label' => $task->latestSubmission?->submitted_at?->format('M j, Y g:i A'),
        ];
    }

    private function resolveActiveTask(int $studentProfileId): ?Task
    {
        $query = $this->tasksQuery($studentProfileId);

        if ($this->activeTaskId !== null) {
            $selected = (clone $query)->whereKey($this->activeTaskId)->first();

            if ($selected) {
                return $selected;
            }
        }

        $selected = (clone $query)->first();
        $this->activeTaskId = $selected?->id;

        return $selected;
    }

    private function findOwnedTask(int $studentProfileId, int $taskId): Task
    {
        return Task::query()
            ->whereKey($taskId)
            ->where('student_profile_id', $studentProfileId)
            ->firstOrFail();
    }

    private function submissionTaskOptions(int $studentProfileId): array
    {
        return Task::query()
            ->with('internship.companyProfile')
            ->where('student_profile_id', $studentProfileId)
            ->orderByRaw('due_at is null')
            ->orderBy('due_at')
            ->orderByDesc('created_at')
            ->get()
            ->map(fn (Task $task): array => [
                'id' => $task->id,
                'title' => $task->title,
                'status_label' => $this->statusLabel($task->status),
                'internship_title' => $task->internship?->title ?? '—',
                'company_name' => $task->internship?->companyProfile?->company_name,
                'due_label' => $task->due_at?->format('M j, Y') ?? 'No due date',
            ])
            ->all();
    }

    private function submissionRules(): array
    {
        return [
            'submissionUpdate' => ['required', 'string', 'min:10', 'max:5000'],
            'submissionFiles' => ['nullable', 'array', 'max:5'],
            'submissionFiles.*' => ['file', 'mimes:pdf,jpg,jpeg,png,webp,doc,docx,xls,xlsx,csv,txt', 'max:5120'],
        ];
    }

    private function submissionFileRules(): array
    {
        return [
            'submissionFiles' => ['nullable', 'array', 'max:5'],
            'submissionFiles.*' => ['file', 'mimes:pdf,jpg,jpeg,png,webp,doc,docx,xls,xlsx,csv,txt', 'max:5120'],
        ];
    }

    private function submissionMessages(): array
    {
        return [
            'submissionUpdate.required' => 'Add a short written update before submitting.',
            'submissionUpdate.min' => 'Your written update must be at least 10 characters.',
            'submissionFiles.max' => 'You can attach up to 5 evidence files.',
            'submissionFiles.*.mimes' => 'Evidence files must be a PDF, image, document, spreadsheet, CSV, or text file.',
            'submissionFiles.*.max' => 'Each evidence file must be 5 MB or smaller.',
        ];
    }

    private function resetSubmissionForm(): void
    {
        $this->submissionUpdate = '';
        $this->submissionFiles = [];
        $this->resetValidation();
    }

    private function dedupeSubmissionFiles(array $files): array
    {
        return collect($files)
            ->filter()
            ->unique(function ($file): string {
                $realPath = method_exists($file, 'getRealPath') ? $file->getRealPath() : null;
                $hash = $realPath && is_readable($realPath)
                    ? sha1_file($realPath) ?: 'unreadable'
                    : 'missing-path';

                return implode('|', [
                    $file->getClientOriginalName(),
                    (string) $file->getSize(),
                    (string) $file->getMimeType(),
                    $hash,
                ]);
            })
            ->values()
            ->all();
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

        return [
            'total' => $total,
            'segments' => $segments,
            'style' => $this->donutStyle($segments),
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

    private function formatBytes(int $bytes): string
    {
        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $power = (int) floor(log($bytes, 1024));
        $power = min($power, count($units) - 1);
        $value = $bytes / (1024 ** $power);

        return number_format($value, $power === 0 ? 0 : 1) . ' ' . $units[$power];
    }

    private function ensureStudentProfile(): StudentProfile
    {
        $user = auth()->user();

        return $user->studentProfile()->firstOrCreate();
    }
}
