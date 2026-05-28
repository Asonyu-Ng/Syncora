<div class="space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Internship Management</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">List/edit stub</p>
        </div>

        <a
            href="{{ route('company.internships.create') }}"
            class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition-colors"
        >
            Post Internship
        </a>
    </div>

    <x-widget title="Internships" :collapsible="true">
        <x-dashboard.table
            :columns="[
                ['label' => 'Title', 'key' => 'title'],
                ['label' => 'Location', 'key' => 'location'],
                ['label' => 'Applications', 'key' => 'applications'],
                ['label' => 'Status', 'key' => 'status'],
            ]"
            :rows="$internships"
            emptyMessage="No internships posted yet."
        />
    </x-widget>
</div>

