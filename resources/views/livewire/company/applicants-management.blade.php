<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Applicants Management</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">List + accept/reject stub</p>
    </div>

    <x-widget title="Applicants" :collapsible="true">
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-800/40">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Position</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">University</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($applicants as $index => $applicant)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $applicant['name'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $applicant['position'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $applicant['university'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $applicant['status'] }}</td>
                                <td class="px-4 py-3 text-sm text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <button
                                            type="button"
                                            wire:click="accept({{ $index }})"
                                            class="rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700 transition-colors"
                                        >
                                            Accept
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="reject({{ $index }})"
                                            class="rounded-lg bg-rose-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-rose-700 transition-colors"
                                        >
                                            Reject
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No applicants yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </x-widget>
</div>

