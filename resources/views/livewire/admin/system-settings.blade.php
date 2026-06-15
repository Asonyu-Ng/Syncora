@php
    $settingsCollection = collect($settings);
    $enabledSettings = $settingsCollection->where('value', true)->count();
    $disabledSettings = $settingsCollection->where('value', false)->count();
@endphp

<div class="space-y-6">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Platform controls
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950">Adjust core system policies with a clearer view of what is currently enabled.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">
                    These controls affect platform-wide behavior, so the page emphasizes state clarity and safe review without changing the existing toggle workflow.
                </p>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Control summary</div>
                <div class="mt-4 grid gap-3 sm:grid-cols-3">
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ $settingsCollection->count() }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Settings</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ $enabledSettings }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Enabled</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ $disabledSettings }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Disabled</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-widget title="System Policies" :collapsible="true">
        <div class="overflow-hidden rounded-[24px] border border-neutral-200 bg-white">
            @foreach($settings as $setting)
                <div class="flex items-center justify-between gap-4 border-b border-neutral-200 px-4 py-4 last:border-b-0">
                    <div>
                        <div class="text-sm font-semibold text-neutral-950">{{ $setting['label'] }}</div>
                        <div class="mt-1 text-xs text-neutral-500">{{ $setting['key'] }}</div>
                    </div>

                    <button
                        type="button"
                        wire:click="toggle('{{ $setting['key'] }}')"
                        class="inline-flex min-w-[78px] items-center justify-center rounded-xl px-3 py-2 text-xs font-semibold transition {{ $setting['value'] ? 'bg-success-600 text-white hover:bg-success-500' : 'bg-neutral-100 text-neutral-700 hover:bg-neutral-200' }}"
                    >
                        {{ $setting['value'] ? 'On' : 'Off' }}
                    </button>
                </div>
            @endforeach
        </div>
    </x-widget>
</div>
