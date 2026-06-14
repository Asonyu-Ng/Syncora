<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div class="min-w-0">
            <h1 class="text-2xl font-semibold text-neutral-900 sm:text-3xl">Monitor Students</h1>
            <p class="mt-2 text-sm text-neutral-600">Track engagement, logbooks, and task progress across supervised internships.</p>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
            <button
                type="button"
                wire:click="export"
                class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25"
            >
                <svg class="h-4 w-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m0 0l3-3m-3 3l-3-3m9 9H6a2 2 0 01-2-2v-3m16 3v-3a2 2 0 00-2-2" />
                </svg>
                Export Report
            </button>
        </div>
    </div>

    @if(session('message'))
        <div class="rounded-2xl border border-primary-100 bg-primary-50 px-5 py-4 text-sm font-semibold text-primary-800">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-neutral-600">Active Students</p>
                    <p class="mt-3 text-3xl font-semibold text-neutral-900">{{ $summary['active'] ?? 0 }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-success-50 text-success-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 .667 1.333 2 2 2m8-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-sm text-neutral-600">Activity in the last 7 days</p>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-neutral-600">Inactive</p>
                    <p class="mt-3 text-3xl font-semibold text-neutral-900">{{ $summary['inactive'] ?? 0 }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-warning-50 text-warning-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-sm text-neutral-600">No updates for 7+ days</p>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-neutral-600">Not Active</p>
                    <p class="mt-3 text-3xl font-semibold text-neutral-900">{{ $summary['not_active'] ?? 0 }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-danger-50 text-danger-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-sm text-neutral-600">No updates for 15+ days</p>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-neutral-600">Logbooks This Week</p>
                    <p class="mt-3 text-3xl font-semibold text-neutral-900">{{ $summary['logbooks_this_week'] ?? 0 }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-primary-50 text-primary-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 6H7a2 2 0 01-2-2V4a2 2 0 012-2h7l5 5v13a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-sm text-neutral-600">Entries submitted in the current week</p>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-neutral-600">Tasks Completed</p>
                    <p class="mt-3 text-3xl font-semibold text-neutral-900">{{ $summary['tasks_completed_this_week'] ?? 0 }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-secondary-50 text-secondary-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-sm text-neutral-600">Completed tasks in the current week</p>
        </div>
    </div>

    <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
        <div class="relative w-full lg:max-w-md">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-neutral-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search students, internships, companies..."
                class="h-12 w-full rounded-2xl border border-neutral-200 bg-white pl-10 pr-4 text-sm font-semibold text-neutral-900 shadow-soft placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
            />
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center sm:justify-end">
            <select
                wire:model.live="internship"
                class="h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 sm:w-56"
            >
                <option value="">All Internships</option>
                @foreach($internships as $internship)
                    <option value="{{ $internship->id }}">{{ $internship->title }}</option>
                @endforeach
            </select>

            <select
                wire:model.live="company"
                class="h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 sm:w-52"
            >
                <option value="">All Companies</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>

            <select
                wire:model.live="status"
                class="h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 sm:w-52"
            >
                <option value="">Status: Any</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive (7+ days)</option>
                <option value="not_active">Not Active (15+ days)</option>
            </select>

            <select
                wire:model.live="perPage"
                class="h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 sm:w-40"
            >
                <option value="10">10 / page</option>
                <option value="25">25 / page</option>
                <option value="50">50 / page</option>
            </select>
        </div>
    </div>

    <div class="rounded-2xl border border-neutral-200 bg-white shadow-card">
        <div class="flex items-start justify-between gap-3 px-5 py-5 sm:px-6">
            <div class="min-w-0">
                <h2 class="text-sm font-semibold text-neutral-900">Students</h2>
                <p class="mt-1 text-sm text-neutral-600">Engagement and progress overview for each supervised intern.</p>
            </div>
        </div>

        <div class="overflow-hidden border-t border-neutral-200">
            <div class="grid grid-cols-12 gap-3 bg-neutral-50 px-5 py-3 text-xs font-semibold uppercase tracking-wide text-neutral-500 sm:px-6">
                <div class="col-span-3">Student</div>
                <div class="col-span-2">Internship</div>
                <div class="col-span-2">Status</div>
                <div class="col-span-2">Last Active</div>
                <div class="col-span-3">Progress</div>
            </div>

            <div class="divide-y divide-neutral-200">
                @forelse($rows as $row)
                    <div class="grid grid-cols-12 items-start gap-3 px-5 py-4 sm:px-6">
                        <div class="col-span-3 flex items-start gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-neutral-900 text-sm font-semibold text-white">
                                {{ $row['student_initial'] }}
                            </div>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-neutral-900">{{ $row['student_name'] }}</p>
                                <p class="mt-1 truncate text-xs font-semibold text-neutral-500">{{ $row['student_email'] }}</p>
                                <p class="mt-2 text-xs font-semibold text-neutral-600 line-clamp-2">{{ $row['activity_summary'] }}</p>
                            </div>
                        </div>

                        <div class="col-span-2 min-w-0">
                            <p class="truncate text-sm font-semibold text-neutral-900">{{ $row['internship_title'] }}</p>
                            <p class="mt-1 truncate text-xs font-semibold text-neutral-500">{{ $row['company_name'] }}</p>
                        </div>

                        <div class="col-span-2">
                            <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold ring-1 ring-inset {{ $row['status_class'] }}">{{ $row['status_label'] }}</span>
                        </div>

                        <div class="col-span-2">
                            <p class="text-sm font-semibold text-neutral-900">{{ $row['last_active_label'] }}</p>
                        </div>

                        <div class="col-span-3 space-y-4">
                            <div>
                                <div class="flex items-center justify-between gap-3 text-xs font-semibold text-neutral-600">
                                    <span>Logbooks ({{ $row['logbooks_week'] }}/5)</span>
                                    <span class="text-neutral-900">{{ $row['logbooks_week_percent'] }}%</span>
                                </div>
                                <div class="mt-2 h-2 w-full rounded-full bg-neutral-100">
                                    <div class="h-2 rounded-full bg-primary-600" style="width: {{ $row['logbooks_week_percent'] }}%"></div>
                                </div>
                                <div class="mt-2 text-xs font-semibold text-neutral-500">{{ $row['logbooks_total'] }} total • {{ $row['logbooks_approved'] }} approved</div>
                            </div>

                            <div>
                                <div class="flex items-center justify-between gap-3 text-xs font-semibold text-neutral-600">
                                    <span>Tasks ({{ $row['tasks_completed'] }}/{{ $row['tasks_total'] }})</span>
                                    <span class="text-neutral-900">{{ $row['tasks_percent'] }}%</span>
                                </div>
                                <div class="mt-2 h-2 w-full rounded-full bg-neutral-100">
                                    <div class="h-2 rounded-full bg-success-600" style="width: {{ $row['tasks_percent'] }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-10 text-center text-sm font-semibold text-neutral-600">No students found.</div>
                @endforelse
            </div>
        </div>

        <div class="border-t border-neutral-200 px-5 py-4 sm:px-6">
            {{ $rows->links() }}
        </div>
    </div>
</div>
