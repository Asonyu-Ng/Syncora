@extends('layouts.dashboard')

@section('content')
@php
    $quickActionsList = $quickActions ?? [];
    $systemHealthList = $systemHealth ?? [];
    $internshipOverview = $internshipStats ?? [];
    $maxRegistrationValue = max($registrationData['values']);
    $recentRegistrations = array_sum(array_slice($registrationData['values'], -3));
    $latestRegistrationValue = $registrationData['values'][array_key_last($registrationData['values'])] ?? 0;
    $openInternships = $internshipOverview['open'] ?? 0;
    $filledInternships = $internshipOverview['filled'] ?? 0;
    $storageHealth = collect($systemHealthList)->firstWhere('name', 'Storage');
@endphp
<div class="space-y-8">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card dark:border-neutral-800 dark:from-neutral-950 dark:via-neutral-950 dark:to-primary-500/10">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.15fr_0.85fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft dark:border-primary-500/20 dark:bg-neutral-950 dark:text-primary-200">
                    Admin command center
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950 dark:text-neutral-50">Keep platform health, growth, and oversight visible from one view.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600 dark:text-neutral-300">
                    Review system growth, follow recent activity, and stay ahead of verification or operations tasks without leaving the dashboard.
                </p>

                <div class="mt-5 grid gap-3 sm:grid-cols-3">
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-4 shadow-soft dark:border-neutral-800 dark:bg-neutral-950">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950 dark:text-neutral-50">{{ number_format($stats['pendingVerifications']) }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400 dark:text-neutral-500">Awaiting review</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-4 shadow-soft dark:border-neutral-800 dark:bg-neutral-950">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950 dark:text-neutral-50">{{ number_format($openInternships) }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400 dark:text-neutral-500">Open internships</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-4 shadow-soft dark:border-neutral-800 dark:bg-neutral-950">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950 dark:text-neutral-50">{{ $storageHealth['status'] ?? 'Stable' }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400 dark:text-neutral-500">Storage usage</div>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft dark:border-neutral-800 dark:bg-neutral-950/80">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500 dark:text-neutral-400">Today at a glance</div>
                        <p class="mt-2 text-sm leading-6 text-neutral-600 dark:text-neutral-300">The platform is healthy, with growth signals and action queues visible below.</p>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-success-50 px-3 py-1 text-xs font-semibold text-success-700 ring-1 ring-inset ring-success-100 dark:bg-success-500/10 dark:text-success-200 dark:ring-success-500/20">
                        Platform stable
                    </span>
                </div>

                <div class="mt-5 space-y-3">
                    @forelse(array_slice($quickActionsList, 0, 4) as $action)
                        <div class="flex items-start justify-between gap-4 rounded-2xl border border-neutral-200 bg-white px-4 py-3 dark:border-neutral-800 dark:bg-neutral-950">
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-neutral-950 dark:text-neutral-50">{{ $action['label'] }}</div>
                                <div class="mt-1 text-xs leading-5 text-neutral-500 dark:text-neutral-400">{{ $action['description'] }}</div>
                            </div>
                            <span class="rounded-full bg-neutral-100 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-neutral-500 dark:bg-neutral-900 dark:text-neutral-400">
                                Ready
                            </span>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-neutral-300 bg-neutral-50 px-4 py-8 text-center text-sm text-neutral-500 dark:border-neutral-700 dark:bg-neutral-900/40 dark:text-neutral-400">
                            Quick admin shortcuts will appear here when action data is available.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-stats-card
            title="Total Users"
            value="{{ number_format($stats['totalUsers']) }}"
            trend="{{ $stats['userTrend'] }}"
            trendDirection="up"
            icon="users"
            color="blue"
        />

        <x-stats-card
            title="Total Internships"
            value="{{ number_format($stats['totalInternships']) }}"
            trend="{{ $stats['internshipTrend'] }}"
            trendDirection="up"
            icon="briefcase"
            color="green"
        />

        <x-stats-card
            title="Active Applications"
            value="{{ number_format($stats['activeApplications']) }}"
            trend="{{ $stats['applicationTrend'] }}"
            trendDirection="down"
            icon="document"
            color="yellow"
        />

        <x-stats-card
            title="Pending Verifications"
            value="{{ number_format($stats['pendingVerifications']) }}"
            icon="shield-check"
            color="purple"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-widget title="User Registrations" :collapsible="true">
            <div class="space-y-5">
                <div class="grid gap-3 sm:grid-cols-3">
                    <div class="rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-3">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Latest month</div>
                        <div class="mt-2 text-2xl font-semibold tracking-tight text-neutral-950">{{ number_format($latestRegistrationValue) }}</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-3">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Last 3 months</div>
                        <div class="mt-2 text-2xl font-semibold tracking-tight text-neutral-950">{{ number_format($recentRegistrations) }}</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-3">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Filled positions</div>
                        <div class="mt-2 text-2xl font-semibold tracking-tight text-neutral-950">{{ number_format($filledInternships) }}</div>
                    </div>
                </div>

                <div class="flex h-48 items-end justify-between gap-2 rounded-3xl border border-neutral-200 bg-neutral-50 px-4 pb-4 pt-6">
                    @foreach($registrationData['values'] as $value)
                        <div class="flex flex-1 flex-col items-center justify-end gap-3">
                            <div
                                class="w-full rounded-t-[18px] bg-gradient-to-t from-primary-600 via-primary-500 to-primary-400 shadow-soft"
                                style="height: {{ ($value / $maxRegistrationValue) * 100 }}%"
                                title="{{ $value }} registrations"
                            ></div>
                            <span class="text-[11px] font-semibold text-neutral-500">{{ $value }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-between text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">
                    @foreach($registrationData['labels'] as $label)
                        <span class="flex-1 text-center">{{ $label }}</span>
                    @endforeach
                </div>
            </div>
        </x-widget>

        <x-widget title="Recent Activity" :collapsible="true">
            <div class="space-y-3">
                @foreach($activities as $activity)
                    @php
                        $activityColor = match($activity['type']) {
                            'registration' => 'bg-primary-50 text-primary-700 ring-primary-100 dark:bg-primary-500/10 dark:text-primary-200 dark:ring-primary-500/20',
                            'internship' => 'bg-success-50 text-success-700 ring-success-100 dark:bg-success-500/10 dark:text-success-200 dark:ring-success-500/20',
                            'verification' => 'bg-violet-50 text-violet-700 ring-violet-100 dark:bg-violet-500/10 dark:text-violet-200 dark:ring-violet-500/20',
                            'application' => 'bg-warning-50 text-warning-700 ring-warning-100 dark:bg-warning-500/10 dark:text-warning-200 dark:ring-warning-500/20',
                            'task' => 'bg-sky-50 text-sky-700 ring-sky-100 dark:bg-sky-500/10 dark:text-sky-200 dark:ring-sky-500/20',
                            'report' => 'bg-neutral-100 text-neutral-700 ring-neutral-200 dark:bg-neutral-900 dark:text-neutral-200 dark:ring-neutral-800',
                            default => 'bg-neutral-100 text-neutral-700 ring-neutral-200 dark:bg-neutral-900 dark:text-neutral-200 dark:ring-neutral-800',
                        };
                    @endphp
                    <div class="flex items-start gap-3 rounded-2xl border border-neutral-200 bg-white px-4 py-3 transition-colors hover:bg-neutral-50">
                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl ring-1 ring-inset {{ $activityColor }}">
                            <span class="text-xs font-semibold">{{ strtoupper(substr($activity['type'], 0, 1)) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-neutral-950">{{ $activity['title'] }}</p>
                            <p class="mt-1 text-xs leading-5 text-neutral-500">{{ $activity['time'] }}</p>
                        </div>
                        <span class="rounded-full bg-neutral-100 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-neutral-500">
                            {{ ucfirst($activity['type']) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </x-widget>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-widget title="System Health" :collapsible="true">
            <div class="grid gap-3 sm:grid-cols-2">
                @forelse($systemHealthList as $service)
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="text-sm font-semibold text-neutral-950">{{ $service['name'] }}</div>
                                <div class="mt-1 text-xs leading-5 text-neutral-500">{{ $service['detail'] }}</div>
                            </div>
                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] {{ $service['color'] === 'green' ? 'bg-success-50 text-success-700 ring-1 ring-inset ring-success-100' : 'bg-warning-50 text-warning-700 ring-1 ring-inset ring-warning-100' }}">
                                {{ $service['status'] }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-neutral-300 bg-neutral-50 px-4 py-8 text-center text-sm text-neutral-500 sm:col-span-2">
                        System health indicators will appear here when monitoring details are available.
                    </div>
                @endforelse
            </div>
        </x-widget>

        <x-widget title="Operations Focus" :collapsible="true">
            <div class="space-y-3">
                <div class="rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-4">
                    <div class="text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Priority queue</div>
                    <p class="mt-2 text-sm leading-6 text-neutral-600">
                        Resolve pending verifications first, then review application volume and registration growth to keep the platform balanced.
                    </p>
                </div>
                @forelse(array_slice($quickActionsList, 0, 3) as $action)
                    <div class="flex items-center justify-between gap-4 rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div>
                            <div class="text-sm font-semibold text-neutral-950">{{ $action['label'] }}</div>
                            <div class="mt-1 text-xs leading-5 text-neutral-500">{{ $action['description'] }}</div>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-[0.14em] text-primary-700">Open</span>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-neutral-300 bg-neutral-50 px-4 py-8 text-center text-sm text-neutral-500">
                        Admin focus items will appear here when shortcut data is available.
                    </div>
                @endforelse
            </div>
        </x-widget>
    </div>
</div>
@endsection
