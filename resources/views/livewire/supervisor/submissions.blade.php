<div class="space-y-6">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Submission review
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950">Track the latest student submissions in one review feed.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">
                    Scan recently submitted work, review the latest context quickly, and decide what needs feedback or formal follow-up next.
                </p>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Review load</div>
                <div class="mt-4 rounded-2xl border border-neutral-200 bg-white px-4 py-4">
                    <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ count($submissions) }}</div>
                    <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Recent submissions</div>
                    <p class="mt-3 text-sm leading-6 text-neutral-600">Use this stream as a fast triage surface before moving into deeper workflow review pages.</p>
                </div>
            </div>
        </div>
    </div>

    <x-widget title="Submissions" :collapsible="true">
        <div class="space-y-3">
            @foreach($submissions as $submission)
                <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                {{ $submission['student'] }} · {{ $submission['type'] }}
                            </div>
                            <div class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ $submission['detail'] }}</div>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $submission['submitted_at'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-widget>
</div>
