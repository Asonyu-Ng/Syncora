<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Verification Requests</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Pending approvals (stub)</p>
    </div>

    <x-widget title="Requests" :collapsible="true">
        <div class="space-y-3">
            @foreach($requests as $index => $request)
                <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                {{ $request['student'] }} · {{ $request['type'] }}
                            </div>
                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Submitted: {{ $request['submitted_at'] }} · Status: {{ $request['status'] }}
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                wire:click="approve({{ $index }})"
                                class="px-3 py-2 text-sm font-medium rounded-lg bg-green-600 hover:bg-green-700 text-white disabled:opacity-50"
                                @disabled($request['status'] !== 'Pending')
                            >
                                Approve
                            </button>
                            <button
                                type="button"
                                wire:click="reject({{ $index }})"
                                class="px-3 py-2 text-sm font-medium rounded-lg bg-red-600 hover:bg-red-700 text-white disabled:opacity-50"
                                @disabled($request['status'] !== 'Pending')
                            >
                                Reject
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-widget>
</div>

