<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Users Management</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">List/create/edit stubs</p>
    </div>

    <x-widget title="Users" :collapsible="true">
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-800/40">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Role</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($users as $index => $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 font-medium">{{ $user['name'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $user['email'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $user['role'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $user['status'] }}</td>
                                <td class="px-4 py-3 text-sm text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <button
                                            type="button"
                                            wire:click="activate({{ $index }})"
                                            class="rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700 transition-colors"
                                        >
                                            Activate
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="suspend({{ $index }})"
                                            class="rounded-lg bg-rose-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-rose-700 transition-colors"
                                        >
                                            Suspend
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-sm text-gray-500 dark:text-gray-400">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </x-widget>
</div>
