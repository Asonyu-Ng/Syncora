<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Profile</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Reuse existing profile where applicable</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <x-widget title="Profile Summary" :collapsible="true">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-300">Name</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $user['name'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-300">Email</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $user['email'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-300">Role</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $user['role'] }}</span>
                    </div>
                </div>
            </x-widget>
        </div>

        <div class="space-y-6">
            <x-widget title="Actions">
                <div class="space-y-3">
                    <a
                        href="{{ route('profile.edit') }}"
                        class="w-full inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition-colors"
                    >
                        Edit profile (existing)
                    </a>
                    <a
                        href="{{ route('student.settings') }}"
                        class="w-full inline-flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-4 py-2 text-sm font-semibold text-gray-900 dark:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors"
                    >
                        Settings
                    </a>
                </div>
            </x-widget>
        </div>
    </div>
</div>

