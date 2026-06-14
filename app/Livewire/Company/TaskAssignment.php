<?php

namespace App\Livewire\Company;

use App\Models\CompanyProfile;
use App\Models\Internship;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TaskAssignment extends Component
{
    use WithPagination;

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

    public ?int $activeTaskId = null;

    public string $reviewerFeedback = '';

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

    public function selectTask(int $taskId): void
    {
        $task = $this->findTaskForReview($this->companyInternshipIds(), $taskId);

        Gate::authorize('review', $task);

        $this->activeTaskId = $task->id;
        $this->resetReviewForm();
    }

    public function markSubmissionReviewed(): void
    {
        $this->reviewActiveSubmission('reviewed');
    }

    public function markSubmissionForRework(): void
    {
        $this->reviewActiveSubmission('rework');
    }

    public function render(): View
    {
        return view('livewire.company.task-assignment', [
            'title' => 'Task Reviews',
            'counts' => $this->taskCounts($this->companyInternshipIds()),
            'internships' => $this->internships(),
            'tasks' => $this->tasksPaginator($this->companyInternshipIds()),
            'pendingReviews' => $this->pendingReviewTasks($this->companyInternshipIds()),
            'selectedTask' => $this->selectedTaskPayload($this->companyInternshipIds()),
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
        $query = $this->scopedTasksQuery($internshipIds);

        $query = $this->applyStatusFilter($query);
        $query = $this->applyInternshipFilter($query);
        $query = $this->applyDueDateFilter($query);
        $query = $this->applySearchFilter($query);

        return $query
            ->orderByRaw('due_at is null')
            ->orderBy('due_at')
            ->orderByDesc('created_at');
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
            'pending_review' => $query->whereHas('latestSubmission', fn (Builder $submissionQuery) => $submissionQuery->where('status', 'pending')),
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
                ->orWhereHas('internship', fn (Builder $internshipQuery) => $internshipQuery->where('title', 'like', $like));
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
        $latestSubmission = $task->latestSubmission;
        $submissionStatus = $this->submissionStatusMeta($latestSubmission?->status);

        return [
            'id' => $task->id,
            'title' => (string) $task->title,
            'description' => $task->description,
            'student_name' => (string) ($task->studentProfile?->user?->name ?? '—'),
            'student_department' => (string) ($task->studentProfile?->department ?? ''),
            'internship_title' => (string) ($task->internship?->title ?? '—'),
            'due_label' => $dueAt?->format('M j, Y') ?? '—',
            'due_meta_label' => $dueMeta['label'],
            'due_meta_class' => $dueMeta['class'],
            'status' => $this->statusLabel($task->status),
            'status_key' => (string) $task->status,
            'priority' => $priority['label'],
            'priority_key' => $priority['key'],
            'is_overdue' => $isOverdue,
            'submission_count' => (int) ($task->submissions_count ?? 0),
            'has_submission' => $latestSubmission !== null,
            'latest_submission_status_label' => $submissionStatus['label'],
            'latest_submission_status_class' => $submissionStatus['class'],
            'latest_submission_feedback' => $latestSubmission?->reviewer_feedback
                ? Str::limit((string) $latestSubmission->reviewer_feedback, 80)
                : null,
            'latest_submission_label' => $latestSubmission?->submitted_at?->format('M j, Y g:i A'),
            'is_selected' => $task->id === $this->activeTaskId,
        ];
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

    private function statusLabel(?string $status): string
    {
        return match ($status) {
            'todo' => 'Not Started',
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
                'class' => 'bg-warning-50 text-warning-700 ring-warning-100',
            ],
            'reviewed' => [
                'label' => 'Reviewed',
                'class' => 'bg-success-50 text-success-700 ring-success-100',
            ],
            'rework' => [
                'label' => 'Rework',
                'class' => 'bg-danger-50 text-danger-700 ring-danger-100',
            ],
            default => [
                'label' => 'No Submission',
                'class' => 'bg-neutral-100 text-neutral-700 ring-neutral-200',
            ],
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
                'pending_review' => 0,
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

        $pendingReview = (int) Task::query()
            ->whereIn('internship_id', $internshipIds)
            ->whereHas('latestSubmission', fn (Builder $submissionQuery) => $submissionQuery->where('status', 'pending'))
            ->count();

        return [
            'all' => array_sum(array_map('intval', $raw)),
            'todo' => $todo,
            'in_progress' => $inProgress,
            'completed' => $completed,
            'overdue' => $overdue,
            'pending_review' => $pendingReview,
        ];
    }

    private function selectedTaskPayload(Collection $internshipIds): ?array
    {
        $task = $this->resolveActiveTask($internshipIds);

        if (! $task) {
            return null;
        }

        $task->loadMissing([
            'assignedBy',
            'internship.companyProfile',
            'studentProfile.user',
            'submissions.reviewedBy',
        ]);

        $latestSubmission = $task->submissions->first();
        $latestStatus = $this->submissionStatusMeta($latestSubmission?->status);
        $student = $task->studentProfile?->user;

        return [
            'id' => $task->id,
            'title' => (string) $task->title,
            'description' => $task->description,
            'student_name' => (string) ($student?->name ?? 'Student'),
            'student_matricule' => $student?->matricule,
            'student_department' => $task->studentProfile?->department,
            'internship_title' => (string) ($task->internship?->title ?? '—'),
            'company_name' => (string) ($task->internship?->companyProfile?->company_name ?? ''),
            'assigned_by_name' => $task->assignedBy?->name,
            'due_label' => $task->due_at?->format('M j, Y') ?? '—',
            'status_label' => $this->statusLabel($task->status),
            'submission_count' => (int) $task->submissions->count(),
            'latest_submission_status_label' => $latestStatus['label'],
            'latest_submission_status_class' => $latestStatus['class'],
            'latest_submission_label' => $latestSubmission?->submitted_at?->format('M j, Y g:i A'),
            'can_review_latest_submission' => $latestSubmission?->status === 'pending',
            'history' => $task->submissions->map(function ($submission, int $index): array {
                $status = $this->submissionStatusMeta($submission->status);

                return [
                    'id' => $submission->id,
                    'status_label' => $status['label'],
                    'status_class' => $status['class'],
                    'submitted_label' => $submission->submitted_at?->format('M j, Y g:i A') ?? '—',
                    'reviewed_label' => $submission->reviewed_at?->format('M j, Y g:i A'),
                    'update_text' => (string) $submission->update_text,
                    'reviewer_feedback' => $submission->reviewer_feedback,
                    'reviewer_name' => $submission->reviewedBy?->name,
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

    private function pendingReviewTasks(Collection $internshipIds): array
    {
        if ($internshipIds->isEmpty()) {
            return [];
        }

        return $this->scopedTasksQuery($internshipIds)
            ->whereHas('latestSubmission', fn (Builder $submissionQuery) => $submissionQuery->where('status', 'pending'))
            ->limit(4)
            ->get()
            ->map(fn (Task $task): array => [
                'id' => $task->id,
                'title' => (string) $task->title,
                'student_name' => (string) ($task->studentProfile?->user?->name ?? '—'),
                'submitted_label' => $task->latestSubmission?->submitted_at?->format('M j, Y g:i A') ?? '—',
            ])
            ->all();
    }

    private function scopedTasksQuery(Collection $internshipIds): Builder
    {
        return Task::query()
            ->with(['assignedBy', 'studentProfile.user', 'internship.companyProfile', 'latestSubmission.reviewedBy'])
            ->withCount('submissions')
            ->when($internshipIds->isNotEmpty(), fn (Builder $query) => $query->whereIn('internship_id', $internshipIds))
            ->when($internshipIds->isEmpty(), fn (Builder $query) => $query->whereRaw('1 = 0'));
    }

    private function resolveActiveTask(Collection $internshipIds): ?Task
    {
        $query = $this->scopedTasksQuery($internshipIds);

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

    private function findTaskForReview(Collection $internshipIds, int $taskId): Task
    {
        return $this->scopedTasksQuery($internshipIds)
            ->whereKey($taskId)
            ->firstOrFail();
    }

    private function reviewActiveSubmission(string $status): void
    {
        $task = $this->activeTaskId !== null
            ? $this->findTaskForReview($this->companyInternshipIds(), $this->activeTaskId)
            : null;

        if (! $task) {
            $this->addError('reviewerFeedback', 'Select a task submission before reviewing.');

            return;
        }

        Gate::authorize('review', $task);

        $rules = [
            'reviewerFeedback' => ['nullable', 'string', 'max:5000'],
        ];

        if ($status === 'rework') {
            $rules['reviewerFeedback'] = ['required', 'string', 'min:5', 'max:5000'];
        }

        $validated = $this->validate($rules, [
            'reviewerFeedback.required' => 'Add reviewer feedback before requesting rework.',
            'reviewerFeedback.min' => 'Reviewer feedback must be at least 5 characters.',
            'reviewerFeedback.max' => 'Reviewer feedback must be 5000 characters or fewer.',
        ]);

        $submission = $task->submissions()->orderByDesc('submitted_at')->orderByDesc('id')->first();

        if (! $submission) {
            session()->flash('message', 'This task does not have any submissions to review yet.');

            return;
        }

        if ($submission->status !== 'pending') {
            session()->flash('message', 'The latest submission has already been reviewed.');

            return;
        }

        $submission->forceFill([
            'status' => $status,
            'reviewer_feedback' => trim((string) ($validated['reviewerFeedback'] ?? '')) ?: null,
            'reviewed_by_user_id' => auth()->id(),
            'reviewed_at' => now(),
        ])->save();

        $this->resetReviewForm();

        session()->flash(
            'message',
            $status === 'reviewed'
                ? 'Submission marked as reviewed.'
                : 'Submission sent back for rework.'
        );
    }

    private function internships(): Collection
    {
        return Internship::query()
            ->where('company_profile_id', $this->companyProfile()->id)
            ->orderBy('title')
            ->get(['id', 'title']);
    }

    private function companyProfile(): CompanyProfile
    {
        $user = auth()->user();

        return CompanyProfile::query()->firstOrCreate([
            'user_id' => $user?->id,
        ]);
    }

    private function companyInternshipIds(): Collection
    {
        return Internship::query()
            ->where('company_profile_id', $this->companyProfile()->id)
            ->pluck('id');
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

    private function resetReviewForm(): void
    {
        $this->reviewerFeedback = '';
        $this->resetValidation();
    }

    private function escapeLike(string $value): string
    {
        return addcslashes($value, "\\%_");
    }
}
