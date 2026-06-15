<div class="space-y-5">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div class="min-w-0">
            <h1 class="text-2xl font-semibold text-neutral-900 sm:text-3xl">Logbooks</h1>
            <p class="mt-2 text-sm text-neutral-600">Review submitted logbook entries from your supervised interns.</p>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
            <button
                type="button"
                wire:click="export"
                class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25"
            >
                <svg class="h-4 w-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m0 0l3-3m-3 3l-3-3m9 9H6a2 2 0 01-2-2v-3m16 3v-3a2 2 0 00-2-2" />
                </svg>
                Export
            </button>
        </div>
    </div>

    @if(session('message'))
        <div class="rounded-2xl border border-primary-100 bg-primary-50 px-5 py-4 text-sm font-semibold text-primary-800">
            {{ session('message') }}
        </div>
    @endif

    <div class="space-y-3 rounded-2xl border border-neutral-200 bg-neutral-50/70 p-4">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-wrap items-center gap-2">
                @foreach($tabs as $item)
                    <button
                        type="button"
                        wire:click="$set('tab', '{{ $item['key'] }}')"
                        class="inline-flex h-10 items-center gap-2 rounded-2xl border px-4 text-sm font-semibold transition focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 {{ $tab === $item['key'] ? 'border-primary-200 bg-primary-50 text-primary-800' : 'border-neutral-200 bg-white text-neutral-700 hover:bg-neutral-50' }}"
                    >
                        {{ $item['label'] }}
                        <span class="rounded-full bg-white/80 px-2 py-1 text-xs font-semibold text-neutral-600">{{ $item['count'] }}</span>
                    </button>
                @endforeach
            </div>

            <p class="text-[13px] leading-5 text-neutral-500 lg:text-right">
                Filter by internship, status, and date range to focus your current review queue.
            </p>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center sm:justify-end">
            <div class="relative w-full sm:w-80">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-neutral-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search interns, internships, keywords..."
                    class="h-11 w-full rounded-2xl border border-neutral-200 bg-white pl-10 pr-4 text-sm font-semibold text-neutral-900 shadow-soft placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                />
            </div>

            <select
                wire:model.live="internship"
                class="h-11 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 sm:w-52"
            >
                <option value="">All Internships</option>
                @foreach($internships as $internship)
                    <option value="{{ $internship->id }}">{{ $internship->title }}</option>
                @endforeach
            </select>

            <select
                wire:model.live="status"
                class="h-11 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 sm:w-44"
            >
                <option value="">Status: Any</option>
                <option value="submitted">Submitted</option>
                <option value="approved">Approved</option>
                <option value="returned">Returned</option>
                <option value="draft">Draft</option>
            </select>

            <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row">
                <input
                    type="date"
                    wire:model.live="from"
                    class="h-11 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 sm:w-44"
                />

                <input
                    type="date"
                    wire:model.live="to"
                    class="h-11 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 sm:w-44"
                />
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <div class="rounded-2xl border border-neutral-200 bg-white shadow-card lg:col-span-8">
            <div class="flex items-start justify-between gap-3 px-5 py-4 sm:px-6">
                <div class="min-w-0">
                    <h2 class="text-sm font-semibold text-neutral-900">Logbook Entries</h2>
                    <p class="mt-1 text-[13px] leading-5 text-neutral-600">{{ $logbooks->total() }} entries in the current view. Approve or return submitted entries.</p>
                </div>

                <select
                    wire:model.live="perPage"
                    class="h-10 rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-700 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                >
                    <option value="10">10 / page</option>
                    <option value="25">25 / page</option>
                    <option value="50">50 / page</option>
                </select>
            </div>

            <div class="overflow-hidden border-t border-neutral-200">
                <div class="grid grid-cols-12 bg-neutral-50 px-5 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-neutral-500 sm:px-6">
                    <div class="col-span-4">Student</div>
                    <div class="col-span-2">Entry</div>
                    <div class="col-span-3">Internship</div>
                    <div class="col-span-2">Status</div>
                    <div class="col-span-1 text-right">Action</div>
                </div>

                <div class="divide-y divide-neutral-200">
                    @forelse($logbooks as $row)
                        <div class="grid grid-cols-12 items-start gap-3 px-5 py-4 sm:px-6">
                            <div class="col-span-4 flex items-start gap-3">
                                <div class="h-10 w-10 shrink-0 rounded-full bg-neutral-900 text-white flex items-center justify-center text-sm font-semibold">
                                    {{ $row['student_initial'] }}
                                </div>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-neutral-900">{{ $row['student_name'] }}</p>
                                    <p class="mt-1 truncate text-xs font-semibold text-neutral-500">{{ $row['student_email'] }}</p>
                                    <p class="mt-2 text-xs font-semibold text-neutral-600 line-clamp-2">{{ $row['excerpt'] }}</p>
                                </div>
                            </div>

                            <div class="col-span-2">
                                <p class="text-sm font-semibold text-neutral-900">{{ $row['entry_date_label'] }}</p>
                                @if($row['week_label'])
                                    <p class="mt-1 text-xs font-semibold text-neutral-500">{{ $row['week_label'] }}</p>
                                @endif
                            </div>

                            <div class="col-span-3 min-w-0">
                                <p class="truncate text-sm font-semibold text-neutral-900">{{ $row['internship_title'] }}</p>
                                <p class="mt-1 truncate text-xs font-semibold text-neutral-500">{{ $row['company_name'] }}</p>
                            </div>

                            <div class="col-span-2">
                                <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold ring-1 ring-inset {{ $row['status_class'] }}">{{ $row['status_label'] }}</span>
                                @if($row['status_meta'])
                                    <p class="mt-1 text-xs font-semibold text-neutral-500">{{ $row['status_meta'] }}</p>
                                @elseif($row['approved_label'])
                                    <p class="mt-1 text-xs font-semibold text-neutral-500">{{ $row['approved_label'] }}</p>
                                @endif
                            </div>

                            <div class="col-span-1 flex justify-end">
                                @if($row['can_review'])
                                    <div class="flex flex-col items-end gap-2">
                                        <button
                                            type="button"
                                            wire:click="approve({{ $row['id'] }})"
                                            wire:loading.attr="disabled"
                                            class="inline-flex h-9 items-center justify-center rounded-xl bg-success-600 px-3 text-xs font-semibold text-white shadow-soft transition hover:bg-success-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-success-500/25 disabled:opacity-60"
                                        >
                                            Approve
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="returnEntry({{ $row['id'] }})"
                                            wire:loading.attr="disabled"
                                            class="inline-flex h-9 items-center justify-center rounded-xl border border-neutral-200 bg-white px-3 text-xs font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 disabled:opacity-60"
                                        >
                                            Return
                                        </button>
                                    </div>
                                @else
                                    <span class="text-xs font-semibold text-neutral-400">—</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-sm font-semibold text-neutral-600">No logbooks found.</div>
                    @endforelse
                </div>
            </div>

            <div class="border-t border-neutral-200 px-5 py-4 sm:px-6">
                {{ $logbooks->links() }}
            </div>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-5 lg:col-span-4">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h2 class="text-sm font-semibold text-neutral-900">Logbook Summary</h2>
                    <p class="mt-1 text-[13px] leading-5 text-neutral-600">{{ $summary['range_label'] }}</p>
                </div>
                <select
                    wire:model.live="summaryRange"
                    class="h-10 rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-700 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                >
                    <option value="this_week">This Week</option>
                    <option value="this_month">This Month</option>
                    <option value="last_30_days">Last 30 Days</option>
                    <option value="all_time">All Time</option>
                </select>
            </div>

            <div class="mt-4 grid grid-cols-2 gap-3">
                <div class="rounded-2xl border border-neutral-200 bg-neutral-50/60 px-4 py-4">
                    <div class="text-2xl font-semibold text-neutral-900">{{ $summary['totals']['total'] ?? 0 }}</div>
                    <div class="mt-1 text-[11px] font-semibold uppercase tracking-[0.08em] text-neutral-500">Total Entries</div>
                </div>
                <div class="rounded-2xl border border-neutral-200 bg-neutral-50/60 px-4 py-4">
                    <div class="text-2xl font-semibold text-neutral-900">{{ $summary['totals']['pending'] ?? 0 }}</div>
                    <div class="mt-1 text-[11px] font-semibold uppercase tracking-[0.08em] text-neutral-500">Pending Review</div>
                </div>
                <div class="rounded-2xl border border-neutral-200 bg-neutral-50/60 px-4 py-4">
                    <div class="text-2xl font-semibold text-neutral-900">{{ $summary['totals']['reviewed'] ?? 0 }}</div>
                    <div class="mt-1 text-[11px] font-semibold uppercase tracking-[0.08em] text-neutral-500">Reviewed</div>
                </div>
                <div class="rounded-2xl border border-neutral-200 bg-neutral-50/60 px-4 py-4">
                    <div class="text-2xl font-semibold text-neutral-900">{{ $summary['totals']['returned'] ?? 0 }}</div>
                    <div class="mt-1 text-[11px] font-semibold uppercase tracking-[0.08em] text-neutral-500">Returned</div>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-sm font-semibold text-neutral-900">Review Statistics</h3>

                <div class="mt-4 flex items-center gap-5">
                    <div class="relative h-24 w-24 shrink-0 rounded-full" style="background: {{ $summary['donut']['style'] ?? 'conic-gradient(#E2E8F0 0% 100%)' }};">
                        <div class="absolute inset-3 rounded-full bg-white"></div>
                    </div>

                    <div class="min-w-0 flex-1 space-y-2">
                        @foreach(($summary['donut']['segments'] ?? []) as $segment)
                            <div class="flex items-center justify-between gap-3 text-sm font-semibold text-neutral-700">
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

            <div class="mt-6">
                <h3 class="text-sm font-semibold text-neutral-900">Next Actions</h3>

                <div class="mt-4 space-y-3">
                    <button
                        type="button"
                        wire:click="export"
                        class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-primary-600 px-4 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m0 0l3-3m-3 3l-3-3m9 9H6a2 2 0 01-2-2v-3m16 3v-3a2 2 0 00-2-2" />
                        </svg>
                        Export Current View
                    </button>

                    <a
                        href="{{ route('supervisor.students.index') }}"
                        class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25"
                    >
                        View Students
                    </a>

                    <a
                        href="{{ route('supervisor.monitoring.index') }}"
                        class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25"
                    >
                        Monitoring
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
