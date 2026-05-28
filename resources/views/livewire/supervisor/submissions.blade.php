<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Recent Submissions</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Latest items submitted by interns (stub)</p>
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

