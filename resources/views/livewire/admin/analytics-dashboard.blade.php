@php
    $trafficCollection = collect($trafficSources);
    $topSource = $trafficCollection->sortByDesc('value')->first();
@endphp

<div class="space-y-6">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Platform analytics
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950">Turn activity signals into a clearer view of platform momentum.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">
                    Review headline KPIs and traffic composition from the current analytics service without changing how data is loaded into this dashboard.
                </p>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Insight summary</div>
                <div class="mt-4 space-y-3">
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Traffic sources tracked</div>
                        <div class="mt-2 text-2xl font-semibold tracking-tight text-neutral-950">{{ $trafficCollection->count() }}</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Leading source</div>
                        <div class="mt-2 text-sm font-semibold text-neutral-950">{{ $topSource['label'] ?? 'No source yet' }}</div>
                        <div class="mt-1 text-xs text-neutral-500">{{ $topSource['value'] ?? 0 }}% of tracked traffic</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        @foreach($kpis as $kpi)
            <x-stats-card
                :title="$kpi['label']"
                icon="chart-bar"
                :value="$kpi['value']"
                :trend="$kpi['trend']"
            />
        @endforeach
    </div>

    <div class="grid gap-6 lg:grid-cols-[1.25fr_0.75fr]">
        <x-widget title="Traffic Sources" :collapsible="true">
            <x-dashboard.table
                :columns="[
                    ['label' => 'Source', 'key' => 'label'],
                    ['label' => 'Share (%)', 'key' => 'value'],
                ]"
                :rows="$trafficSources"
                emptyMessage="Analytics data will appear here once traffic sources are available."
            />
        </x-widget>

        <x-widget title="Reading Guide" :collapsible="true">
            <div class="space-y-3">
                <div class="rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-4">
                    <div class="text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">How to use this view</div>
                    <p class="mt-2 text-sm leading-6 text-neutral-600">
                        Treat the KPI row as the quick pulse and the traffic table as the source mix behind current platform activity.
                    </p>
                </div>
                <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-4">
                    <div class="text-sm font-semibold text-neutral-950">Next review prompt</div>
                    <p class="mt-2 text-sm leading-6 text-neutral-600">
                        Compare the strongest KPI shifts with the leading source above to decide whether growth is broad-based or concentrated.
                    </p>
                </div>
            </div>
        </x-widget>
    </div>
</div>
