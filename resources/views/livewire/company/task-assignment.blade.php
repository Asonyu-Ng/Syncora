@php
    $statusPills = [
        'todo' => 'bg-neutral-100 text-neutral-700 ring-neutral-200',
        'in_progress' => 'bg-info-50 text-info-700 ring-info-100',
        'completed' => 'bg-success-50 text-success-700 ring-success-100',
    ];

    $priorityDots = [
        'high' => 'bg-danger-500',
        'medium' => 'bg-warning-500',
        'low' => 'bg-success-500',
        'none' => 'bg-neutral-300',
    ];
@endphp

<div class="space-y-6">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Task reviews
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950">Review intern submissions with clearer decision context.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">Keep task status, due dates, and submission history visible so company feedback stays timely and consistent.</p>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Current queue</div>
                <div class="mt-2 text-2xl font-semibold tracking-tight text-neutral-950">{{ $counts['pending_review'] ?? 0 }}</div>
                <p class="mt-2 text-sm leading-6 text-neutral-600">Pending review items are surfaced first so your team can respond faster.</p>
            </div>
        </div>
    </div>

    @if(session('message'))
        <div class="rounded-2xl border border-primary-100 bg-primary-50 px-5 py-4 text-sm font-semibold text-primary-800">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
            <div class="text-sm font-semibold text-neutral-600">Total Tasks</div>
            <div class="mt-3 text-3xl font-semibold text-neutral-900">{{ $counts['all'] ?? 0 }}</div>
            <div class="mt-2 text-sm text-neutral-500">Tasks across your internships</div>
        </div>
        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
            <div class="text-sm font-semibold text-neutral-600">Pending Review</div>
            <div class="mt-3 text-3xl font-semibold text-warning-700">{{ $counts['pending_review'] ?? 0 }}</div>
            <div class="mt-2 text-sm text-neutral-500">Latest submissions awaiting a decision</div>
        </div>
        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
            <div class="text-sm font-semibold text-neutral-600">In Progress</div>
            <div class="mt-3 text-3xl font-semibold text-neutral-900">{{ $counts['in_progress'] ?? 0 }}</div>
            <div class="mt-2 text-sm text-neutral-500">Active intern work items</div>
        </div>
        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
            <div class="text-sm font-semibold text-neutral-600">Completed</div>
            <div class="mt-3 text-3xl font-semibold text-neutral-900">{{ $counts['completed'] ?? 0 }}</div>
            <div class="mt-2 text-sm text-neutral-500">Tasks already completed</div>
        </div>
        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
            <div class="text-sm font-semibold text-neutral-600">Overdue</div>
            <div class="mt-3 text-3xl font-semibold text-danger-700">{{ $counts['overdue'] ?? 0 }}</div>
            <div class="mt-2 text-sm text-neutral-500">Not completed by the due date</div>
        </div>
    </div>

    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center sm:justify-end">
            <div class="relative w-full sm:w-64">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-neutral-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search tasks or interns..."
                    class="h-12 w-full rounded-2xl border border-neutral-200 bg-white pl-10 pr-4 text-sm font-semibold text-neutral-900 shadow-soft placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                />
            </div>

            <select
                wire:model.live="status"
                class="h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 sm:w-44"
            >
                <option value="all">All Status</option>
                <option value="pending_review">Pending Review</option>
                <option value="todo">Not Started</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
                <option value="overdue">Overdue</option>
            </select>

            <select
                wire:model.live="internship"
                class="h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 sm:w-52"
            >
                <option value="">All Internships</option>
                @foreach($internships as $internship)
                    <option value="{{ $internship->id }}">{{ $internship->title }}</option>
                @endforeach
            </select>

            <div class="relative w-full sm:w-44">
                <input
                    type="date"
                    wire:model.live="dueDate"
                    class="h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                />
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <div class="space-y-6 lg:col-span-8">
            <div class="rounded-2xl border border-neutral-200 bg-white shadow-card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-200">
                        <thead class="bg-neutral-50">
                            <tr class="text-left text-xs font-semibold uppercase tracking-wide text-neutral-500">
                                <th class="px-4 py-3">Task</th>
                                <th class="px-4 py-3">Intern</th>
                                <th class="px-4 py-3">Internship</th>
                                <th class="px-4 py-3">Due Date</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Priority</th>
                                <th class="px-4 py-3">Submission</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-100">
                            @forelse($tasks as $task)
                                @php
                                    $statusBadge = $statusPills[$task['status_key']] ?? 'bg-neutral-100 text-neutral-700 ring-neutral-200';
                                    $priorityDot = $priorityDots[$task['priority_key']] ?? 'bg-neutral-300';
                                    $dueClasses = $task['is_overdue'] ? 'text-danger-700' : 'text-neutral-700';
                                    $statusLabel = $task['is_overdue'] ? 'Overdue' : $task['status'];
                                @endphp

                                <tr class="transition {{ $task['is_selected'] ? 'bg-primary-50/60' : 'hover:bg-neutral-50/60' }}">
                                    <td class="px-4 py-4 min-w-64">
                                        <button
                                            type="button"
                                            wire:click="selectTask({{ $task['id'] }})"
                                            class="text-left text-sm font-semibold text-neutral-900 transition hover:text-primary-700"
                                        >
                                            {{ $task['title'] }}
                                        </button>
                                        @if($task['description'])
                                            <div class="mt-1 line-clamp-2 text-xs font-semibold text-neutral-500">{{ $task['description'] }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 min-w-48">
                                        <div class="text-sm font-semibold text-neutral-900">{{ $task['student_name'] }}</div>
                                        @if($task['student_department'])
                                            <div class="mt-1 text-xs font-semibold text-neutral-500">{{ $task['student_department'] }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 min-w-48">
                                        <div class="text-sm font-semibold text-neutral-900">{{ $task['internship_title'] }}</div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm font-semibold {{ $dueClasses }}">{{ $task['due_label'] }}</div>
                                        @if($task['due_meta_label'])
                                            <div class="mt-1 text-xs font-semibold {{ $task['due_meta_class'] }}">{{ $task['due_meta_label'] }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $task['is_overdue'] ? 'bg-danger-50 text-danger-700 ring-danger-100' : $statusBadge }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-2 text-sm font-semibold text-neutral-700">
                                            <span class="h-2 w-2 rounded-full {{ $priorityDot }}"></span>
                                            {{ $task['priority'] }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 min-w-56">
                                        @if($task['has_submission'])
                                            <div class="space-y-2">
                                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $task['latest_submission_status_class'] }}">
                                                    {{ $task['latest_submission_status_label'] }}
                                                </span>
                                                <div class="text-xs font-semibold text-neutral-500">
                                                    {{ $task['submission_count'] }} {{ \Illuminate\Support\Str::plural('submission', $task['submission_count']) }}
                                                    @if($task['latest_submission_label'])
                                                        • {{ $task['latest_submission_label'] }}
                                                    @endif
                                                </div>
                                                @if($task['latest_submission_feedback'])
                                                    <div class="text-xs text-neutral-600">{{ $task['latest_submission_feedback'] }}</div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-sm font-semibold text-neutral-500">No submissions yet</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <button
                                            type="button"
                                            wire:click="selectTask({{ $task['id'] }})"
                                            class="inline-flex h-10 items-center justify-center rounded-xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25"
                                        >
                                            {{ $task['has_submission'] ? 'Review' : 'View' }}
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center text-sm font-semibold text-neutral-600">
                                        No tasks found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:items-center sm:justify-between">
                <div class="text-sm font-semibold text-neutral-600">
                    Showing {{ $tasks->firstItem() ?? 0 }} to {{ $tasks->lastItem() ?? 0 }} of {{ $tasks->total() }} tasks
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-4">
                    <div class="flex items-center gap-2">
                        <label for="company-tasks-per-page" class="text-sm font-semibold text-neutral-700">Per page:</label>
                        <select
                            id="company-tasks-per-page"
                            wire:model.live="perPage"
                            class="h-11 rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                        >
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" wire:click="previousPage" @disabled($tasks->onFirstPage()) class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900 disabled:cursor-not-allowed disabled:opacity-50">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        @php
                            $current = $tasks->currentPage();
                            $last = $tasks->lastPage();
                            $start = max(1, $current - 1);
                            $end = min($last, $current + 1);
                        @endphp

                        @for($page = $start; $page <= $end; $page++)
                            <button type="button" wire:click="gotoPage({{ $page }})" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border text-sm font-semibold shadow-soft transition focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 {{ $page === $current ? 'border-primary-600 bg-primary-600 text-white' : 'border-neutral-200 bg-white text-neutral-700 hover:bg-neutral-50' }}">
                                {{ $page }}
                            </button>
                        @endfor

                        <button type="button" wire:click="nextPage" @disabled(! $tasks->hasMorePages()) class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900 disabled:cursor-not-allowed disabled:opacity-50">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <aside class="space-y-6 lg:col-span-4">
            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-900">Submission Review</h2>
                        <p class="mt-1 text-sm text-neutral-600">Use existing task history to confirm progress or request changes.</p>
                    </div>
                </div>

                @if($selectedTask)
                    <div class="mt-5 rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-4">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <h3 class="text-base font-semibold text-neutral-900">{{ $selectedTask['title'] }}</h3>
                                <p class="mt-1 text-sm text-neutral-600">
                                    {{ $selectedTask['student_name'] }}
                                    @if($selectedTask['student_matricule'])
                                        • {{ $selectedTask['student_matricule'] }}
                                    @endif
                                </p>
                            </div>
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $selectedTask['latest_submission_status_class'] }}">
                                {{ $selectedTask['latest_submission_status_label'] }}
                            </span>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <div class="font-semibold text-neutral-500">Task Status</div>
                                <div class="mt-1 font-semibold text-neutral-900">{{ $selectedTask['status_label'] }}</div>
                            </div>
                            <div>
                                <div class="font-semibold text-neutral-500">Due Date</div>
                                <div class="mt-1 font-semibold text-neutral-900">{{ $selectedTask['due_label'] }}</div>
                            </div>
                            <div>
                                <div class="font-semibold text-neutral-500">Internship</div>
                                <div class="mt-1 font-semibold text-neutral-900">{{ $selectedTask['internship_title'] }}</div>
                            </div>
                            <div>
                                <div class="font-semibold text-neutral-500">Assigned By</div>
                                <div class="mt-1 font-semibold text-neutral-900">{{ $selectedTask['assigned_by_name'] ?? '—' }}</div>
                            </div>
                            <div>
                                <div class="font-semibold text-neutral-500">Latest Submission</div>
                                <div class="mt-1 font-semibold text-neutral-900">{{ $selectedTask['latest_submission_label'] ?? 'Not submitted yet' }}</div>
                            </div>
                            <div>
                                <div class="font-semibold text-neutral-500">Submission History</div>
                                <div class="mt-1 font-semibold text-neutral-900">{{ $selectedTask['submission_count'] }} {{ \Illuminate\Support\Str::plural('entry', $selectedTask['submission_count']) }}</div>
                            </div>
                        </div>

                        @if($selectedTask['student_department'] || $selectedTask['description'])
                            <div class="mt-4 space-y-3">
                                @if($selectedTask['student_department'])
                                    <div class="rounded-2xl bg-white px-4 py-3 text-sm text-neutral-700">
                                        <div class="font-semibold text-neutral-500">Department</div>
                                        <div class="mt-1">{{ $selectedTask['student_department'] }}</div>
                                    </div>
                                @endif

                                @if($selectedTask['description'])
                                    <div class="rounded-2xl bg-white px-4 py-3 text-sm text-neutral-700">
                                        <div class="font-semibold text-neutral-500">Task Brief</div>
                                        <div class="mt-1 whitespace-pre-line">{{ $selectedTask['description'] }}</div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    @if($selectedTask['can_review_latest_submission'])
                        <div class="mt-5">
                            <label for="company-reviewer-feedback" class="text-sm font-semibold text-neutral-700">Reviewer Feedback</label>
                            <textarea
                                id="company-reviewer-feedback"
                                rows="4"
                                wire:model.defer="reviewerFeedback"
                                placeholder="Share what is approved or what needs to be updated."
                                class="mt-2 w-full rounded-xl border border-neutral-200 bg-white px-3 py-3 text-sm font-semibold text-neutral-900 shadow-soft placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                            ></textarea>
                            @error('reviewerFeedback')<div class="mt-2 text-xs font-semibold text-danger-600">{{ $message }}</div>@enderror
                        </div>

                        <div class="mt-5 flex flex-wrap gap-3">
                            <button
                                type="button"
                                wire:click="markSubmissionReviewed"
                                class="inline-flex h-11 items-center justify-center rounded-xl bg-success-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-success-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-success-500/25"
                            >
                                Mark Reviewed
                            </button>
                            <button
                                type="button"
                                wire:click="markSubmissionForRework"
                                class="inline-flex h-11 items-center justify-center rounded-xl bg-danger-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-danger-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-danger-500/25"
                            >
                                Request Rework
                            </button>
                        </div>
                    @else
                        <div class="mt-5 rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-3 text-sm text-neutral-600">
                            The latest submission is not awaiting review. Use the history below to inspect earlier decisions and feedback.
                        </div>
                    @endif

                    <div class="mt-6">
                        <div class="flex items-center justify-between gap-3">
                            <h3 class="text-sm font-semibold text-neutral-900">Submission History</h3>
                            <div class="text-xs font-semibold uppercase tracking-wide text-neutral-500">Newest first</div>
                        </div>

                        <div class="mt-4 space-y-4">
                            @forelse($selectedTask['history'] as $entry)
                                <div class="rounded-2xl border {{ $entry['is_latest'] ? 'border-primary-200 bg-primary-50/40' : 'border-neutral-200 bg-white' }} px-4 py-4">
                                    <div class="flex flex-wrap items-start justify-between gap-3">
                                        <div>
                                            <div class="text-sm font-semibold text-neutral-900">{{ $entry['submitted_label'] }}</div>
                                            @if($entry['is_latest'])
                                                <div class="mt-1 text-xs font-semibold uppercase tracking-wide text-primary-700">Latest submission</div>
                                            @endif
                                        </div>
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $entry['status_class'] }}">
                                            {{ $entry['status_label'] }}
                                        </span>
                                    </div>

                                    <div class="mt-4 whitespace-pre-line text-sm text-neutral-700">{{ $entry['update_text'] }}</div>

                                    @if($entry['attachments'])
                                        <div class="mt-4 space-y-2">
                                            <div class="text-xs font-semibold uppercase tracking-wide text-neutral-500">Evidence</div>
                                            @foreach($entry['attachments'] as $attachment)
                                                <a
                                                    href="{{ $attachment['url'] }}"
                                                    target="_blank"
                                                    rel="noreferrer"
                                                    class="flex items-center justify-between gap-3 rounded-xl border border-neutral-200 bg-white px-3 py-3 text-sm font-semibold text-primary-700 transition hover:border-primary-200 hover:bg-primary-50"
                                                >
                                                    <span class="truncate">{{ $attachment['name'] }}</span>
                                                    <span class="shrink-0 text-neutral-500">{{ $attachment['size_label'] }}</span>
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if($entry['reviewer_feedback'])
                                        <div class="mt-4 rounded-2xl border border-warning-100 bg-warning-50 px-4 py-3 text-sm text-warning-800">
                                            <div class="font-semibold">Reviewer Feedback</div>
                                            <div class="mt-1">{{ $entry['reviewer_feedback'] }}</div>
                                            @if($entry['reviewer_name'] || $entry['reviewed_label'])
                                                <div class="mt-2 text-xs font-semibold text-warning-700">
                                                    {{ $entry['reviewer_name'] ?? 'Reviewer' }}@if($entry['reviewed_label']) • {{ $entry['reviewed_label'] }}@endif
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="rounded-2xl border border-dashed border-neutral-200 bg-white p-8 text-center text-sm text-neutral-600">
                                    No submissions yet. The intern will appear here after sending an update.
                                </div>
                            @endforelse
                        </div>
                    </div>
                @else
                    <div class="mt-5 rounded-2xl border border-dashed border-neutral-200 bg-white p-8 text-center text-sm text-neutral-600">
                        Select a task to review submission history and make a decision.
                    </div>
                @endif
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <h2 class="text-sm font-semibold text-neutral-900">Pending Queue</h2>
                    <button type="button" wire:click="$set('status', 'pending_review')" class="text-sm font-semibold text-primary-700 hover:text-primary-800">View All</button>
                </div>

                <div class="mt-5 space-y-3">
                    @forelse($pendingReviews as $row)
                        <button
                            type="button"
                            wire:click="selectTask({{ $row['id'] }})"
                            class="flex w-full items-start gap-3 rounded-2xl border border-neutral-200 bg-white px-4 py-3 text-left shadow-soft transition hover:border-primary-200 hover:bg-primary-50/40"
                        >
                            <div class="mt-1 h-9 w-9 shrink-0 rounded-full bg-warning-100 text-warning-700 flex items-center justify-center text-xs font-semibold">
                                {{ strtoupper(substr($row['student_name'] ?: '—', 0, 1)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-semibold text-neutral-900 line-clamp-2">{{ $row['title'] }}</div>
                                <div class="mt-1 text-xs font-semibold text-neutral-500">{{ $row['student_name'] }}</div>
                            </div>
                            <div class="shrink-0 text-xs font-semibold text-warning-700">{{ $row['submitted_label'] }}</div>
                        </button>
                    @empty
                        <div class="rounded-2xl border border-dashed border-neutral-200 bg-white p-8 text-center text-sm font-semibold text-neutral-600">
                            No submissions pending review.
                        </div>
                    @endforelse
                </div>
            </div>
        </aside>
    </div>
</div>
