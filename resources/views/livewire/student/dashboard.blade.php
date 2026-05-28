<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Student Dashboard</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Widgets and activity feed (stubs)</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-stats-card title="Active Internship" value="{{ $stats['activeInternship'] }}" icon="briefcase" color="blue" />
        <x-stats-card title="Pending Tasks" value="{{ $stats['pendingTasks'] }}" icon="document" color="yellow" />
        <x-stats-card title="Hours This Week" value="{{ $stats['hoursThisWeek'] }}" icon="clock" color="green" />
        <x-stats-card title="Applications" value="{{ $stats['applications'] }}" icon="users" color="purple" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-widget title="Quick Links" :collapsible="true">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <a href="{{ route('student.internships.search') }}" class="px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Internship Search</div>
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Search by city (stub)</div>
                </a>
                <a href="{{ route('student.applications.index') }}" class="px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Applications</div>
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">View submitted applications (stub)</div>
                </a>
                <a href="{{ route('student.tasks.board') }}" class="px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Task Board</div>
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Kanban/list stub</div>
                </a>
                <a href="{{ route('student.logbook.index') }}" class="px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Logbook</div>
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Create/list entries (stub)</div>
                </a>
            </div>
        </x-widget>

        <x-widget title="Activity Feed" :collapsible="true">
            <div class="space-y-3">
                @foreach($activities as $activity)
                    <div class="p-3 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $activity['title'] }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $activity['time'] }}</div>
                        </div>
                        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Type: {{ $activity['type'] }}</div>
                    </div>
                @endforeach
            </div>
        </x-widget>
    </div>
</div>

