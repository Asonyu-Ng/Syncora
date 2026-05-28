<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Internships Monitoring</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Table stub</p>
    </div>

    <x-widget title="Internships" :collapsible="true">
        <x-dashboard.table
            :columns="[
                ['label' => 'Title', 'key' => 'title'],
                ['label' => 'Company', 'key' => 'company'],
                ['label' => 'Location', 'key' => 'location'],
                ['label' => 'Status', 'key' => 'status'],
                ['label' => 'Applications', 'key' => 'applications'],
            ]"
            :rows="$internships"
            emptyMessage="No internships found."
        />
    </x-widget>
</div>
