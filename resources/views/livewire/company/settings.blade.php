<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Company Settings</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Placeholder</p>
    </div>

    <x-widget title="Notifications" :collapsible="true">
        <div class="space-y-4">
            <label class="flex items-center gap-3">
                <input
                    type="checkbox"
                    wire:model="emailNotifications"
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                />
                <span class="text-sm text-gray-700 dark:text-gray-200">Email notifications</span>
            </label>

            <label class="flex items-center gap-3">
                <input
                    type="checkbox"
                    wire:model="weeklyDigest"
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                />
                <span class="text-sm text-gray-700 dark:text-gray-200">Weekly digest</span>
            </label>

            <button
                type="button"
                wire:click="save"
                class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition-colors"
            >
                Save (stub)
            </button>
        </div>
    </x-widget>
</div>

