<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Calendar</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Placeholder page</p>
    </div>

    <x-widget title="Upcoming Events" :collapsible="true">
        <x-dashboard.table
            :columns="[
                ['label' => 'Event', 'key' => 'title'],
                ['label' => 'Date', 'key' => 'date'],
            ]"
            :rows="$events"
            emptyMessage="No events scheduled."
        />
    </x-widget>
</div>
