<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div class="min-w-0">
            <h1 class="text-2xl font-semibold text-neutral-900 sm:text-3xl">{{ $summary['greeting'] ?? 'Welcome back' }}</h1>
            <p class="mt-2 text-sm text-neutral-600">Here’s an overview of your supervision activities.</p>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
            <button type="button" class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50">
                <svg class="h-4 w-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ $summary['date_range_label'] ?? '' }}
            </button>

            <a href="{{ route('supervisor.reports.index') }}" class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m0 0l3-3m-3 3l-3-3m9 9H6a2 2 0 01-2-2v-3m16 3v-3a2 2 0 00-2-2" />
                </svg>
                Download Report
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
            <div class="flex items-start justify-between gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-primary-50 text-primary-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4h-1m-6 6H2v-2a4 4 0 014-4h1m6 6v-2a4 4 0 00-4-4H8m4-6a4 4 0 11-8 0 4 4 0 018 0zm6 4a3 3 0 100-6 3 3 0 000 6z" />
                    </svg>
                </div>
                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6 10a2 2 0 114 0 2 2 0 01-4 0zm6 0a2 2 0 114 0 2 2 0 01-4 0zM2 10a2 2 0 114 0 2 2 0 01-4 0z" />
                    </svg>
                </button>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-semibold text-neutral-900">{{ $stats['students'] ?? 0 }}</div>
                <div class="mt-1 text-sm font-semibold text-neutral-700">Total Students</div>
                <div class="mt-2 text-xs font-semibold text-neutral-500">Under your supervision</div>
            </div>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
            <div class="flex items-start justify-between gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-success-50 text-success-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6 10a2 2 0 114 0 2 2 0 01-4 0zm6 0a2 2 0 114 0 2 2 0 01-4 0zM2 10a2 2 0 114 0 2 2 0 01-4 0z" />
                    </svg>
                </button>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-semibold text-neutral-900">{{ $stats['pending_approvals'] ?? 0 }}</div>
                <div class="mt-1 text-sm font-semibold text-neutral-700">Pending Approvals</div>
                <div class="mt-2 text-xs font-semibold text-neutral-500">Logbooks to review</div>
            </div>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
            <div class="flex items-start justify-between gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-warning-50 text-warning-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5h6M9 9h6m-7 4h8m-9 8h10a2 2 0 002-2V7a2 2 0 00-2-2h-3l-1-1H9L8 5H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6 10a2 2 0 114 0 2 2 0 01-4 0zm6 0a2 2 0 114 0 2 2 0 01-4 0zM2 10a2 2 0 114 0 2 2 0 01-4 0z" />
                    </svg>
                </button>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-semibold text-neutral-900">{{ $stats['tasks_assigned'] ?? 0 }}</div>
                <div class="mt-1 text-sm font-semibold text-neutral-700">Tasks Assigned</div>
                <div class="mt-2 text-xs font-semibold text-neutral-500">Active tasks</div>
            </div>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
            <div class="flex items-start justify-between gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-info-50 text-info-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6 10a2 2 0 114 0 2 2 0 01-4 0zm6 0a2 2 0 114 0 2 2 0 01-4 0zM2 10a2 2 0 114 0 2 2 0 01-4 0z" />
                    </svg>
                </button>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-semibold text-neutral-900">{{ $stats['tasks_completed'] ?? 0 }}</div>
                <div class="mt-1 text-sm font-semibold text-neutral-700">Tasks Completed</div>
                <div class="mt-2 text-xs font-semibold text-neutral-500">This month</div>
            </div>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
            <div class="flex items-start justify-between gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-danger-50 text-danger-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3v18m0 0l-4-4m4 4l4-4M4 7h16" />
                    </svg>
                </div>
                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6 10a2 2 0 114 0 2 2 0 01-4 0zm6 0a2 2 0 114 0 2 2 0 01-4 0zM2 10a2 2 0 114 0 2 2 0 01-4 0z" />
                    </svg>
                </button>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-semibold text-neutral-900">{{ $stats['completion_rate'] ?? 0 }}%</div>
                <div class="mt-1 text-sm font-semibold text-neutral-700">Completion Rate</div>
                <div class="mt-2 flex items-center justify-between text-xs font-semibold text-neutral-500">
                    <span>Average progress</span>
                    <span class="text-success-600">↑ 1.8%</span>
                </div>
            </div>
        </div>
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
