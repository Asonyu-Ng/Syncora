@php
    $summaryCards = [
        [
            'value' => $stats['students'] ?? 0,
            'label' => 'Students',
            'meta' => 'Active supervisees',
            'icon_bg' => 'bg-primary-50',
            'icon_text' => 'text-primary-700',
            'svg' => 'M17 20h5v-2a4 4 0 00-4-4h-1m-6 6H2v-2a4 4 0 014-4h1m6 6v-2a4 4 0 00-4-4H8m4-6a4 4 0 11-8 0 4 4 0 018 0zm6 4a3 3 0 100-6 3 3 0 000 6z',
        ],
        [
            'value' => $stats['pending_approvals'] ?? 0,
            'label' => 'Pending approvals',
            'meta' => 'Logbooks waiting review',
            'icon_bg' => 'bg-warning-50',
            'icon_text' => 'text-warning-700',
            'svg' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        [
            'value' => $stats['tasks_assigned'] ?? 0,
            'label' => 'Assigned tasks',
            'meta' => 'Current workload in the system',
            'icon_bg' => 'bg-info-50',
            'icon_text' => 'text-info-700',
            'svg' => 'M9 5h6M9 9h6m-7 4h8m-9 8h10a2 2 0 002-2V7a2 2 0 00-2-2h-3l-1-1H9L8 5H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        ],
        [
            'value' => $stats['tasks_completed'] ?? 0,
            'label' => 'Completed tasks',
            'meta' => 'Closed this month',
            'icon_bg' => 'bg-success-50',
            'icon_text' => 'text-success-700',
            'svg' => 'M5 13l4 4L19 7',
        ],
        [
            'value' => ($stats['completion_rate'] ?? 0) . '%',
            'label' => 'Completion rate',
            'meta' => 'Average student progress',
            'icon_bg' => 'bg-danger-50',
            'icon_text' => 'text-danger-600',
            'svg' => 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6',
        ],
    ];
@endphp

<div class="space-y-6">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Supervisor overview
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950 sm:text-[2.1rem]">{{ $summary['greeting'] ?? 'Welcome back' }}</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">
                    Stay on top of approvals, student momentum, and upcoming follow-up from one calmer review surface.
                </p>

                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('supervisor.logbooks.index') }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500">
                        Review logbooks
                    </a>
                    <a href="{{ route('supervisor.reports.index') }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-neutral-200 bg-white px-5 text-sm font-semibold text-neutral-800 shadow-soft transition hover:bg-neutral-50">
                        Open reports
                    </a>
                </div>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Current Window</p>
                        <h2 class="mt-2 text-lg font-semibold tracking-tight text-neutral-950">{{ $summary['date_range_label'] ?? '' }}</h2>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-success-50 px-3 py-1 text-xs font-semibold text-success-700 ring-1 ring-inset ring-success-100">
                        Monitoring live
                    </span>
                </div>

                <div class="mt-5 grid gap-3">
                    <a href="{{ route('supervisor.monitoring.index') }}" class="rounded-2xl border border-neutral-200 bg-white px-4 py-3 shadow-soft transition hover:bg-neutral-50">
                        <div class="text-sm font-semibold text-neutral-900">Internship monitoring</div>
                        <p class="mt-1 text-sm leading-6 text-neutral-600">Spot inactive placements, follow up on engagement, and watch risk signals.</p>
                    </a>
                    <a href="{{ route('supervisor.tasks.index') }}" class="rounded-2xl border border-neutral-200 bg-white px-4 py-3 shadow-soft transition hover:bg-neutral-50">
                        <div class="text-sm font-semibold text-neutral-900">Task management</div>
                        <p class="mt-1 text-sm leading-6 text-neutral-600">Check task volume, progress, and items that may require closer intervention.</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
        @foreach ($summaryCards as $card)
            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card">
                <div class="inline-flex h-11 w-11 items-center justify-center rounded-2xl {{ $card['icon_bg'] }} {{ $card['icon_text'] }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['svg'] }}" />
                    </svg>
                </div>
                <div class="mt-5 text-2xl font-semibold tracking-tight text-neutral-950">{{ $card['value'] }}</div>
                <div class="mt-1 text-sm font-semibold text-neutral-800">{{ $card['label'] }}</div>
                <div class="mt-2 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">{{ $card['meta'] }}</div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6 lg:col-span-4">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h2 class="text-sm font-semibold text-neutral-900">Students Progress Overview</h2>
                    <p class="mt-1 text-sm text-neutral-600">Average completion across supervised students.</p>
                </div>
                <a href="{{ route('supervisor.students.index') }}" class="text-sm font-semibold text-primary-700 hover:text-primary-800">View all</a>
            </div>

            <div class="mt-6 flex items-center gap-6">
                <div class="relative h-28 w-28 shrink-0 rounded-full" style="background: {{ $progress['style'] ?? 'conic-gradient(#E2E8F0 0% 100%)' }};">
                    <div class="absolute inset-3 rounded-full bg-white"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                        <div class="text-2xl font-semibold text-neutral-900">{{ $progress['average'] ?? 0 }}%</div>
                        <div class="text-xs font-semibold text-neutral-500">Average</div>
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

        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6 lg:col-span-4">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h2 class="text-sm font-semibold text-neutral-900">Pending Logbook Approvals</h2>
                    <p class="mt-1 text-sm text-neutral-600">Logbooks awaiting your review.</p>
                </div>
                <a href="{{ route('supervisor.logbooks.index') }}" class="text-sm font-semibold text-primary-700 hover:text-primary-800">View all</a>
            </div>

            <div class="mt-5 space-y-3">
                @forelse($pending_logbooks as $item)
                    <div class="flex items-center gap-3 rounded-2xl border border-neutral-200 bg-white px-4 py-3 shadow-soft">
                        <div class="h-10 w-10 shrink-0 rounded-full bg-neutral-900 text-white flex items-center justify-center text-sm font-semibold">
                            {{ strtoupper(substr($item['student_name'], 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between gap-3">
                                <p class="truncate text-sm font-semibold text-neutral-900">{{ $item['student_name'] }}</p>
                                <span class="shrink-0 rounded-full px-2 py-1 text-xs font-semibold {{ $item['status_class'] }}">{{ $item['status_label'] }}</span>
                            </div>
                            <p class="mt-1 text-xs font-semibold text-neutral-500">{{ $item['label'] }} • {{ $item['internship_title'] }}</p>
                        </div>
                        <div class="shrink-0 text-xs font-semibold text-neutral-500">{{ $item['submitted_label'] }}</div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-neutral-200 bg-white p-8 text-center text-sm text-neutral-600">
                        No approvals pending.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6 lg:col-span-4">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h2 class="text-sm font-semibold text-neutral-900">Upcoming Deadlines</h2>
                    <p class="mt-1 text-sm text-neutral-600">Tasks due soon for your students.</p>
                </div>
                <a href="{{ route('supervisor.tasks.index') }}" class="text-sm font-semibold text-primary-700 hover:text-primary-800">View all</a>
            </div>

            <div class="mt-5 space-y-3">
                @forelse($upcoming_deadlines as $deadline)
                    <div class="flex items-start gap-3 rounded-2xl border border-neutral-200 bg-white px-4 py-3 shadow-soft">
                        <div class="mt-1 h-2 w-2 shrink-0 rounded-full bg-primary-500"></div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-neutral-900 line-clamp-2">{{ $deadline['title'] }}</p>
                            <p class="mt-1 text-xs font-semibold text-neutral-500">{{ $deadline['subtitle'] }}</p>
                            <div class="mt-2 flex items-center justify-between">
                                <div class="text-xs font-semibold text-neutral-500">{{ $deadline['due_label'] }}</div>
                                @if($deadline['meta'])
                                    <div class="text-xs font-semibold {{ $deadline['meta_class'] }}">{{ $deadline['meta'] }}</div>
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
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6 lg:col-span-8">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h2 class="text-sm font-semibold text-neutral-900">Recent Student Activity</h2>
                    <p class="mt-1 text-sm text-neutral-600">Latest updates from supervised students.</p>
                </div>
                <a href="{{ route('supervisor.students.index') }}" class="text-sm font-semibold text-primary-700 hover:text-primary-800">View all</a>
            </div>

            <div class="mt-5 overflow-hidden rounded-2xl border border-neutral-200">
                <div class="grid grid-cols-12 bg-neutral-50 px-4 py-3 text-xs font-semibold uppercase tracking-wide text-neutral-500">
                    <div class="col-span-3">Student</div>
                    <div class="col-span-5">Activity</div>
                    <div class="col-span-3">Internship</div>
                    <div class="col-span-1 text-right">Time</div>
                </div>

                <div class="divide-y divide-neutral-200">
                    @forelse($recent_activity as $row)
                        <div class="grid grid-cols-12 items-center gap-3 px-4 py-3">
                            <div class="col-span-3 flex items-center gap-3">
                                <div class="h-9 w-9 shrink-0 rounded-full bg-neutral-900 text-white flex items-center justify-center text-xs font-semibold">
                                    {{ strtoupper(substr($row['student_name'], 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-neutral-900">{{ $row['student_name'] }}</p>
                                </div>
                            </div>
                            <div class="col-span-5 min-w-0">
                                <p class="truncate text-sm font-semibold text-neutral-700">{{ $row['activity'] }}</p>
                            </div>
                            <div class="col-span-3 min-w-0">
                                <p class="truncate text-sm font-semibold text-neutral-700">{{ $row['internship'] }}</p>
                            </div>
                            <div class="col-span-1 text-right text-xs font-semibold text-neutral-500">{{ $row['time_label'] }}</div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-sm text-neutral-600">No recent activity.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6 lg:col-span-4">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h2 class="text-sm font-semibold text-neutral-900">My Schedule</h2>
                    <p class="mt-1 text-sm text-neutral-600">Today’s overview.</p>
                </div>
                <a href="{{ route('supervisor.calendar') }}" class="text-sm font-semibold text-primary-700 hover:text-primary-800">View calendar</a>
            </div>

            <div class="mt-5 space-y-3">
                @foreach($schedule as $item)
                    <div class="flex items-start gap-3 rounded-2xl border border-neutral-200 bg-white px-4 py-3 shadow-soft">
                        <div class="mt-2 h-2 w-2 shrink-0 rounded-full {{ $item['dot'] }}"></div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-neutral-900">{{ $item['title'] }}</p>
                                    <p class="mt-1 text-xs font-semibold text-neutral-500">{{ $item['subtitle'] }}</p>
                                </div>
                                <span class="shrink-0 rounded-full bg-neutral-100 px-2 py-1 text-xs font-semibold text-neutral-600">{{ $item['tag'] }}</span>
                            </div>
                            <p class="mt-2 text-xs font-semibold text-neutral-500">{{ $item['time'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
