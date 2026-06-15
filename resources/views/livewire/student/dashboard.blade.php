@php
    $pendingTasks = (int) ($stats['pendingTasks'] ?? 0);
    $hoursThisWeek = (int) ($stats['hoursThisWeek'] ?? 0);
    $applications = (int) ($stats['applications'] ?? 0);
    $completionRate = max(0, min(100, (int) round((max(0, 8 - $pendingTasks) / 8) * 100)));

    $overviewCards = [
        [
            'label' => 'Active Internship',
            'value' => $stats['activeInternship'] ?? 'No active placement',
            'meta' => 'Current placement workspace',
            'icon_bg' => 'bg-primary-50',
            'icon_text' => 'text-primary-700',
            'svg' => 'M7 7h10M7 11h10M7 15h6M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z',
        ],
        [
            'label' => 'Pending Tasks',
            'value' => $pendingTasks,
            'meta' => $pendingTasks === 1 ? '1 item needs attention' : $pendingTasks . ' items need attention',
            'icon_bg' => 'bg-warning-50',
            'icon_text' => 'text-warning-700',
            'svg' => 'M9 5h6M9 9h6m-7 4h8m-9 8h10a2 2 0 002-2V7a2 2 0 00-2-2h-3l-1-1H9L8 5H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        ],
        [
            'label' => 'Hours This Week',
            'value' => $hoursThisWeek,
            'meta' => 'Logged internship time',
            'icon_bg' => 'bg-success-50',
            'icon_text' => 'text-success-700',
            'svg' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        [
            'label' => 'Applications',
            'value' => $applications,
            'meta' => 'Open application history',
            'icon_bg' => 'bg-info-50',
            'icon_text' => 'text-info-700',
            'svg' => 'M17 20h5v-2a4 4 0 00-4-4h-1m-6 6H2v-2a4 4 0 014-4h1m6 6v-2a4 4 0 00-4-4H8m4-6a4 4 0 11-8 0 4 4 0 018 0zm6 4a3 3 0 100-6 3 3 0 000 6z',
        ],
    ];

    $quickLinks = [
        ['title' => 'Find internships', 'body' => 'Explore available placements and save interesting roles.', 'route' => route('student.internships.search')],
        ['title' => 'Review applications', 'body' => 'Track status changes and follow up on decisions.', 'route' => route('student.applications.index')],
        ['title' => 'Submit task updates', 'body' => 'Share evidence, progress notes, and files for review.', 'route' => route('student.tasks.board')],
        ['title' => 'Open logbook', 'body' => 'Record daily work and keep your weekly history organised.', 'route' => route('student.logbook.index')],
    ];

    $focusAreas = [
        ['label' => 'Task completion', 'value' => $completionRate . '%', 'style' => 'width: ' . $completionRate . '%'],
        ['label' => 'Applications in progress', 'value' => $applications],
        ['label' => 'Hours logged this week', 'value' => $hoursThisWeek . ' hrs'],
    ];
@endphp

<div class="space-y-8">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/70 shadow-card">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.2fr_0.8fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Student workspace
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950 sm:text-[2.15rem]">
                    Keep your internship progress organised from one dashboard.
                </h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600 sm:text-[15px]">
                    Follow your placement, stay ahead of pending tasks, and move quickly between applications, submissions, and logbook work.
                </p>

                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('student.tasks.board') }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500">
                        Open task board
                    </a>
                    <a href="{{ route('student.internships.search') }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-neutral-200 bg-white px-5 text-sm font-semibold text-neutral-800 shadow-soft transition hover:bg-neutral-50">
                        Browse internships
                    </a>
                </div>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">This Week</p>
                        <h2 class="mt-2 text-lg font-semibold tracking-tight text-neutral-950">Execution snapshot</h2>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-success-50 px-3 py-1 text-xs font-semibold text-success-700 ring-1 ring-inset ring-success-100">
                        Active
                    </span>
                </div>

                <div class="mt-5 space-y-4">
                    @foreach ($focusAreas as $area)
                        <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-sm font-semibold text-neutral-700">{{ $area['label'] }}</span>
                                <span class="text-sm font-semibold text-neutral-950">{{ $area['value'] }}</span>
                            </div>

                            @if (!empty($area['style']))
                                <div class="mt-3 h-2 overflow-hidden rounded-full bg-neutral-100">
                                    <div class="h-2 rounded-full bg-primary-600" style="{{ $area['style'] }}"></div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($overviewCards as $card)
            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card">
                <div class="flex items-start justify-between gap-4">
                    <div class="inline-flex h-11 w-11 items-center justify-center rounded-2xl {{ $card['icon_bg'] }} {{ $card['icon_text'] }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['svg'] }}" />
                        </svg>
                    </div>
                    <span class="text-[11px] font-semibold uppercase tracking-[0.14em] text-neutral-400">{{ $card['label'] }}</span>
                </div>
                <div class="mt-5 text-2xl font-semibold tracking-tight text-neutral-950">{{ $card['value'] }}</div>
                <p class="mt-2 text-sm leading-6 text-neutral-600">{{ $card['meta'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid gap-6 lg:grid-cols-12">
        <div class="space-y-6 lg:col-span-7">
            <div class="rounded-2xl border border-neutral-200 bg-white shadow-card">
                <div class="border-b border-neutral-200 px-5 py-4 sm:px-6">
                    <h2 class="text-sm font-semibold text-neutral-900">Quick Navigation</h2>
                    <p class="mt-1 text-sm text-neutral-600">Jump straight into the main student workflow areas.</p>
                </div>

                <div class="grid gap-3 p-5 sm:grid-cols-2 sm:p-6">
                    @foreach ($quickLinks as $link)
                        <a href="{{ $link['route'] }}" class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-soft transition hover:bg-neutral-50">
                            <div class="text-sm font-semibold text-neutral-900">{{ $link['title'] }}</div>
                            <p class="mt-2 text-sm leading-6 text-neutral-600">{{ $link['body'] }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-6 lg:col-span-5">
            <div class="rounded-2xl border border-neutral-200 bg-white shadow-card">
                <div class="border-b border-neutral-200 px-5 py-4 sm:px-6">
                    <h2 class="text-sm font-semibold text-neutral-900">Recent Activity</h2>
                    <p class="mt-1 text-sm text-neutral-600">Your latest updates across the student workspace.</p>
                </div>

                <div class="space-y-3 p-5 sm:p-6">
                    @foreach ($activities as $activity)
                        <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3 shadow-soft">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-neutral-900">{{ $activity['title'] }}</p>
                                    <p class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">{{ $activity['type'] }}</p>
                                </div>
                                <span class="shrink-0 text-xs font-semibold text-neutral-500">{{ $activity['time'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <h2 class="text-sm font-semibold text-neutral-900">Account Shortcuts</h2>
                <div class="mt-4 space-y-2">
                    <a href="{{ route('student.profile') }}" class="flex items-center justify-between rounded-xl px-3 py-2 text-sm font-semibold text-neutral-700 transition hover:bg-neutral-50">
                        Profile
                        <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="{{ route('student.settings') }}" class="flex items-center justify-between rounded-xl px-3 py-2 text-sm font-semibold text-neutral-700 transition hover:bg-neutral-50">
                        Settings
                        <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
