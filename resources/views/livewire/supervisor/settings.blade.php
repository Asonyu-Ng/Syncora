<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Settings</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Preferences stub</p>
    </div>

    <x-widget title="Notifications" :collapsible="true">
        <div class="space-y-4">
            <label class="flex items-center justify-between gap-3">
                <span class="text-sm text-gray-700 dark:text-gray-200">Email notifications</span>
                <input type="checkbox" wire:model="emailNotifications" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
            </label>
            <label class="flex items-center justify-between gap-3">
                <span class="text-sm text-gray-700 dark:text-gray-200">Weekly summary</span>
                <input type="checkbox" wire:model="weeklySummary" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
            </label>
            <div class="pt-2">
                <button
                    type="button"
                    wire:click="save"
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition-colors"
                >
                    Save (stub)
                </button>
            </div>
        </div>
    </x-widget>
</div>
