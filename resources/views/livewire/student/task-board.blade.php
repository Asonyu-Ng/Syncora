@php
    $statusPills = [
        'todo' => 'bg-secondary-50 text-secondary-700 ring-secondary-100 dark:bg-secondary-500/10 dark:text-secondary-200 dark:ring-secondary-500/20',
        'in_progress' => 'bg-info-50 text-info-700 ring-info-100 dark:bg-info-500/10 dark:text-info-200 dark:ring-info-500/20',
        'completed' => 'bg-success-50 text-success-700 ring-success-100 dark:bg-success-500/10 dark:text-success-200 dark:ring-success-500/20',
    ];

    $priorityPills = [
        'high' => 'bg-danger-50 text-danger-700 ring-danger-100 dark:bg-danger-500/10 dark:text-danger-200 dark:ring-danger-500/20',
        'medium' => 'bg-warning-50 text-warning-700 ring-warning-100 dark:bg-warning-500/10 dark:text-warning-200 dark:ring-warning-500/20',
        'low' => 'bg-success-50 text-success-700 ring-success-100 dark:bg-success-500/10 dark:text-success-200 dark:ring-success-500/20',
        'none' => 'bg-neutral-100 text-neutral-500 ring-neutral-200 dark:bg-neutral-900 dark:text-neutral-300 dark:ring-neutral-800',
    ];
@endphp

<div class="space-y-6">
    <x-dashboard.page-header
        badge="Task Board"
        title="My Tasks"
        description="Track your assigned tasks, submit progress updates, and keep evidence in one place."
    >
        <x-slot:actions>
            <button
                type="button"
                wire:click="openSubmitModal"
                class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Submit
            </button>
        </x-slot:actions>
    </x-dashboard.page-header>

    @if(session('message'))
        <div class="rounded-2xl border border-primary-100 bg-primary-50 px-5 py-4 text-sm font-semibold text-primary-800 dark:border-primary-500/20 dark:bg-primary-500/10 dark:text-primary-200">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-5">
        <div class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-card sm:p-5 dark:border-neutral-800 dark:bg-neutral-950">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-neutral-600 dark:text-neutral-300">Total Tasks</p>
                    <p class="mt-2 text-3xl font-semibold text-neutral-900 dark:text-neutral-50">{{ $counts['all'] ?? 0 }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-secondary-50 text-secondary-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <p class="mt-2 text-[13px] leading-5 text-neutral-600 dark:text-neutral-400">All assigned tasks</p>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-card sm:p-5 dark:border-neutral-800 dark:bg-neutral-950">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-neutral-600 dark:text-neutral-300">Pending</p>
                    <p class="mt-2 text-3xl font-semibold text-neutral-900 dark:text-neutral-50">{{ $counts['todo'] ?? 0 }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-warning-50 text-warning-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="mt-2 text-[13px] leading-5 text-neutral-600 dark:text-neutral-400">Items waiting for you to start.</p>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-card sm:p-5 dark:border-neutral-800 dark:bg-neutral-950">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-neutral-600 dark:text-neutral-300">In Progress</p>
                    <p class="mt-2 text-3xl font-semibold text-neutral-900 dark:text-neutral-50">{{ $counts['in_progress'] ?? 0 }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-info-50 text-info-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="mt-2 text-[13px] leading-5 text-neutral-600 dark:text-neutral-400">Tasks you are actively working on.</p>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-card sm:p-5 dark:border-neutral-800 dark:bg-neutral-950">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-neutral-600 dark:text-neutral-300">Completed</p>
                    <p class="mt-2 text-3xl font-semibold text-neutral-900 dark:text-neutral-50">{{ $counts['completed'] ?? 0 }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-success-50 text-success-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <p class="mt-2 text-[13px] leading-5 text-neutral-600 dark:text-neutral-400">Tasks completed</p>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-card sm:p-5 dark:border-neutral-800 dark:bg-neutral-950">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-neutral-600 dark:text-neutral-300">Overdue</p>
                    <p class="mt-2 text-3xl font-semibold text-neutral-900 dark:text-neutral-50">{{ $counts['overdue'] ?? 0 }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-danger-50 text-danger-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="mt-2 text-[13px] leading-5 text-neutral-600 dark:text-neutral-400">Past due and not completed yet.</p>
        </div>
    </div>

    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex overflow-x-auto border-b border-neutral-200 pb-1 -mx-3 px-3 sm:mx-0 sm:px-0 dark:border-neutral-800">
            @foreach($tabs as $entry)
                @php $active = $tab === $entry['key']; @endphp

                <button
                    type="button"
                    wire:click="$set('tab', '{{ $entry['key'] }}')"
                    class="mr-6 whitespace-nowrap border-b-2 pb-3 text-sm font-semibold transition focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 {{ $active ? 'border-primary-600 text-primary-700 dark:text-primary-200' : 'border-transparent text-neutral-600 hover:text-neutral-900 dark:text-neutral-300 dark:hover:text-neutral-50' }}"
                >
                    {{ $entry['label'] }} ({{ $entry['count'] }})
                </button>
            @endforeach
        </div>

        <div class="flex flex-wrap items-center gap-3 justify-between sm:justify-end">
            <button type="button" class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-50 dark:hover:bg-neutral-900">
                <svg class="h-4 w-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 12.414V19a1 1 0 01-.553.894l-4 2A1 1 0 019 21v-8.586L3.293 6.707A1 1 0 013 6V4z" />
                </svg>
                Filter
            </button>

            <div class="flex items-center gap-2">
                <label for="task-sort" class="text-sm font-semibold text-neutral-700 dark:text-neutral-200">Sort by:</label>
                <select
                    id="task-sort"
                    wire:model.live="sort"
                    class="h-11 rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-100"
                >
                    <option value="due_asc">Due Date</option>
                    <option value="due_desc">Due Date (Latest)</option>
                </select>
            </div>
        </div>
    </div>

    <x-dashboard.two-column>
        <x-slot:main>
        <div class="space-y-6">
            <div class="rounded-2xl border border-neutral-200 bg-white shadow-card overflow-hidden dark:border-neutral-800 dark:bg-neutral-950">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-800">
                        <thead class="bg-neutral-50 dark:bg-neutral-900/60">
                            <tr class="text-left text-xs font-semibold uppercase tracking-wide text-neutral-500 dark:text-neutral-400">
                                <th class="px-4 py-3 w-10">
                                    <input type="checkbox" class="h-4 w-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500/20 dark:border-neutral-700 dark:bg-neutral-950" disabled />
                                </th>
                                <th class="px-4 py-3">Task</th>
                                <th class="px-4 py-3">Internship</th>
                                <th class="px-4 py-3">Due date</th>
                                <th class="px-4 py-3">Priority</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Submission</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                            @forelse($tasks as $task)
                                @php
                                    $statusBadge = $statusPills[$task['status_key']] ?? 'bg-neutral-100 text-neutral-700 ring-neutral-200 dark:bg-neutral-900 dark:text-neutral-200 dark:ring-neutral-800';
                                    $priorityBadge = $priorityPills[$task['priority_key']] ?? 'bg-neutral-100 text-neutral-700 ring-neutral-200 dark:bg-neutral-900 dark:text-neutral-200 dark:ring-neutral-800';
                                    $dueClasses = $task['is_overdue'] ? 'text-danger-700 dark:text-danger-300' : 'text-neutral-700 dark:text-neutral-300';
                                @endphp

                                <tr class="transition {{ $task['is_selected'] ? 'bg-primary-50/60 dark:bg-primary-500/10' : 'hover:bg-neutral-50/60 dark:hover:bg-neutral-900/50' }}">
                                    <td class="px-4 py-4">
                                        <input
                                            type="checkbox"
                                            class="h-4 w-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500/20 dark:border-neutral-700 dark:bg-neutral-950"
                                            wire:click.stop="toggleComplete({{ $task['id'] }})"
                                            @checked($task['is_completed'])
                                        />
                                    </td>
                                    <td class="px-4 py-4 min-w-72">
                                        <button
                                            type="button"
                                            wire:click="selectTask({{ $task['id'] }})"
                                            class="text-left text-sm font-semibold text-neutral-900 transition hover:text-primary-700 dark:text-neutral-50 dark:hover:text-primary-200"
                                        >
                                            {{ $task['title'] }}
                                        </button>
                                        @if($task['description'])
                                            <div class="mt-1 line-clamp-2 text-sm text-neutral-600 dark:text-neutral-300">{{ $task['description'] }}</div>
                                        @endif
                                        @if($task['has_submission'])
                                            <div class="mt-2 flex flex-wrap items-center gap-2 text-xs font-semibold text-neutral-500 dark:text-neutral-400">
                                                <span>{{ $task['submission_count'] }} {{ \Illuminate\Support\Str::plural('submission', $task['submission_count']) }}</span>
                                                @if($task['latest_submission_label'])
                                                    <span>&bull;</span>
                                                    <span>Last update {{ $task['latest_submission_label'] }}</span>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        @if($task['internship_id'])
                                            <a href="{{ route('student.internships.show', $task['internship_id']) }}" class="text-sm font-semibold text-neutral-900 hover:text-primary-600 dark:text-neutral-50 dark:hover:text-primary-200">
                                                {{ $task['internship_title'] }}
                                            </a>
                                            @if($task['company_name'])
                                                <div class="mt-1 text-xs font-semibold text-neutral-500 dark:text-neutral-400">{{ $task['company_name'] }}</div>
                                            @endif
                                        @else
                                            <span class="text-sm font-semibold text-neutral-500 dark:text-neutral-400">{{ $task['internship_title'] }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm font-semibold {{ $dueClasses }}">{{ $task['due_label'] }}</div>
                                        @if($task['due_meta_label'])
                                            <div class="mt-1 text-xs font-semibold {{ $task['due_meta_class'] }}">{{ $task['due_meta_label'] }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $priorityBadge }}">
                                            {{ $task['priority'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $task['is_overdue'] ? 'bg-danger-50 text-danger-700 ring-danger-100 dark:bg-danger-500/10 dark:text-danger-200 dark:ring-danger-500/20' : $statusBadge }}">
                                            {{ $task['is_overdue'] ? 'Overdue' : $task['status'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 min-w-56">
                                        @if($task['has_submission'])
                                            <div class="space-y-2">
                                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $task['latest_submission_status_class'] }}">
                                                    {{ $task['latest_submission_status_label'] }}
                                                </span>
                                                @if($task['latest_submission_feedback'])
                                                    <div class="text-xs text-neutral-600 dark:text-neutral-300">{{ $task['latest_submission_feedback'] }}</div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-sm font-semibold text-neutral-500 dark:text-neutral-400">No submissions yet</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <x-dropdown align="right" width="48" contentClasses="py-1 bg-white dark:bg-neutral-950">
                                            <x-slot name="trigger">
                                                <button type="button" aria-label="Task actions" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-50">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6h.01M12 12h.01M12 18h.01" />
                                                    </svg>
                                                </button>
                                            </x-slot>

                                            <x-slot name="content">
                                                @if($task['internship_id'])
                                                    <a href="{{ route('student.internships.show', $task['internship_id']) }}" class="block px-4 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-50 dark:text-neutral-200 dark:hover:bg-neutral-900">
                                                        View Internship
                                                    </a>
                                                @endif
                                                <button type="button" wire:click="openSubmitModal({{ $task['id'] }})" class="block w-full px-4 py-2 text-left text-sm font-semibold text-neutral-700 hover:bg-neutral-50 dark:text-neutral-200 dark:hover:bg-neutral-900">
                                                    {{ $task['has_submission'] ? 'Submit Resubmission' : 'Submit Update' }}
                                                </button>
                                                <button type="button" wire:click="selectTask({{ $task['id'] }})" class="block w-full px-4 py-2 text-left text-sm font-semibold text-neutral-700 hover:bg-neutral-50 dark:text-neutral-200 dark:hover:bg-neutral-900">
                                                    View Submission History
                                                </button>
                                                <button type="button" wire:click="toggleComplete({{ $task['id'] }})" class="block w-full px-4 py-2 text-left text-sm font-semibold text-neutral-700 hover:bg-neutral-50 dark:text-neutral-200 dark:hover:bg-neutral-900">
                                                    {{ $task['is_completed'] ? 'Mark as To Do' : 'Mark as Completed' }}
                                                </button>
                                            </x-slot>
                                        </x-dropdown>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-neutral-100 text-neutral-500 dark:bg-neutral-900 dark:text-neutral-400">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 6H7a2 2 0 01-2-2V4a2 2 0 012-2h7l5 5v13a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <h3 class="mt-4 text-base font-semibold text-neutral-900 dark:text-neutral-50">No tasks found</h3>
                                        <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-300">Try switching tabs or adjusting the sort order.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:items-center sm:justify-between">
                <div class="text-sm font-semibold text-neutral-600 dark:text-neutral-300">
                    Showing {{ $tasks->firstItem() ?? 0 }} to {{ $tasks->lastItem() ?? 0 }} of {{ $tasks->total() }} tasks
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" wire:click="previousPage" @disabled($tasks->onFirstPage()) class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-50">
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
                        <button type="button" wire:click="gotoPage({{ $page }})" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border text-sm font-semibold shadow-soft transition focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 {{ $page === $current ? 'border-primary-600 bg-primary-600 text-white' : 'border-neutral-200 bg-white text-neutral-700 hover:bg-neutral-50 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-200 dark:hover:bg-neutral-900' }}">
                            {{ $page }}
                        </button>
                    @endfor

                    <button type="button" wire:click="nextPage" @disabled(! $tasks->hasMorePages()) class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-50">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        </x-slot:main>

        <x-slot:aside>
            <x-widget title="Submission Overview">
                <x-slot:actions>
                    <button
                        type="button"
                        wire:click="openSubmitModal"
                        class="inline-flex h-9 items-center justify-center rounded-xl bg-primary-600 px-3 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25"
                    >
                        Submit
                    </button>
                </x-slot:actions>
                <p class="text-[13px] leading-5 text-neutral-600 dark:text-neutral-300">Open the submit modal to send an update, upload evidence, and review feedback history here.</p>

                @if($selectedTask)
                    <div class="rounded-2xl border border-neutral-200 bg-neutral-50/80 px-4 py-4 dark:border-neutral-800 dark:bg-neutral-900/40">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <h3 class="text-base font-semibold text-neutral-900 dark:text-neutral-50">{{ $selectedTask['title'] }}</h3>
                                <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-300">
                                    {{ $selectedTask['internship_title'] }}@if($selectedTask['company_name']) • {{ $selectedTask['company_name'] }}@endif
                                </p>
                            </div>
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $selectedTask['latest_submission_status_class'] }}">
                                {{ $selectedTask['latest_submission_status_label'] }}
                            </span>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <div class="font-semibold text-neutral-500 dark:text-neutral-400">Task Status</div>
                                <div class="mt-1 font-semibold text-neutral-900 dark:text-neutral-50">{{ $selectedTask['status_label'] }}</div>
                            </div>
                            <div>
                                <div class="font-semibold text-neutral-500 dark:text-neutral-400">Due Date</div>
                                <div class="mt-1 font-semibold text-neutral-900 dark:text-neutral-50">{{ $selectedTask['due_label'] }}</div>
                            </div>
                            <div>
                                <div class="font-semibold text-neutral-500 dark:text-neutral-400">Submission History</div>
                                <div class="mt-1 font-semibold text-neutral-900 dark:text-neutral-50">{{ $selectedTask['submission_count'] }} {{ \Illuminate\Support\Str::plural('entry', $selectedTask['submission_count']) }}</div>
                            </div>
                            <div>
                                <div class="font-semibold text-neutral-500 dark:text-neutral-400">Latest Update</div>
                                <div class="mt-1 font-semibold text-neutral-900 dark:text-neutral-50">{{ $selectedTask['latest_submission_label'] ?? 'Not submitted yet' }}</div>
                            </div>
                        </div>

                        @if($selectedTask['description'])
                            <div class="mt-4 rounded-2xl bg-white px-4 py-3 text-sm leading-6 text-neutral-700 dark:bg-neutral-950 dark:text-neutral-200">
                                {{ $selectedTask['description'] }}
                            </div>
                        @endif

                        @if($selectedTask['latest_submission_feedback'])
                            <div class="mt-4 rounded-2xl border border-warning-100 bg-warning-50 px-4 py-3 text-sm text-warning-800 dark:border-warning-500/20 dark:bg-warning-500/10 dark:text-warning-200">
                                <div class="font-semibold">Latest Reviewer Feedback</div>
                                <div class="mt-1">{{ $selectedTask['latest_submission_feedback'] }}</div>
                            </div>
                        @endif
                    </div>

                    <div class="mt-5">
                        <div class="flex items-center justify-between gap-3">
                            <h3 class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">Submission History</h3>
                            <div class="text-[11px] font-semibold uppercase tracking-[0.12em] text-neutral-500 dark:text-neutral-400">Newest first</div>
                        </div>

                        <div class="mt-4 space-y-3">
                            @forelse($selectedTask['history'] as $entry)
                                <div class="rounded-2xl border {{ $entry['is_latest'] ? 'border-primary-200 bg-primary-50/35 dark:border-primary-500/20 dark:bg-primary-500/10' : 'border-neutral-200 bg-white dark:border-neutral-800 dark:bg-neutral-950' }} px-4 py-4">
                                    <div class="flex flex-wrap items-start justify-between gap-3">
                                        <div>
                                            <div class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">{{ $entry['submitted_label'] }}</div>
                                            @if($entry['is_latest'])
                                                <div class="mt-1 text-[11px] font-semibold uppercase tracking-[0.12em] text-primary-700 dark:text-primary-200">Latest submission</div>
                                            @endif
                                        </div>
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $entry['status_class'] }}">
                                            {{ $entry['status_label'] }}
                                        </span>
                                    </div>

                                    <div class="mt-4 whitespace-pre-line text-sm text-neutral-700 dark:text-neutral-200">{{ $entry['update_text'] }}</div>

                                    @if($entry['attachments'])
                                        <div class="mt-4 space-y-2">
                                            <div class="text-[11px] font-semibold uppercase tracking-[0.12em] text-neutral-500 dark:text-neutral-400">Evidence</div>
                                            @foreach($entry['attachments'] as $attachment)
                                                <a
                                                    href="{{ $attachment['url'] }}"
                                                    target="_blank"
                                                    rel="noreferrer"
                                                    class="flex items-center justify-between gap-3 rounded-xl border border-neutral-200 bg-white px-3 py-3 text-sm font-semibold text-primary-700 transition hover:border-primary-200 hover:bg-primary-50 dark:border-neutral-800 dark:bg-neutral-950 dark:text-primary-200 dark:hover:border-primary-500/20 dark:hover:bg-primary-500/10"
                                                >
                                                    <span class="truncate">{{ $attachment['name'] }}</span>
                                                    <span class="shrink-0 text-neutral-500 dark:text-neutral-400">{{ $attachment['size_label'] }}</span>
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if($entry['reviewer_feedback'])
                                        <div class="mt-4 rounded-2xl border border-warning-100 bg-warning-50 px-4 py-3 text-sm text-warning-800 dark:border-warning-500/20 dark:bg-warning-500/10 dark:text-warning-200">
                                            <div class="font-semibold">Reviewer Feedback</div>
                                            <div class="mt-1">{{ $entry['reviewer_feedback'] }}</div>
                                            @if($entry['reviewer_name'] || $entry['reviewed_label'])
                                                <div class="mt-2 text-xs font-semibold text-warning-700 dark:text-warning-200">
                                                    {{ $entry['reviewer_name'] ?? 'Reviewer' }}@if($entry['reviewed_label']) • {{ $entry['reviewed_label'] }}@endif
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="rounded-2xl border border-dashed border-neutral-200 bg-white p-8 text-center text-sm text-neutral-600 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-300">
                                    No submissions yet. Use the form above to send your first update.
                                </div>
                            @endforelse
                        </div>
                    </div>
                @else
                    <div class="rounded-2xl border border-dashed border-neutral-200 bg-white p-8 text-center text-sm text-neutral-600 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-300">
                        Select a task to review its submission history, or use the submit modal to choose a task and send an update.
                    </div>
                @endif
            </x-widget>

            <x-widget title="Upcoming Deadlines">
                <x-slot:actions>
                    <a href="{{ route('student.tasks.board') }}" class="text-sm font-semibold text-primary-700 hover:text-primary-800 dark:text-primary-200 dark:hover:text-primary-100">View all</a>
                </x-slot:actions>
                <div class="mt-4 space-y-3.5">
                    @forelse($upcomingDeadlines as $item)
                        @php
                            $metaLabel = $item['meta']['label'] ?? null;
                            $metaClass = $item['meta']['class'] ?? 'text-neutral-500';
                            $dotClass = str_contains($metaClass, 'danger') ? 'bg-danger-500' : (str_contains($metaClass, 'warning') ? 'bg-warning-500' : 'bg-info-500');
                        @endphp

                        <div class="flex gap-3">
                            <div class="mt-1 h-2 w-2 rounded-full {{ $dotClass }}"></div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-neutral-900 line-clamp-2 dark:text-neutral-50">{{ $item['title'] }}</p>
                                <p class="mt-1 text-xs font-semibold text-neutral-500 dark:text-neutral-400">
                                    {{ $item['internship_title'] }}@if($item['company_name']) • {{ $item['company_name'] }}@endif
                                </p>
                                <div class="mt-2 flex items-center justify-between">
                                    <div class="text-xs font-semibold text-neutral-500 dark:text-neutral-400">{{ $item['due_label'] }}</div>
                                    @if($metaLabel)
                                        <div class="text-xs font-semibold {{ $metaClass }}">{{ $metaLabel }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-neutral-200 bg-white p-8 text-center text-sm text-neutral-600 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-300">
                            No upcoming deadlines.
                        </div>
                    @endforelse
                </div>
            </x-widget>

            <x-widget title="Task Progress">
                <div class="mt-5 flex items-center gap-5">
                    <div class="relative h-28 w-28 shrink-0 rounded-full" style="background: {{ $progress['style'] }};">
                        <div class="absolute inset-3 rounded-full bg-white dark:bg-neutral-950"></div>
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                            <div class="text-2xl font-semibold text-neutral-900 dark:text-neutral-50">{{ $progress['total'] ?? 0 }}</div>
                            <div class="text-xs font-semibold text-neutral-500 dark:text-neutral-400">Total Tasks</div>
                        </div>
                    </div>

                    <div class="min-w-0 space-y-3">
                        @foreach(($progress['segments'] ?? []) as $segment)
                            <div class="flex items-center justify-between gap-4 text-sm font-semibold text-neutral-700 dark:text-neutral-200">
                                <div class="flex min-w-0 items-center gap-2">
                                    <span class="h-2.5 w-2.5 rounded-full {{ $segment['legend_class'] }}"></span>
                                    <span class="truncate">{{ $segment['label'] }}</span>
                                </div>
                                <div class="shrink-0 text-neutral-900 dark:text-neutral-50">{{ $segment['count'] }} ({{ $segment['percent'] }}%)</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-widget>
        </x-slot:aside>
    </x-dashboard.two-column>

    @if($showSubmitModal)
        <div class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0">
            <div wire:click="closeSubmitModal" class="fixed inset-0 bg-slate-900/60"></div>

            <div class="relative mx-auto w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-card ring-1 ring-neutral-200/70 dark:bg-neutral-950 dark:ring-neutral-800">
                <div class="flex items-start justify-between gap-4 border-b border-neutral-200 px-6 py-5 dark:border-neutral-800">
                    <div>
                        <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-50">Submit Task Update</h2>
                        <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-300">Choose a task, describe what you completed, and attach evidence files or images.</p>
                    </div>
                    <button
                        type="button"
                        wire:click="closeSubmitModal"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-50"
                    >
                        <span class="sr-only">Close modal</span>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-5 px-6 py-5">
                    <div>
                        <label for="submission-task-id" class="text-sm font-semibold text-neutral-700 dark:text-neutral-200">Choose Task</label>
                        <select
                            id="submission-task-id"
                            wire:model.live="submissionTaskId"
                            class="mt-2 h-11 w-full rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-100"
                        >
                            <option value="">Select a task</option>
                            @foreach($submissionTasks as $taskOption)
                                <option value="{{ $taskOption['id'] }}">
                                    {{ $taskOption['title'] }} - {{ $taskOption['internship_title'] }} - Due {{ $taskOption['due_label'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('submissionTaskId')<div class="mt-2 text-xs font-semibold text-danger-600">{{ $message }}</div>@enderror
                    </div>

                    @if($submissionTask)
                        <div class="rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-4 dark:border-neutral-800 dark:bg-neutral-900/40">
                            <div class="flex flex-wrap items-start justify-between gap-3">
                                <div>
                                    <h3 class="text-base font-semibold text-neutral-900 dark:text-neutral-50">{{ $submissionTask['title'] }}</h3>
                                    <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-300">
                                        {{ $submissionTask['internship_title'] }}@if($submissionTask['company_name']) • {{ $submissionTask['company_name'] }}@endif
                                    </p>
                                </div>
                                <div class="text-right text-sm">
                                    <div class="font-semibold text-neutral-900 dark:text-neutral-50">{{ $submissionTask['status_label'] }}</div>
                                    <div class="mt-1 text-xs font-semibold text-neutral-500 dark:text-neutral-400">Due {{ $submissionTask['due_label'] }}</div>
                                </div>
                            </div>
                            <div class="mt-4 flex flex-wrap items-center gap-3 text-xs font-semibold uppercase tracking-wide text-neutral-500 dark:text-neutral-400">
                                <span>{{ $submissionTask['submission_count'] }} {{ \Illuminate\Support\Str::plural('submission', $submissionTask['submission_count']) }}</span>
                                <span>Latest: {{ $submissionTask['latest_submission_label'] ?? 'Not submitted yet' }}</span>
                            </div>
                        </div>
                    @endif

                    <div>
                        <label for="submission-update" class="text-sm font-semibold text-neutral-700 dark:text-neutral-200">Written Update</label>
                        <textarea
                            id="submission-update"
                            rows="5"
                            wire:model.defer="submissionUpdate"
                            placeholder="Summarize the work completed, blockers, and what these files prove."
                            class="mt-2 w-full rounded-xl border border-neutral-200 bg-white px-3 py-3 text-sm font-semibold text-neutral-900 shadow-soft placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-100 dark:placeholder:text-neutral-500"
                        ></textarea>
                        @error('submissionUpdate')<div class="mt-2 text-xs font-semibold text-danger-600">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="submission-files" class="text-sm font-semibold text-neutral-700 dark:text-neutral-200">Evidence Files</label>
                        <input
                            id="submission-files"
                            type="file"
                            wire:model="submissionFiles"
                            multiple
                            class="mt-2 block w-full rounded-xl border border-neutral-200 bg-white px-3 py-3 text-sm font-semibold text-neutral-700 shadow-soft file:mr-4 file:rounded-lg file:border-0 file:bg-primary-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-primary-700 hover:file:bg-primary-100 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-200 dark:file:bg-primary-500/10 dark:file:text-primary-200 dark:hover:file:bg-primary-500/15"
                        />
                        <p class="mt-2 text-xs font-semibold text-neutral-500 dark:text-neutral-400">Up to 5 files. Supported: PDF, images, Word, Excel, CSV, and TXT. Max 5 MB each.</p>
                        @error('submissionFiles')<div class="mt-2 text-xs font-semibold text-danger-600">{{ $message }}</div>@enderror
                        @error('submissionFiles.*')<div class="mt-2 text-xs font-semibold text-danger-600">{{ $message }}</div>@enderror

                        @if($submissionFiles)
                            <div class="mt-3 rounded-2xl bg-neutral-50 px-4 py-3 dark:bg-neutral-900/40">
                                <div class="text-xs font-semibold uppercase tracking-wide text-neutral-500 dark:text-neutral-400">Ready to upload</div>
                                <div class="mt-2 space-y-2">
                                    @foreach($submissionFiles as $file)
                                        <div class="flex items-center justify-between gap-3 text-sm font-semibold text-neutral-700 dark:text-neutral-200">
                                            <span class="truncate">{{ $file->getClientOriginalName() }}</span>
                                            <span class="shrink-0 text-neutral-500 dark:text-neutral-400">{{ number_format($file->getSize() / 1024, 1) }} KB</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-neutral-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between dark:border-neutral-800">
                    <div wire:loading wire:target="submissionFiles,submitTaskUpdate" class="text-sm font-semibold text-primary-700 dark:text-primary-200">
                        Uploading and saving...
                    </div>
                    <div class="flex items-center justify-end gap-3">
                        <button
                            type="button"
                            wire:click="closeSubmitModal"
                            class="inline-flex h-11 items-center justify-center rounded-xl border border-neutral-200 bg-white px-5 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-200 dark:hover:bg-neutral-900"
                        >
                            Cancel
                        </button>
                        <button
                            type="button"
                            wire:click="submitTaskUpdate"
                            wire:loading.attr="disabled"
                            wire:target="submissionFiles,submitTaskUpdate"
                            class="inline-flex h-11 items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            {{ $submissionTask['submit_label'] ?? 'Submit Update' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
