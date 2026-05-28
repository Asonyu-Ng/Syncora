<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Internship Monitoring</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Table stub</p>
    </div>

    <x-widget title="Active Internships" :collapsible="true">
        <x-dashboard.table
            :columns="[
                ['label' => 'Student', 'key' => 'student'],
                ['label' => 'Company', 'key' => 'company'],
                ['label' => 'Position', 'key' => 'position'],
                ['label' => 'Progress', 'key' => 'progress'],
                ['label' => 'Status', 'key' => 'status'],
            ]"
            :rows="$internships"
            emptyMessage="No internships to monitor."
        />
    </x-widget>
</div>
