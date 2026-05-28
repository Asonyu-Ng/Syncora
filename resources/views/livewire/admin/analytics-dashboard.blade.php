<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Analytics Dashboard</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Placeholder widgets</p>
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

    <x-widget title="Traffic Sources (stub)" :collapsible="true">
        <x-dashboard.table
            :columns="[
                ['label' => 'Source', 'key' => 'label'],
                ['label' => 'Share (%)', 'key' => 'value'],
            ]"
            :rows="$trafficSources"
            emptyMessage="No analytics data."
        />
    </x-widget>
</div>
