<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">AI Report Generator</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Placeholder action + service integration stub</p>
    </div>

    <x-widget title="Generate">
        <div class="space-y-3">
            <textarea
                wire:model.defer="prompt"
                rows="4"
                placeholder="Describe what you want in the report..."
                class="w-full rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            ></textarea>
            <div class="flex items-center justify-between gap-3">
                <button
                    type="button"
                    wire:click="generate"
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition-colors"
                >
                    Generate
                </button>
                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $status }}</div>
            </div>
        </div>
    </x-widget>

    <x-widget title="Output" :collapsible="true">
        <pre class="whitespace-pre-wrap text-sm text-gray-800 dark:text-gray-100 bg-gray-50 dark:bg-gray-800/40 border border-gray-200 dark:border-gray-800 rounded-lg p-4">{{ $generated }}</pre>
    </x-widget>
</div>

