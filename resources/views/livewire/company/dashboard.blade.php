<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Company Dashboard</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Intern progress stubs</p>
        </div>

        <a
            href="{{ route('company.internships.create') }}"
            class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition-colors"
        >
            Post Internship
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-stats-card title="Active Interns" value="{{ $stats['activeInterns'] }}" icon="users" color="green" />
        <x-stats-card title="Open Roles" value="{{ $stats['openRoles'] }}" icon="briefcase" color="blue" />
        <x-stats-card title="New Applicants" value="{{ $stats['newApplicants'] }}" icon="document" color="purple" />
        <x-stats-card title="Pending Evaluations" value="{{ $stats['pendingEvaluations'] }}" icon="shield-check" color="yellow" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-widget title="Quick Links" :collapsible="true">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <a href="{{ route('company.internships.index') }}" class="px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Internship Management</div>
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">List/edit stub</div>
                </a>
                <a href="{{ route('company.applicants.index') }}" class="px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Applicants</div>
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Accept/reject stub</div>
                </a>
                <a href="{{ route('company.interns.index') }}" class="px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Active Interns</div>
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">List stub</div>
                </a>
                <a href="{{ route('company.tasks.index') }}" class="px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Task Assignment</div>
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Create/list stub</div>
                </a>
            </div>
        </x-widget>

        <x-widget title="Intern Progress" :collapsible="true">
            <div class="space-y-4">
                @foreach($internProgress as $intern)
                    <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $intern['name'] }}</div>
                                <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $intern['role'] }}</div>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $intern['status'] }}</div>
                        </div>

                        <div class="mt-3">
                            <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                <div>Progress</div>
                                <div>{{ $intern['progress'] }}%</div>
                            </div>
                            <div class="mt-2 h-2 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                                <div class="h-2 bg-indigo-600 rounded-full" style="width: {{ $intern['progress'] }}%"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-widget>
    </div>

    <x-widget title="Recent Applicants" :collapsible="true">
        <div class="space-y-3">
            @foreach($recentApplicants as $applicant)
                <div class="p-3 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $applicant['name'] }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $applicant['time'] }}</div>
                    </div>
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $applicant['position'] }} • {{ $applicant['stage'] }}</div>
                </div>
            @endforeach
        </div>
    </x-widget>
</div>

