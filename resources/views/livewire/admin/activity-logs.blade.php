<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Activity Logs</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Table stub</p>
    </div>

    <x-widget title="Logs" :collapsible="true">
        <x-dashboard.table
            :columns="[
                ['label' => 'Time', 'key' => 'time'],
                ['label' => 'Actor', 'key' => 'actor'],
                ['label' => 'Action', 'key' => 'action'],
                ['label' => 'IP', 'key' => 'ip'],
            ]"
            :rows="$logs"
            emptyMessage="No activity yet."
        />
    </x-widget>
</div>
