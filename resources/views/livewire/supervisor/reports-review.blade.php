<div class="space-y-5">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div class="min-w-0">
            <h1 class="text-2xl font-semibold text-neutral-900 sm:text-3xl">Reports</h1>
            <p class="mt-2 text-sm text-neutral-600">Review generated reports and export custom datasets for your supervised interns.</p>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
            <button
                type="button"
                wire:click="exportCustomReport"
                class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-primary-600 px-4 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m0 0l3-3m-3 3l-3-3m9 9H6a2 2 0 01-2-2v-3m16 3v-3a2 2 0 00-2-2" />
                </svg>
                Export Custom Report
            </button>
        </div>
    </div>

    @if(session('message'))
        <div class="rounded-2xl border border-primary-100 bg-primary-50 px-5 py-4 text-sm font-semibold text-primary-800">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-5">
        <div class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-card sm:p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-neutral-600">Total Interns</p>
                    <p class="mt-2 text-3xl font-semibold text-neutral-900">{{ $metrics['total_interns'] ?? 0 }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-primary-50 text-primary-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m8-5a4 4 0 10-8 0 4 4 0 008 0z" />
                    </svg>
                </div>
            </div>
            <p class="mt-2 text-[13px] leading-5 text-neutral-600">Accepted students under your supervision</p>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-card sm:p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-neutral-600">Active</p>
                    <p class="mt-2 text-3xl font-semibold text-neutral-900">{{ $metrics['active'] ?? 0 }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-success-50 text-success-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 .667 1.333 2 2 2m8-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                    </svg>
                </div>
            </div>
            <p class="mt-2 text-[13px] leading-5 text-neutral-600">Activity in the last 7 days</p>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-card sm:p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-neutral-600">Inactive</p>
                    <p class="mt-2 text-3xl font-semibold text-neutral-900">{{ $metrics['inactive'] ?? 0 }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-warning-50 text-warning-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="mt-2 text-[13px] leading-5 text-neutral-600">No updates for 7+ days</p>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-card sm:p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-neutral-600">Tasks Completed</p>
                    <p class="mt-2 text-3xl font-semibold text-neutral-900">{{ $metrics['tasks_completed'] ?? 0 }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-secondary-50 text-secondary-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <p class="mt-2 text-[13px] leading-5 text-neutral-600">{{ ($metrics['range_label'] ?? null) ? 'In ' . $metrics['range_label'] : 'Across all time' }}</p>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-card sm:p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-neutral-600">Avg Evaluation</p>
                    <p class="mt-2 text-3xl font-semibold text-neutral-900">{{ $metrics['avg_evaluation_score'] ?? 0 }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-info-50 text-info-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5h6m-7 4h8m-9 4h10m-11 4h12" />
                    </svg>
                </div>
            </div>
            <p class="mt-2 text-[13px] leading-5 text-neutral-600">Average score from submitted evaluations</p>
        </div>
    </div>

    <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
        <div class="space-y-3 rounded-2xl border border-neutral-200 bg-neutral-50/70 p-4">
            <div class="flex w-full flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center">
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

                <select
                    wire:model.live="internship"
                    class="h-11 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 sm:w-56"
                >
                    <option value="">All Internships</option>
                    @foreach($internships as $item)
                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                    @endforeach
                </select>

                <select
                    wire:model.live="company"
                    class="h-11 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 sm:w-56"
                >
                    <option value="">All Companies</option>
                    @foreach($companies as $item)
                        <option value="{{ $item->id }}">{{ $item->company_name }}</option>
                    @endforeach
                </select>

                <select
                    wire:model.live="supervisor"
                    class="h-11 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 sm:w-56"
                >
                    @foreach($supervisors as $item)
                        <option value="{{ $item->id }}">{{ $item->user?->name ?? 'Supervisor' }}</option>
                    @endforeach
                </select>

                <select
                    wire:model.live="customReportType"
                    class="h-11 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 sm:w-56"
                >
                    <option value="">All Report Types</option>
                    @foreach($reportDefinitions as $definition)
                        <option value="{{ $definition['type'] }}">{{ $definition['name'] }}</option>
                    @endforeach
                </select>
            </div>

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

                <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-center sm:justify-end">
                    <p class="text-[13px] leading-5 text-neutral-500 sm:max-w-sm sm:text-right">
                        Use the filters to narrow report sets first, then switch between standard, saved, and custom views.
                    </p>
                    <select
                        wire:model.live="perPage"
                        class="h-11 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 sm:w-40"
                    >
                        <option value="10">10 / page</option>
                        <option value="25">25 / page</option>
                        <option value="50">50 / page</option>
                    </select>
                </div>
            </div>
        </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <div class="rounded-2xl border border-neutral-200 bg-white shadow-card lg:col-span-8">
            <div class="flex items-start justify-between gap-3 px-5 py-4 sm:px-6">
                <div class="min-w-0">
                    <h2 class="text-sm font-semibold text-neutral-900">
                        @if($tab === 'standard')
                            Standard Reports
                        @elseif($tab === 'saved')
                            Saved Reports
                        @else
                            Custom Reports
                        @endif
                    </h2>
                    <p class="mt-1 text-[13px] leading-5 text-neutral-600">
                        @if($tab === 'standard')
                            {{ count($reportDefinitions) }} templates available for reporting exports and reviews.
                        @elseif($tab === 'saved')
                            {{ $savedReports->total() }} saved reports ready to reference again.
                        @else
                            {{ $customReports->total() }} generated reports matching the selected filters.
                        @endif
                    </p>
                </div>
            </div>

            <div class="overflow-hidden border-t border-neutral-200">
                @if($tab === 'standard')
                    <div class="divide-y divide-neutral-200">
                        @forelse($reportDefinitions as $definition)
                            <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-start sm:justify-between sm:px-6">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-neutral-900">{{ $definition['name'] }}</p>
                                    <p class="mt-2 text-sm text-neutral-600">{{ $definition['description'] }}</p>
                                    <div class="mt-3 inline-flex items-center rounded-full bg-neutral-100 px-2 py-1 text-xs font-semibold text-neutral-700 ring-1 ring-inset ring-neutral-200">
                                        Type: {{ $definition['type'] }}
                                    </div>
                                </div>
                                <button
                                    type="button"
                                    wire:click="selectDefinition('{{ $definition['type'] }}')"
                                    class="inline-flex h-10 shrink-0 items-center justify-center rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25"
                                >
                                    Use in Custom Export
                                </button>
                            </div>
                        @empty
                            <div class="p-10 text-center text-sm font-semibold text-neutral-600">No report definitions available.</div>
                        @endforelse
                    </div>
                @else
                    <div class="grid grid-cols-12 gap-3 bg-neutral-50 px-5 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-neutral-500 sm:px-6">
                        <div class="col-span-4">Student</div>
                        <div class="col-span-4">Report</div>
                        <div class="col-span-2">Generated</div>
                        <div class="col-span-2">Status</div>
                    </div>

                    <div class="divide-y divide-neutral-200">
                        @php($rows = $tab === 'saved' ? $savedReports : $customReports)
                        @forelse($rows as $row)
                            <div class="grid grid-cols-12 items-start gap-3 px-5 py-4 sm:px-6">
                                <div class="col-span-4 flex items-start gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-neutral-900 text-sm font-semibold text-white">
                                        {{ $row['student_initial'] }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-neutral-900">{{ $row['student_name'] }}</p>
                                        <p class="mt-1 truncate text-xs font-semibold text-neutral-500">{{ $row['student_email'] }}</p>
                                        <p class="mt-2 truncate text-xs font-semibold text-neutral-600">{{ $row['internship_title'] }} • {{ $row['company_name'] }}</p>
                                    </div>
                                </div>

                                <div class="col-span-4 min-w-0">
                                    <p class="truncate text-sm font-semibold text-neutral-900">{{ $row['name'] }}</p>
                                    <p class="mt-1 text-xs font-semibold text-neutral-500">Type: {{ $row['type'] }}</p>
                                </div>

                                <div class="col-span-2">
                                    <p class="text-sm font-semibold text-neutral-900">{{ $row['generated_label'] }}</p>
                                </div>

                                <div class="col-span-2">
                                    <span class="inline-flex items-center rounded-full bg-neutral-100 px-2 py-1 text-xs font-semibold text-neutral-700 ring-1 ring-inset ring-neutral-200">
                                        {{ ucfirst($row['status']) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="p-10 text-center text-sm font-semibold text-neutral-600">No reports found.</div>
                        @endforelse
                    </div>
                @endif
            </div>

            @if($tab !== 'standard')
                <div class="border-t border-neutral-200 px-5 py-4 sm:px-6">
                    {{ ($tab === 'saved' ? $savedReports : $customReports)?->links() }}
                </div>
            @endif
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-5 lg:col-span-4">
            <div>
                <h2 class="text-sm font-semibold text-neutral-900">Report Summary</h2>
                <p class="mt-1 text-[13px] leading-5 text-neutral-600">{{ ($metrics['range_label'] ?? null) ? 'Filtered by ' . $metrics['range_label'] : 'All time reports' }}</p>
            </div>

            <div class="mt-4 grid grid-cols-2 gap-3">
                <div class="rounded-2xl border border-neutral-200 bg-neutral-50/60 px-4 py-4">
                    <div class="text-2xl font-semibold text-neutral-900">{{ $panel['total_reports'] ?? 0 }}</div>
                    <div class="mt-1 text-[11px] font-semibold uppercase tracking-[0.08em] text-neutral-500">Total Reports</div>
                </div>
                <div class="rounded-2xl border border-neutral-200 bg-neutral-50/60 px-4 py-4">
                    <div class="text-2xl font-semibold text-neutral-900">{{ $tabs[1]['count'] ?? 0 }}</div>
                    <div class="mt-1 text-[11px] font-semibold uppercase tracking-[0.08em] text-neutral-500">Generated</div>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-sm font-semibold text-neutral-900">Report Types</h3>

                <div class="mt-4 flex items-center gap-5">
                    <div class="relative h-24 w-24 shrink-0 rounded-full" style="background: {{ $panel['donut']['style'] ?? 'conic-gradient(#E2E8F0 0% 100%)' }};">
                        <div class="absolute inset-3 rounded-full bg-white"></div>
                    </div>

                    <div class="min-w-0 flex-1 space-y-2">
                        @foreach(($panel['donut']['segments'] ?? []) as $segment)
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
                <h3 class="text-sm font-semibold text-neutral-900">Popular Reports</h3>

                <div class="mt-4 space-y-3">
                    @forelse(($panel['popular'] ?? []) as $item)
                        <div class="flex items-center justify-between gap-3 rounded-2xl border border-neutral-200 bg-neutral-50/60 px-4 py-3">
                            <p class="min-w-0 truncate text-sm font-semibold text-neutral-900">{{ $item['name'] }}</p>
                            <span class="shrink-0 rounded-full bg-neutral-100 px-2 py-1 text-xs font-semibold text-neutral-700 ring-1 ring-inset ring-neutral-200">{{ $item['count'] }}</span>
                        </div>
                    @empty
                        <p class="text-sm font-semibold text-neutral-600">No popular reports yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-sm font-semibold text-neutral-900">Recent Reports</h3>

                <div class="mt-4 space-y-3">
                    @forelse(($panel['recent'] ?? []) as $item)
                        <div class="rounded-2xl border border-neutral-200 bg-neutral-50/60 px-4 py-3">
                            <p class="truncate text-sm font-semibold text-neutral-900">{{ $item['name'] }}</p>
                            <p class="mt-1 truncate text-xs font-semibold text-neutral-500">{{ $item['student_name'] }} • {{ $item['internship_title'] }}</p>
                            <p class="mt-2 text-xs font-semibold text-neutral-600">{{ $item['time_label'] }}</p>
                        </div>
                    @empty
                        <p class="text-sm font-semibold text-neutral-600">No recent reports found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
