<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Applications</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">List stub</p>
    </div>

    <x-widget title="Applications" :collapsible="true">
        <x-dashboard.table
            :columns="[
                ['label' => 'Company', 'key' => 'company'],
                ['label' => 'Position', 'key' => 'position'],
                ['label' => 'Status', 'key' => 'status'],
                ['label' => 'Applied On', 'key' => 'applied_on'],
            ]"
            :rows="$applications"
            emptyMessage="No applications yet."
        />
    </x-widget>
</div>

