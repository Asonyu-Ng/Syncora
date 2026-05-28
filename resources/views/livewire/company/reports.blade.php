<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Reports</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">List stub</p>
    </div>

    <x-widget title="Available Reports" :collapsible="true">
        <x-dashboard.table
            :columns="[
                ['label' => 'Title', 'key' => 'title'],
                ['label' => 'Intern', 'key' => 'intern'],
                ['label' => 'Created', 'key' => 'createdAt'],
                ['label' => 'Status', 'key' => 'status'],
            ]"
            :rows="$reports"
            emptyMessage="No reports available."
        />
    </x-widget>
</div>

