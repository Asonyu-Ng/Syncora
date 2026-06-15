@php
    $logCollection = collect($logs);
    $recentActors = $logCollection->pluck('actor')->unique()->count();
@endphp

<div class="space-y-6">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Audit trail
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950">Review recent platform actions and keep audit history easy to scan.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">
                    This page surfaces operational activity across the platform so admins can confirm who acted, what changed, and when it happened.
                </p>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Log summary</div>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ $logCollection->count() }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Events listed</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ $recentActors }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Actors involved</div>
                    </div>
                </div>
                <p class="mt-4 text-xs leading-5 text-neutral-500">Use the table below to trace recent operational changes and validate unexpected activity patterns.</p>
            </div>
        </div>
    </div>

    <x-widget title="Logs" :collapsible="true">
        <div class="space-y-4">
            <div class="rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-4">
                <div class="text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Audit note</div>
                <p class="mt-2 text-sm leading-6 text-neutral-600">
                    Review actor, action, and IP together to validate operational history and investigate unusual changes quickly.
                </p>
            </div>
            <x-dashboard.table
                :columns="[
                    ['label' => 'Time', 'key' => 'time'],
                    ['label' => 'Actor', 'key' => 'actor'],
                    ['label' => 'Action', 'key' => 'action'],
                    ['label' => 'IP', 'key' => 'ip'],
                ]"
                :rows="$logs"
                emptyMessage="No activity has been logged yet."
            />
        </div>
    </x-widget>
</div>
