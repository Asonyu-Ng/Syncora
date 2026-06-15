<div class="space-y-8">
    @if (session()->has('message'))
        <div class="rounded-2xl border border-primary-200 bg-primary-50 px-5 py-4 text-sm font-semibold text-primary-900 shadow-soft">
            {{ session('message') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.05fr_0.95fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Supervisor settings
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950 sm:text-[2.1rem]">Control how review updates reach you.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">
                    Set the right notification rhythm for daily approval work and keep your workspace aligned with how you supervise students.
                </p>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <h2 class="text-sm font-semibold text-neutral-900">Preference Summary</h2>
                <div class="mt-4 space-y-3">
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-sm font-semibold text-neutral-900">Email notifications</div>
                        <p class="mt-1 text-sm text-neutral-600">{{ $emailNotifications ? 'Enabled for workflow events and alerts.' : 'Disabled for direct email alerts.' }}</p>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-sm font-semibold text-neutral-900">Weekly summary</div>
                        <p class="mt-1 text-sm text-neutral-600">{{ $weeklySummary ? 'Enabled for a rolled-up supervision digest.' : 'Disabled for summary delivery.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <div class="space-y-6 lg:col-span-8">
            <div class="rounded-2xl border border-neutral-200 bg-white shadow-card overflow-hidden">
                <div class="border-b border-neutral-200 px-5 py-4 sm:px-6">
                    <h2 class="text-sm font-semibold text-neutral-900">Notifications</h2>
                    <p class="mt-1 text-sm text-neutral-600">Choose the alerts that support your review cadence.</p>
                </div>

                <div class="divide-y divide-neutral-100">
                    <label class="flex items-start justify-between gap-4 px-5 py-4 sm:px-6">
                        <div class="min-w-0">
                            <div class="text-sm font-semibold text-neutral-900">Email notifications</div>
                            <p class="mt-1 text-sm text-neutral-600">Receive immediate updates when activity needs your attention.</p>
                        </div>
                        <input type="checkbox" wire:model="emailNotifications" class="mt-1 h-4 w-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500" />
                    </label>

                    <label class="flex items-start justify-between gap-4 px-5 py-4 sm:px-6">
                        <div class="min-w-0">
                            <div class="text-sm font-semibold text-neutral-900">Weekly summary</div>
                            <p class="mt-1 text-sm text-neutral-600">Receive a summary of progress, pending approvals, and notable changes.</p>
                        </div>
                        <input type="checkbox" wire:model="weeklySummary" class="mt-1 h-4 w-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500" />
                    </label>
                </div>

                <div class="border-t border-neutral-200 px-5 py-4 sm:px-6">
                    <button
                        type="button"
                        wire:click="save"
                        class="inline-flex h-11 items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500"
                    >
                        Save preferences
                    </button>
                </div>
            </div>
        </div>

        <div class="space-y-6 lg:col-span-4">
            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <h2 class="text-sm font-semibold text-neutral-900">Quick Links</h2>
                <div class="mt-4 space-y-2">
                    <a href="{{ route('supervisor.profile') }}" class="flex items-center justify-between rounded-xl px-3 py-2 text-sm font-semibold text-neutral-700 transition hover:bg-neutral-50">
                        Profile
                        <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center justify-between rounded-xl px-3 py-2 text-sm font-semibold text-neutral-700 transition hover:bg-neutral-50">
                        Account settings
                        <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <h2 class="text-sm font-semibold text-neutral-900">How This Helps</h2>
                <p class="mt-3 text-sm leading-6 text-neutral-600">
                    Reduce noise when your queue is light, or keep updates switched on when supervision requires faster response times.
                </p>
            </div>
        </div>
    </div>
</div>
