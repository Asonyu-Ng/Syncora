<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Logbook Approval</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Approve/reject stub</p>
    </div>

    <x-widget title="Pending Logbooks" :collapsible="true">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                <thead class="bg-gray-50 dark:bg-gray-900/40">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Student</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Week</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Hours</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($logbooks as $index => $logbook)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 font-medium">{{ $logbook['student'] }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $logbook['week'] }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $logbook['hours'] }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $logbook['status'] }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <button
                                    type="button"
                                    wire:click="approve({{ $index }})"
                                    class="inline-flex items-center rounded-lg bg-green-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-green-700 transition-colors"
                                >
                                    Approve
                                </button>
                                <button
                                    type="button"
                                    wire:click="reject({{ $index }})"
                                    class="inline-flex items-center rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-700 transition-colors"
                                >
                                    Reject
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                No logbooks pending.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-widget>
</div>
