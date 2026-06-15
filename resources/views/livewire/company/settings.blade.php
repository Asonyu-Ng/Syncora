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
                    Company settings
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950">Control how your company workspace communicates.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">
                    Adjust notifications and digest preferences so applicant updates and internship activity reach the right people at the right time.
                </p>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <h2 class="text-sm font-semibold text-neutral-900">Preference summary</h2>
                <div class="mt-4 space-y-3">
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3 text-sm leading-6 text-neutral-600">
                        Email notifications are {{ $emailNotifications ? 'enabled' : 'disabled' }} for account activity and workflow updates.
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3 text-sm leading-6 text-neutral-600">
                        Weekly digest is {{ $weeklyDigest ? 'enabled' : 'disabled' }} for roll-up summaries.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-widget title="Notifications" :collapsible="true">
        <div class="space-y-4">
            <label class="flex items-center gap-3">
                <input
                    type="checkbox"
                    wire:model="emailNotifications"
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                />
                <span class="text-sm text-gray-700 dark:text-gray-200">Email notifications</span>
            </label>

            <label class="flex items-center gap-3">
                <input
                    type="checkbox"
                    wire:model="weeklyDigest"
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                />
                <span class="text-sm text-gray-700 dark:text-gray-200">Weekly digest</span>
            </label>

            <button
                type="button"
                wire:click="save"
                class="inline-flex h-11 items-center rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500"
            >
                Save preferences
            </button>
        </div>
    </x-widget>
</div>
