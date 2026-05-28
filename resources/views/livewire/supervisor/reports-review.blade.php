<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Reports Review</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">List stub</p>
    </div>

    <x-widget title="Reports" :collapsible="true">
        <x-dashboard.table
            :columns="[
                ['label' => 'Student', 'key' => 'student'],
                ['label' => 'Title', 'key' => 'title'],
                ['label' => 'Submitted', 'key' => 'submitted'],
                ['label' => 'Status', 'key' => 'status'],
            ]"
            :rows="$reports"
            emptyMessage="No reports found."
        />
    </x-widget>
</div>
