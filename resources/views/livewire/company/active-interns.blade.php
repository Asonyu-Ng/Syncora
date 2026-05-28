<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Active Interns</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">List stub</p>
    </div>

    <x-widget title="Interns" :collapsible="true">
        <x-dashboard.table
            :columns="[
                ['label' => 'Name', 'key' => 'name'],
                ['label' => 'Role', 'key' => 'role'],
                ['label' => 'Start Date', 'key' => 'startDate'],
                ['label' => 'Progress', 'key' => 'progress'],
            ]"
            :rows="$interns"
            emptyMessage="No active interns found."
        />
    </x-widget>
</div>

