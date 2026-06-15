@php
    $detailStats = [
        ['label' => 'Company', 'value' => $details['company']],
        ['label' => 'Location', 'value' => $details['city']],
        ['label' => 'Work mode', 'value' => $details['type']],
        ['label' => 'Duration', 'value' => $details['duration']],
    ];
@endphp

<div class="space-y-8">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card dark:border-neutral-800 dark:from-neutral-950 dark:via-neutral-950 dark:to-primary-500/10">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
            <div class="min-w-0">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft dark:border-primary-500/20 dark:bg-neutral-950 dark:text-primary-200">
                        Internship details
                    </span>
                    <span class="inline-flex items-center rounded-full bg-success-50 px-3 py-1 text-xs font-semibold text-success-700 ring-1 ring-inset ring-success-100 dark:bg-success-500/10 dark:text-success-200 dark:ring-success-500/20">
                        Application-ready view
                    </span>
                </div>

                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950 sm:text-[2.1rem] dark:text-neutral-50">{{ $details['title'] }}</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600 dark:text-neutral-300">
                    Review the placement context, role expectations, and requirements before deciding whether this opportunity fits your current internship goals.
                </p>

                <div class="mt-5 flex flex-wrap gap-2">
                    @foreach ($detailStats as $stat)
                        <span class="inline-flex items-center rounded-full border border-neutral-200 bg-white px-3 py-2 text-xs font-semibold text-neutral-600 shadow-soft dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-300">
                            {{ $stat['label'] }}: <span class="ml-1 text-neutral-900 dark:text-neutral-50">{{ $stat['value'] }}</span>
                        </span>
                    @endforeach
                </div>

                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                    <button type="button" class="inline-flex h-11 items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/25">
                        Save and prepare application
                    </button>
                    <a
                        href="{{ route('student.internships.search') }}"
                        class="inline-flex h-11 items-center justify-center rounded-xl border border-neutral-200 bg-white px-5 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-200 dark:hover:bg-neutral-900"
                    >
                        Back to search
                    </a>
                </div>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft dark:border-neutral-800 dark:bg-neutral-950/80">
                <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500 dark:text-neutral-400">Opportunity snapshot</p>
                <div class="mt-4 space-y-3">
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3 dark:border-neutral-800 dark:bg-neutral-950">
                        <div class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">Best for students who want</div>
                        <p class="mt-1 text-sm leading-6 text-neutral-600 dark:text-neutral-300">A placement with clear expectations, visible requirements, and enough context to compare it confidently with other roles.</p>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3 dark:border-neutral-800 dark:bg-neutral-950">
                        <div class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">Before applying</div>
                        <p class="mt-1 text-sm leading-6 text-neutral-600 dark:text-neutral-300">Review the requirements below, compare the duration with your current availability, and keep your profile ready for submission.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <div class="space-y-6 lg:col-span-8">
            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6 dark:border-neutral-800 dark:bg-neutral-950">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">Role Overview</h2>
                        <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-300">A concise view of what the placement is about and what you may work on.</p>
                    </div>
                </div>
                <p class="mt-5 text-sm leading-7 text-neutral-700 dark:text-neutral-200">{{ $details['description'] }}</p>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6 dark:border-neutral-800 dark:bg-neutral-950">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">Requirements</h2>
                        <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-300">Use these criteria to decide if the role matches your current readiness.</p>
                    </div>
                </div>

                <div class="mt-5 grid gap-3">
                    @foreach($details['requirements'] as $req)
                        <div class="flex items-start gap-3 rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-3 dark:border-neutral-800 dark:bg-neutral-900/60">
                            <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-primary-600 text-white">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            <p class="text-sm leading-6 text-neutral-700 dark:text-neutral-200">{{ $req }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <aside class="space-y-6 lg:col-span-4 lg:sticky lg:top-24 lg:self-start">
            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6 dark:border-neutral-800 dark:bg-neutral-950">
                <h2 class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">Placement Meta</h2>
                <div class="mt-4 space-y-3 text-sm">
                    <div class="flex items-center justify-between gap-4 rounded-xl border border-neutral-200 bg-neutral-50 px-4 py-3 dark:border-neutral-800 dark:bg-neutral-900/60">
                        <span class="font-medium text-neutral-500 dark:text-neutral-400">Internship ID</span>
                        <span class="font-semibold text-neutral-900 dark:text-neutral-50">{{ $details['id'] }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-4 rounded-xl border border-neutral-200 bg-neutral-50 px-4 py-3 dark:border-neutral-800 dark:bg-neutral-900/60">
                        <span class="font-medium text-neutral-500 dark:text-neutral-400">Duration</span>
                        <span class="font-semibold text-neutral-900 dark:text-neutral-50">{{ $details['duration'] }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-4 rounded-xl border border-neutral-200 bg-neutral-50 px-4 py-3 dark:border-neutral-800 dark:bg-neutral-900/60">
                        <span class="font-medium text-neutral-500 dark:text-neutral-400">Location</span>
                        <span class="font-semibold text-neutral-900 dark:text-neutral-50">{{ $details['city'] }}</span>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6 dark:border-neutral-800 dark:bg-neutral-950">
                <h2 class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">Next Steps</h2>
                <div class="mt-4 space-y-2">
                    <button type="button" class="inline-flex h-11 w-full items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/25">
                        Save and prepare application
                    </button>
                    <a href="{{ route('student.applications.index') }}" class="inline-flex h-11 w-full items-center justify-center rounded-xl border border-neutral-200 bg-white px-5 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-200 dark:hover:bg-neutral-900">
                        View applications
                    </a>
                </div>
                <p class="mt-4 text-sm leading-6 text-neutral-600 dark:text-neutral-300">
                    This screen now presents the placement as a realistic review surface, even before a fully wired application action is introduced.
                </p>
            </div>
        </aside>
    </div>
</div>
