<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Student Evaluation</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Create/list stub</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <x-widget title="New Evaluation">
                <div class="space-y-3">
                    <input
                        type="text"
                        wire:model.defer="studentName"
                        placeholder="Student name"
                        class="w-full rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    />
                    <input
                        type="text"
                        wire:model.defer="score"
                        placeholder="Score (e.g. 8/10)"
                        class="w-full rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    />
                    <textarea
                        wire:model.defer="notes"
                        rows="3"
                        placeholder="Notes (optional)"
                        class="w-full rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    ></textarea>
                    <button
                        type="button"
                        wire:click="submit"
                        class="w-full rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition-colors"
                    >
                        Submit (stub)
                    </button>
                </div>
            </x-widget>
        </div>

        <div class="lg:col-span-2">
            <x-widget title="Evaluations" :collapsible="true">
                <x-dashboard.table
                    :columns="[
                        ['label' => 'Student', 'key' => 'student'],
                        ['label' => 'Score', 'key' => 'score'],
                        ['label' => 'Date', 'key' => 'date'],
                        ['label' => 'Status', 'key' => 'status'],
                    ]"
                    :rows="$evaluations"
                    emptyMessage="No evaluations yet."
                />
            </x-widget>
        </div>
    </div>
</div>
