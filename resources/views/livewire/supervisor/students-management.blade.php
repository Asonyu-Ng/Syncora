<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Students Management</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">List stub</p>
    </div>

    <x-widget title="Students" :collapsible="true">
        <x-dashboard.table
            :columns="[
                ['label' => 'Name', 'key' => 'name'],
                ['label' => 'Matricule', 'key' => 'matricule'],
                ['label' => 'Company', 'key' => 'company'],
                ['label' => 'Status', 'key' => 'status'],
            ]"
            :rows="$students"
            emptyMessage="No students found."
        />
    </x-widget>
</div>
