<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Logbook Submission</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Create/list stub</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <x-widget title="New Entry">
                <div class="space-y-3">
                    <input
                        type="date"
                        wire:model.defer="date"
                        class="w-full rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    />
                    <input
                        type="number"
                        min="1"
                        wire:model.defer="hours"
                        placeholder="Hours"
                        class="w-full rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    />
                    <textarea
                        wire:model.defer="notes"
                        rows="4"
                        placeholder="Notes"
                        class="w-full rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    ></textarea>
                    <button
                        type="button"
                        wire:click="submit"
                        class="w-full rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition-colors"
                    >
                        Submit
                    </button>
                </div>
            </x-widget>
        </div>

        <div class="lg:col-span-2">
            <x-widget title="Entries" :collapsible="true">
                <x-dashboard.table
                    :columns="[
                        ['label' => 'Date', 'key' => 'date'],
                        ['label' => 'Hours', 'key' => 'hours'],
                        ['label' => 'Notes', 'key' => 'notes'],
                    ]"
                    :rows="$entries"
                    emptyMessage="No logbook entries yet."
                />
            </x-widget>
        </div>
    </div>
</div>

