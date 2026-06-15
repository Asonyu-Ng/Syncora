<div class="space-y-8">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.05fr_0.95fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Company profile
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950">Present a clear employer identity across your internship workspace.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">
                    Keep your organisation details easy to scan so applicants, interns, and reviewers always see the right company context.
                </p>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Profile health</div>
                <div class="mt-4 rounded-2xl border border-neutral-200 bg-white px-4 py-4">
                    <div class="flex items-center justify-between text-sm font-semibold text-neutral-700">
                        <span>Completion</span>
                        <span class="text-neutral-950">{{ $company['profileCompletion'] }}%</span>
                    </div>
                    <div class="mt-3 h-2 overflow-hidden rounded-full bg-neutral-100">
                        <div class="h-2 rounded-full bg-primary-600" style="width: {{ $company['profileCompletion'] }}%"></div>
                    </div>
                    <p class="mt-3 text-sm leading-6 text-neutral-600">Review company identity and communication settings together so your workspace stays current and credible.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <x-widget title="Profile Details" :collapsible="true">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <div class="text-xs font-semibold text-gray-600 dark:text-gray-300">Company</div>
                            <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $company['name'] }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-600 dark:text-gray-300">Email</div>
                            <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $company['email'] }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-600 dark:text-gray-300">Website</div>
                            <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $company['website'] }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-600 dark:text-gray-300">Location</div>
                            <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $company['location'] }}</div>
                        </div>
                    </div>

                    <a href="{{ route('company.settings') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                        Open company settings
                    </a>
                </div>
            </x-widget>
        </div>
    </div>
</div>
