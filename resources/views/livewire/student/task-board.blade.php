@php
    $statusPills = [
        'todo' => 'bg-secondary-50 text-secondary-700 ring-secondary-100',
        'in_progress' => 'bg-info-50 text-info-700 ring-info-100',
        'completed' => 'bg-success-50 text-success-700 ring-success-100',
    ];

    $priorityPills = [
        'high' => 'bg-danger-50 text-danger-700 ring-danger-100',
        'medium' => 'bg-warning-50 text-warning-700 ring-warning-100',
        'low' => 'bg-success-50 text-success-700 ring-success-100',
        'none' => 'bg-neutral-100 text-neutral-500 ring-neutral-200',
    ];
@endphp

<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div class="min-w-0">
            <h1 class="text-3xl font-semibold text-neutral-900 tracking-tight">My Tasks</h1>
            <p class="mt-2 text-sm text-neutral-600">Track and complete your assigned internship tasks.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-neutral-600">Total Tasks</p>
                    <p class="mt-3 text-3xl font-semibold text-neutral-900">{{ $counts['all'] ?? 0 }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-secondary-50 text-secondary-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-sm text-neutral-600">All assigned tasks</p>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-neutral-600">Pending</p>
                    <p class="mt-3 text-3xl font-semibold text-neutral-900">{{ $counts['todo'] ?? 0 }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-warning-50 text-warning-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-sm text-neutral-600">Items waiting for you to start.</p>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-neutral-600">In Progress</p>
                    <p class="mt-3 text-3xl font-semibold text-neutral-900">{{ $counts['in_progress'] ?? 0 }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-info-50 text-info-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-sm text-neutral-600">Tasks you are actively working on.</p>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-neutral-600">Completed</p>
                    <p class="mt-3 text-3xl font-semibold text-neutral-900">{{ $counts['completed'] ?? 0 }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-success-50 text-success-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-sm text-neutral-600">Tasks completed</p>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-neutral-600">Overdue</p>
                    <p class="mt-3 text-3xl font-semibold text-neutral-900">{{ $counts['overdue'] ?? 0 }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-danger-50 text-danger-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-sm text-neutral-600">Past due and not completed yet.</p>
        </div>
    </div>

    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex overflow-x-auto border-b border-neutral-200 pb-1 -mx-3 px-3 sm:mx-0 sm:px-0">
            @foreach($tabs as $entry)
                @php $active = $tab === $entry['key']; @endphp

                <button
                    type="button"
                    wire:click="$set('tab', '{{ $entry['key'] }}')"
                    class="mr-6 whitespace-nowrap border-b-2 pb-3 text-sm font-semibold transition focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 {{ $active ? 'border-primary-600 text-primary-700' : 'border-transparent text-neutral-600 hover:text-neutral-900' }}"
                >
                    {{ $entry['label'] }} ({{ $entry['count'] }})
                </button>
            @endforeach
        </div>

        <div class="flex flex-wrap items-center gap-3 justify-between sm:justify-end">
            <button type="button" class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                <svg class="h-4 w-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 12.414V19a1 1 0 01-.553.894l-4 2A1 1 0 019 21v-8.586L3.293 6.707A1 1 0 013 6V4z" />
                </svg>
                Filter
            </button>

            <div class="flex items-center gap-2">
                <label for="task-sort" class="text-sm font-semibold text-neutral-700">Sort by:</label>
                <select
                    id="task-sort"
                    wire:model.live="sort"
                    class="h-11 rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                >
                    <option value="due_asc">Due Date</option>
                    <option value="due_desc">Due Date (Latest)</option>
                </select>
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
                                <th class="px-4 py-3 w-10">
                                    <input type="checkbox" class="h-4 w-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500/20" disabled />
                                </th>
                                <th class="px-4 py-3">Task</th>
                                <th class="px-4 py-3">Internship</th>
                                <th class="px-4 py-3">Due date</th>
                                <th class="px-4 py-3">Priority</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-100">
                            @forelse($tasks as $task)
                                @php
                                    $statusBadge = $statusPills[$task['status_key']] ?? 'bg-neutral-100 text-neutral-700 ring-neutral-200';
                                    $priorityBadge = $priorityPills[$task['priority_key']] ?? 'bg-neutral-100 text-neutral-700 ring-neutral-200';
                                    $dueClasses = $task['is_overdue'] ? 'text-danger-700' : 'text-neutral-700';
                                @endphp

                                <tr class="hover:bg-neutral-50/60 transition">
                                    <td class="px-4 py-4">
                                        <input
                                            type="checkbox"
                                            class="h-4 w-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500/20"
                                            wire:click.stop="toggleComplete({{ $task['id'] }})"
                                            @checked($task['is_completed'])
                                        />
                                    </td>
                                    <td class="px-4 py-4 min-w-72">
                                        <div class="text-sm font-semibold text-neutral-900">{{ $task['title'] }}</div>
                                        @if($task['description'])
                                            <div class="mt-1 line-clamp-2 text-sm text-neutral-600">{{ $task['description'] }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        @if($task['internship_id'])
                                            <a href="{{ route('student.internships.show', $task['internship_id']) }}" class="text-sm font-semibold text-neutral-900 hover:text-primary-600">
                                                {{ $task['internship_title'] }}
                                            </a>
                                            @if($task['company_name'])
                                                <div class="mt-1 text-xs font-semibold text-neutral-500">{{ $task['company_name'] }}</div>
                                            @endif
                                        @else
                                            <span class="text-sm font-semibold text-neutral-500">{{ $task['internship_title'] }}</span>
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
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $task['is_overdue'] ? 'bg-danger-50 text-danger-700 ring-danger-100' : $statusBadge }}">
                                            {{ $task['is_overdue'] ? 'Overdue' : $task['status'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <x-dropdown align="right" width="48" contentClasses="py-1 bg-white">
                                            <x-slot name="trigger">
                                                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6h.01M12 12h.01M12 18h.01" />
                                                    </svg>
                                                </button>
                                            </x-slot>

                                            <x-slot name="content">
                                                @if($task['internship_id'])
                                                    <a href="{{ route('student.internships.show', $task['internship_id']) }}" class="block px-4 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-50">
                                                        View Internship
                                                    </a>
                                                @endif
                                                <button type="button" wire:click="toggleComplete({{ $task['id'] }})" class="block w-full px-4 py-2 text-left text-sm font-semibold text-neutral-700 hover:bg-neutral-50">
                                                    {{ $task['is_completed'] ? 'Mark as To Do' : 'Mark as Completed' }}
                                                </button>
                                            </x-slot>
                                        </x-dropdown>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-neutral-100 text-neutral-500">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 6H7a2 2 0 01-2-2V4a2 2 0 012-2h7l5 5v13a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <h3 class="mt-4 text-base font-semibold text-neutral-900">No tasks found</h3>
                                        <p class="mt-2 text-sm text-neutral-600">Try switching tabs or adjusting the sort order.</p>
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

        <aside class="space-y-6 lg:col-span-4">
            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-900">Upcoming Deadlines</h2>
                    </div>
                    <a href="{{ route('student.tasks.board') }}" class="text-sm font-semibold text-primary-700 hover:text-primary-800">View all</a>
                </div>

                <div class="mt-5 space-y-4">
                    @forelse($upcomingDeadlines as $item)
                        @php
                            $metaLabel = $item['meta']['label'] ?? null;
                            $metaClass = $item['meta']['class'] ?? 'text-neutral-500';
                            $dotClass = str_contains($metaClass, 'danger') ? 'bg-danger-500' : (str_contains($metaClass, 'warning') ? 'bg-warning-500' : 'bg-info-500');
                        @endphp

                        <div class="flex gap-3">
                            <div class="mt-1 h-2 w-2 rounded-full {{ $dotClass }}"></div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-neutral-900 line-clamp-2">{{ $item['title'] }}</p>
                                <p class="mt-1 text-xs font-semibold text-neutral-500">
                                    {{ $item['internship_title'] }}@if($item['company_name']) • {{ $item['company_name'] }}@endif
                                </p>
                                <div class="mt-2 flex items-center justify-between">
                                    <div class="text-xs font-semibold text-neutral-500">{{ $item['due_label'] }}</div>
                                    @if($metaLabel)
                                        <div class="text-xs font-semibold {{ $metaClass }}">{{ $metaLabel }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-neutral-200 bg-white p-8 text-center text-sm text-neutral-600">
                            No upcoming deadlines.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <h2 class="text-sm font-semibold text-neutral-900">Task Progress</h2>
                </div>

                <div class="mt-6 flex items-center gap-6">
                    <div class="relative h-28 w-28 shrink-0 rounded-full" style="background: {{ $progress['style'] }};">
                        <div class="absolute inset-3 rounded-full bg-white"></div>
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                            <div class="text-2xl font-semibold text-neutral-900">{{ $progress['total'] ?? 0 }}</div>
                            <div class="text-xs font-semibold text-neutral-500">Total Tasks</div>
                        </div>
                    </div>

                    <div class="min-w-0 space-y-3">
                        @foreach(($progress['segments'] ?? []) as $segment)
                            <div class="flex items-center justify-between gap-4 text-sm font-semibold text-neutral-700">
                                <div class="flex min-w-0 items-center gap-2">
                                    <span class="h-2.5 w-2.5 rounded-full {{ $segment['legend_class'] }}"></span>
                                    <span class="truncate">{{ $segment['label'] }}</span>
                                </div>
                                <div class="shrink-0 text-neutral-900">{{ $segment['count'] }} ({{ $segment['percent'] }}%)</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-gradient-to-br from-primary-600 to-secondary-600 p-5 text-white shadow-card sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-semibold">Stay Organized</h2>
                        <p class="mt-2 text-sm text-white/80">Break down tasks, set priorities, and track your progress consistently.</p>
                    </div>
                </div>
                <button type="button" class="mt-6 inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-white px-5 text-sm font-semibold text-primary-700 shadow-soft transition hover:bg-white/95 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-white/30">
                    View Tips
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </aside>
    </div>
</div>
