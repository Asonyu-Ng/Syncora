@php
    $initial = strtoupper(substr((string) ($user['name'] ?? 'S'), 0, 1));
    $profileRows = [
        ['label' => 'Full name', 'value' => $user['name'] ?? '—'],
        ['label' => 'Email address', 'value' => $user['email'] ?? '—'],
        ['label' => 'Role', 'value' => ucfirst((string) ($user['role'] ?? 'supervisor'))],
    ];

    $managementNotes = [
        'Use your account page for password and account-level updates.',
        'Open settings to manage notification preferences for reviews and summaries.',
        'Keep profile details current so students know who is reviewing their work.',
    ];
@endphp

<div class="space-y-8">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.05fr_0.95fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Supervisor profile
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950 sm:text-[2.1rem]">Present a clear reviewer identity across the platform.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">
                    This profile surface keeps your core account information easy to scan while linking directly to the places where you manage preferences and account details.
                </p>

                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('profile.edit') }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500">
                        Edit account
                    </a>
                    <a href="{{ route('supervisor.settings') }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-neutral-200 bg-white px-5 text-sm font-semibold text-neutral-800 shadow-soft transition hover:bg-neutral-50">
                        Open settings
                    </a>
                </div>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <div class="flex items-start gap-4">
                    <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-neutral-900 text-xl font-semibold text-white">
                        {{ $initial }}
                    </div>
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="text-lg font-semibold tracking-tight text-neutral-950">{{ $user['name'] }}</h2>
                            <span class="inline-flex items-center rounded-full bg-success-50 px-3 py-1 text-xs font-semibold text-success-700 ring-1 ring-inset ring-success-100">
                                Active reviewer
                            </span>
                        </div>
                        <p class="mt-2 text-sm text-neutral-600">{{ $user['email'] }}</p>
                        <p class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">{{ $user['role'] }}</p>
                    </div>
                </div>

                <div class="mt-5 space-y-3">
                    @foreach ($managementNotes as $note)
                        <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3 text-sm leading-6 text-neutral-600">
                            {{ $note }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <div class="lg:col-span-7">
            <div class="rounded-2xl border border-neutral-200 bg-white shadow-card overflow-hidden">
                <div class="border-b border-neutral-200 px-5 py-4 sm:px-6">
                    <h2 class="text-sm font-semibold text-neutral-900">Profile Summary</h2>
                    <p class="mt-1 text-sm text-neutral-600">Core identity details used across review, approval, and communication screens.</p>
                </div>

                <div class="divide-y divide-neutral-100">
                    @foreach ($profileRows as $row)
                        <div class="grid gap-2 px-5 py-4 sm:grid-cols-3 sm:items-center sm:px-6">
                            <div class="text-xs font-semibold uppercase tracking-[0.14em] text-neutral-500">{{ $row['label'] }}</div>
                            <div class="text-sm font-semibold text-neutral-900 sm:col-span-2">{{ $row['value'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-6 lg:col-span-5">
            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <h2 class="text-sm font-semibold text-neutral-900">Quick Actions</h2>
                <div class="mt-4 space-y-2">
                    <a href="{{ route('profile.edit') }}" class="flex items-center justify-between rounded-xl px-3 py-2 text-sm font-semibold text-neutral-700 transition hover:bg-neutral-50">
                        Update account details
                        <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="{{ route('supervisor.settings') }}" class="flex items-center justify-between rounded-xl px-3 py-2 text-sm font-semibold text-neutral-700 transition hover:bg-neutral-50">
                        Manage preferences
                        <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="{{ route('supervisor.dashboard') }}" class="flex items-center justify-between rounded-xl px-3 py-2 text-sm font-semibold text-neutral-700 transition hover:bg-neutral-50">
                        Return to dashboard
                        <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <h2 class="text-sm font-semibold text-neutral-900">Reviewer Guidance</h2>
                <p class="mt-3 text-sm leading-6 text-neutral-600">
                    Keep this information aligned with your institutional account so students always see the correct reviewer details when they submit work or expect approval feedback.
                </p>
            </div>
        </div>
    </div>
</div>
