<div class="space-y-8">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Company dashboard
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950">Run internship hiring and follow-up from one operational view.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">
                    Track open roles, applicant activity, and intern progress while keeping the next company actions visible at the top of the workspace.
                </p>
            </div>

            <div class="flex flex-col justify-between gap-4 rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <div>
                    <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Hiring focus</div>
                    <p class="mt-2 text-sm leading-6 text-neutral-600">Use this dashboard as the first stop for posting roles, reviewing applicants, and checking intern delivery signals.</p>
                </div>
                <a
                    href="{{ route('company.internships.create') }}"
                    class="inline-flex h-11 items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500"
                >
                    Post internship
                </a>
            </div>
        </div>
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
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Review published roles and track response volume</div>
                </a>
                <a href="{{ route('company.applicants.index') }}" class="px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Applicants</div>
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Review candidates and move decisions forward</div>
                </a>
                <a href="{{ route('company.interns.index') }}" class="px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Active Interns</div>
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Monitor current placements and progress</div>
                </a>
                <a href="{{ route('company.tasks.index') }}" class="px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Task Assignment</div>
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Review submissions and give feedback</div>
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
