<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Company Profile</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Placeholder</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <x-widget title="Profile Details" :collapsible="true">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <div class="text-xs font-semibold text-gray-600 dark:text-gray-300">Company</div>
                            <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $company['name'] }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-600 dark:text-gray-300">Email</div>
                            <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $company['email'] }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-600 dark:text-gray-300">Website</div>
                            <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $company['website'] }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-600 dark:text-gray-300">Location</div>
                            <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $company['location'] }}</div>
                        </div>
                    </div>

                    <a href="{{ route('company.settings') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                        Go to settings
                    </a>
                </div>
            </x-widget>
        </div>

        <div class="lg:col-span-1">
            <x-widget title="Profile Completion">
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm text-gray-700 dark:text-gray-200">
                        <div>Completion</div>
                        <div class="font-semibold">{{ $company['profileCompletion'] }}%</div>
                    </div>
                    <div class="h-2 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                        <div class="h-2 bg-indigo-600 rounded-full" style="width: {{ $company['profileCompletion'] }}%"></div>
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">This is placeholder data.</div>
                </div>
            </x-widget>
        </div>
    </div>
</div>

