<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Dashboard</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Progress overview stubs</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-stats-card title="Students" value="{{ $stats['students'] ?? 0 }}" icon="users" color="blue" />
        <x-stats-card title="Active Internships" value="{{ $stats['activeInternships'] ?? 0 }}" icon="briefcase" color="green" />
        <x-stats-card title="Pending Logbooks" value="{{ $stats['pendingLogbooks'] ?? 0 }}" icon="clock" color="yellow" />
        <x-stats-card title="Pending Evaluations" value="{{ $stats['pendingEvaluations'] ?? 0 }}" icon="chart-bar" color="purple" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-widget title="Pending Logbooks" :collapsible="true">
            <x-dashboard.table
                :columns="[
                    ['label' => 'Student', 'key' => 'student'],
                    ['label' => 'Week', 'key' => 'week'],
                    ['label' => 'Submitted', 'key' => 'submitted'],
                ]"
                :rows="$pendingLogbooks"
                emptyMessage="No logbooks awaiting approval."
            />
        </x-widget>

        <x-widget title="Recent Reports" :collapsible="true">
            <x-dashboard.table
                :columns="[
                    ['label' => 'Student', 'key' => 'student'],
                    ['label' => 'Title', 'key' => 'title'],
                    ['label' => 'Time', 'key' => 'time'],
                ]"
                :rows="$recentReports"
                emptyMessage="No reports available."
            />
        </x-widget>
    </div>
</div>
