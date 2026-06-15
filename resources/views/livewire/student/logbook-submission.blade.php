<div class="space-y-8 dark:[&_.text-neutral-900]:text-neutral-50 dark:[&_.text-neutral-700]:text-neutral-200 dark:[&_.text-neutral-600]:text-neutral-300 dark:[&_.text-neutral-500]:text-neutral-400 dark:[&_.text-neutral-400]:text-neutral-500">
    <x-dashboard.page-header
        badge="Internship logbook"
        title="Logbook"
        description="Capture daily activity, maintain a clean submission history, and make it easier for supervisors to review progress."
    >
        <x-slot:actions>
            <button type="button" wire:click="openNewEntryModal" class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New log entry
            </button>
        </x-slot:actions>
    </x-dashboard.page-header>

    <x-dashboard.two-column>
        <x-slot:main>
            <div class="space-y-6">
            @if($internshipCard)
                <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6 dark:border-neutral-800 dark:bg-neutral-950">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex min-w-0 items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-50 text-primary-700">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 6H7a2 2 0 01-2-2V4a2 2 0 012-2h7l5 5v13a2 2 0 01-2 2z" />
                                </svg>
                            </div>

                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-neutral-900">{{ $internshipCard['title'] }}</div>
                                @if($internshipCard['company'])
                                    <div class="mt-1 text-sm text-neutral-600">{{ $internshipCard['company'] }}</div>
                                @endif
                                <div class="mt-2 flex flex-wrap items-center gap-2 text-xs font-semibold text-neutral-500">
                                    @if($internshipCard['date_range'])
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $internshipCard['date_range'] }}
                                        </span>
                                    @endif
                                    <span class="inline-flex items-center rounded-full bg-success-50 px-3 py-1 text-xs font-semibold text-success-700 ring-1 ring-inset ring-success-100">
                                        {{ $internshipCard['status'] }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 sm:min-w-[260px]">
                            <div class="flex items-center justify-between text-xs font-semibold text-neutral-500">
                                <span>Overall Progress</span>
                                <span class="text-neutral-900">{{ $internshipCard['progress'] }}%</span>
                            </div>
                            <div class="h-2 w-full overflow-hidden rounded-full bg-neutral-100">
                                <div class="h-2 rounded-full bg-primary-600 transition-all" style="width: {{ $internshipCard['progress'] }}%"></div>
                            </div>
                            <a href="{{ route('student.internships.show', $internshipCard['id']) }}" class="inline-flex h-10 items-center justify-center rounded-xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                                View Internship Details
                            </a>
                        </div>
                    </div>
                </div>
            @endif

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

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="relative w-full sm:max-w-md">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-neutral-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        wire:model.live="q"
                        placeholder="Search log entries..."
                        class="h-11 w-full rounded-xl border border-neutral-200 bg-white pl-10 pr-3 text-sm font-semibold text-neutral-900 shadow-soft placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                    />
                </div>

                <div class="flex flex-wrap items-center gap-3 justify-between sm:justify-end">
                    <button type="button" class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                        <svg class="h-4 w-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 12.414V19a1 1 0 01-.553.894l-4 2A1 1 0 019 21v-8.586L3.293 6.707A1 1 0 013 6V4z" />
                        </svg>
                        Filter
                    </button>

                    <div class="flex items-center gap-2">
                        <label for="logbook-sort" class="text-sm font-semibold text-neutral-700">Sort by:</label>
                        <select
                            id="logbook-sort"
                            wire:model.live="sort"
                            class="h-11 rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                        >
                            <option value="newest">Newest First</option>
                            <option value="oldest">Oldest First</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white shadow-card overflow-hidden dark:border-neutral-800 dark:bg-neutral-950">
                <div class="divide-y divide-neutral-100">
                    @forelse($entries as $entry)
                        <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:gap-6">
                            <div class="flex min-w-0 items-start gap-4">
                                <div class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary-50 text-primary-700">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 6H7a2 2 0 01-2-2V4a2 2 0 012-2h7l5 5v13a2 2 0 01-2 2z" />
                                    </svg>
                                </div>

                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-neutral-900">{{ $entry['title'] }}</div>
                                    <div class="mt-1 text-sm text-neutral-600 line-clamp-2">{{ $entry['excerpt'] }}</div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-6">
                                <div class="text-sm font-semibold text-neutral-900">
                                    <div class="flex items-center gap-2">
                                        <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $entry['entry_date_label'] }}</span>
                                    </div>
                                    @if($entry['entry_day_label'])
                                        <div class="mt-1 text-xs font-semibold text-neutral-500">({{ $entry['entry_day_label'] }})</div>
                                    @endif
                                </div>

                                <div class="min-w-[150px]">
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $entry['status_class'] }}">
                                        {{ $entry['status_label'] }}
                                    </span>
                                    @if($entry['status_meta'])
                                        <div class="mt-1 text-xs font-semibold text-neutral-500">{{ $entry['status_meta'] }}</div>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2">
                                    <button
                                        type="button"
                                        wire:click="{{ $entry['is_draft'] ? 'openEditEntryModal' : 'openDetailsModal' }}({{ $entry['id'] }})"
                                        class="inline-flex h-9 items-center justify-center rounded-xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25"
                                    >
                                        {{ $entry['action_label'] }}
                                    </button>

                                    <x-dropdown align="right" width="48" contentClasses="py-1 bg-white dark:bg-neutral-950">
                                        <x-slot name="trigger">
                                            <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6h.01M12 12h.01M12 18h.01" />
                                                </svg>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                            <button type="button" wire:click="openDetailsModal({{ $entry['id'] }})" class="block w-full px-4 py-2 text-left text-sm font-semibold text-neutral-700 hover:bg-neutral-50">
                                                View Details
                                            </button>
                                            @if($entry['is_draft'])
                                                <button type="button" wire:click="openEditEntryModal({{ $entry['id'] }})" class="block w-full px-4 py-2 text-left text-sm font-semibold text-neutral-700 hover:bg-neutral-50">
                                                    Continue Editing
                                                </button>
                                                <button type="button" wire:click="submitEntry({{ $entry['id'] }})" class="block w-full px-4 py-2 text-left text-sm font-semibold text-primary-700 hover:bg-neutral-50">
                                                    Submit for Review
                                                </button>
                                            @endif
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-neutral-100 text-neutral-500">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 6H7a2 2 0 01-2-2V4a2 2 0 012-2h7l5 5v13a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-base font-semibold text-neutral-900">No entries found</h3>
                            <p class="mt-2 text-sm text-neutral-600">Create a new log entry or adjust your filters.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:items-center sm:justify-between">
                <div class="text-sm font-semibold text-neutral-600">
                    Showing {{ $entries->firstItem() ?? 0 }} to {{ $entries->lastItem() ?? 0 }} of {{ $entries->total() }} entries
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" wire:click="previousPage" @disabled($entries->onFirstPage()) class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900 disabled:cursor-not-allowed disabled:opacity-50">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    @php
                        $current = $entries->currentPage();
                        $last = $entries->lastPage();
                        $start = max(1, $current - 1);
                        $end = min($last, $current + 1);
                    @endphp

                    @for($page = $start; $page <= $end; $page++)
                        <button type="button" wire:click="gotoPage({{ $page }})" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border text-sm font-semibold shadow-soft transition focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 {{ $page === $current ? 'border-primary-600 bg-primary-600 text-white' : 'border-neutral-200 bg-white text-neutral-700 hover:bg-neutral-50' }}">
                            {{ $page }}
                        </button>
                    @endfor

                    <button type="button" wire:click="nextPage" @disabled(! $entries->hasMorePages()) class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900 disabled:cursor-not-allowed disabled:opacity-50">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
            </div>
        </x-slot:main>

        <x-slot:aside>
            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6 dark:border-neutral-800 dark:bg-neutral-950">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-900">Weekly Progress</h2>
                        <p class="mt-1 text-xs font-semibold text-neutral-500">{{ $weeklyProgress['range_label'] }}</p>
                    </div>
                    <a href="{{ route('student.logbook.index') }}" class="text-sm font-semibold text-primary-700 hover:text-primary-800">View Calendar</a>
                </div>

                <div class="mt-6 flex items-center gap-6">
                    <div class="relative h-28 w-28 shrink-0 rounded-full" style="background: {{ $weeklyProgress['style'] }};">
                        <div class="absolute inset-3 rounded-full bg-white"></div>
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                            <div class="text-2xl font-semibold text-neutral-900">{{ $weeklyProgress['days_logged'] }}/7</div>
                            <div class="text-xs font-semibold text-neutral-500">Days Logged</div>
                        </div>
                    </div>

                    <div class="min-w-0 space-y-3 text-sm font-semibold text-neutral-700">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-primary-600"></span>
                                Logged
                            </div>
                            <span class="text-neutral-900">{{ $weeklyProgress['days_logged'] }} (days)</span>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-neutral-200"></span>
                                Remaining
                            </div>
                            <span class="text-neutral-900">{{ $weeklyProgress['remaining'] }} (days)</span>
                        </div>
                        <p class="pt-2 text-xs font-semibold text-neutral-500">Great job! Keep your logbook updated regularly.</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6 dark:border-neutral-800 dark:bg-neutral-950">
                <h2 class="text-sm font-semibold text-neutral-900">Logbook Tips</h2>

                <div class="mt-4 space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-secondary-50 text-secondary-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-neutral-900">Be Specific</div>
                            <div class="mt-1 text-sm text-neutral-600">Provide detailed information about your daily activities.</div>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-info-50 text-info-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4-4 4 4 8-8" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-neutral-900">Use Evidence</div>
                            <div class="mt-1 text-sm text-neutral-600">Attach screenshots, files, or links to support your work.</div>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-success-50 text-success-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-neutral-900">Regular Updates</div>
                            <div class="mt-1 text-sm text-neutral-600">Update your logbook daily for better tracking.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6 dark:border-neutral-800 dark:bg-neutral-950">
                <div class="flex items-start justify-between gap-3">
                    <h2 class="text-sm font-semibold text-neutral-900">Logbook Stats</h2>
                    <a href="{{ route('student.reports.ai') }}" class="text-sm font-semibold text-primary-700 hover:text-primary-800">View Report</a>
                </div>

                <div class="mt-5 space-y-3 text-sm font-semibold text-neutral-900">
                    <div class="flex items-center justify-between rounded-xl border border-neutral-200 bg-white px-4 py-3">
                        <span class="flex items-center gap-2 text-neutral-700">
                            <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-secondary-50 text-secondary-700">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 6H7a2 2 0 01-2-2V4a2 2 0 012-2h7l5 5v13a2 2 0 01-2 2z" />
                                </svg>
                            </span>
                            Total Entries
                        </span>
                        <span>{{ $stats['total'] }}</span>
                    </div>

                    <div class="flex items-center justify-between rounded-xl border border-neutral-200 bg-white px-4 py-3">
                        <span class="flex items-center gap-2 text-neutral-700">
                            <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-success-50 text-success-700">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            Approved
                        </span>
                        <span>{{ $stats['approved'] }}</span>
                    </div>

                    <div class="flex items-center justify-between rounded-xl border border-neutral-200 bg-white px-4 py-3">
                        <span class="flex items-center gap-2 text-neutral-700">
                            <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-warning-50 text-warning-700">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01" />
                                </svg>
                            </span>
                            Pending Review
                        </span>
                        <span>{{ $stats['pending'] }}</span>
                    </div>
                </div>
            </div>
        </x-slot:aside>
    </x-dashboard.two-column>

    <x-modal name="logbook-entry" focusable>
        <div class="p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-neutral-900">{{ $editingLogbookId ? 'Edit log entry' : 'New log entry' }}</h2>
                    <p class="mt-2 text-sm text-neutral-600">Save a draft or submit it for review when ready.</p>
                </div>
                <button type="button" x-on:click="$dispatch('close-modal', 'logbook-entry')" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mt-5 space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-semibold text-neutral-900" for="logbook-entry-date">Entry date</label>
                        <div class="mt-2">
                            <input id="logbook-entry-date" type="date" wire:model.defer="entryDate" class="h-11 w-full rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                            <x-input-error :messages="$errors->get('entryDate')" class="mt-2" />
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-neutral-900" for="logbook-entry-title">Title</label>
                        <div class="mt-2">
                            <input id="logbook-entry-title" type="text" wire:model.defer="entryTitle" placeholder="e.g. Implemented dashboard authentication system" class="h-11 w-full rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                            <x-input-error :messages="$errors->get('entryTitle')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-neutral-900" for="logbook-entry-body">Details</label>
                    <div class="mt-2">
                        <textarea id="logbook-entry-body" rows="6" wire:model.defer="entryBody" placeholder="What did you work on today? Include tools used, outcomes, and links if available." class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-3 text-sm font-semibold text-neutral-900 shadow-soft placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"></textarea>
                        <x-input-error :messages="$errors->get('entryBody')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-end">
                <button type="button" x-on:click="$dispatch('close-modal', 'logbook-entry')" class="inline-flex h-11 items-center justify-center rounded-xl border border-neutral-200 bg-white px-5 text-sm font-semibold text-neutral-900 shadow-soft transition hover:bg-neutral-50">
                    Cancel
                </button>
                <button type="button" wire:click="saveEntry" class="inline-flex h-11 items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                    Save Draft
                </button>
            </div>
        </div>
    </x-modal>

    <x-modal name="logbook-details" focusable maxWidth="2xl">
        <div class="p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-neutral-900">{{ $details['title'] ?? 'Log entry' }}</h2>
                    <div class="mt-2 flex flex-wrap items-center gap-2 text-xs font-semibold text-neutral-500">
                        @if(isset($details['date_label']) && $details['date_label'])
                            <span class="inline-flex items-center gap-1">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $details['date_label'] }}
                            </span>
                        @endif
                        @if(isset($details['internship_title']) && $details['internship_title'])
                            <span>{{ $details['internship_title'] }}@if($details['company_name']) • {{ $details['company_name'] }}@endif</span>
                        @endif
                        @if(isset($details['status_label']) && $details['status_label'])
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $details['status_class'] }}">
                                {{ $details['status_label'] }}
                            </span>
                            @if($details['status_meta'])
                                <span>{{ $details['status_meta'] }}</span>
                            @endif
                        @endif
                    </div>
                </div>
                <button type="button" wire:click="closeDetailsModal" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mt-5 rounded-2xl border border-neutral-200 bg-white p-5 text-sm font-semibold text-neutral-700 whitespace-pre-line dark:border-neutral-800 dark:bg-neutral-950">
                {{ $details['body'] ?? '' }}
            </div>

            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-end">
                <button type="button" wire:click="closeDetailsModal" class="inline-flex h-11 items-center justify-center rounded-xl border border-neutral-200 bg-white px-5 text-sm font-semibold text-neutral-900 shadow-soft transition hover:bg-neutral-50">
                    Close
                </button>
                @if(($details['can_submit'] ?? false) && isset($details['id']))
                    <button type="button" wire:click="submitEntry({{ $details['id'] }})" class="inline-flex h-11 items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                        Submit for Review
                    </button>
                @endif
            </div>
        </div>
    </x-modal>
</div>
