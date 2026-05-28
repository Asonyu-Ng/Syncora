<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Reports Management</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">List stub</p>
    </div>

    <x-widget title="Reports" :collapsible="true">
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-800/40">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Report</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Generated</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($reports as $index => $report)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 font-medium">{{ $report['name'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $report['type'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $report['generated'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $report['status'] }}</td>
                                <td class="px-4 py-3 text-sm text-right">
                                    <button
                                        type="button"
                                        wire:click="regenerate({{ $index }})"
                                        class="rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-indigo-700 transition-colors"
                                    >
                                        Regenerate
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-sm text-gray-500 dark:text-gray-400">No reports found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </x-widget>
</div>
