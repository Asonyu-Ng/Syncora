<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">System Settings</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Placeholder</p>
    </div>

    <x-widget title="Settings (stub)" :collapsible="true">
        <div class="divide-y divide-gray-200 dark:divide-gray-800 rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 overflow-hidden">
            @foreach($settings as $setting)
                <div class="flex items-center justify-between gap-4 px-4 py-4">
                    <div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $setting['label'] }}</div>
                        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $setting['key'] }}</div>
                    </div>

                    <button
                        type="button"
                        wire:click="toggle('{{ $setting['key'] }}')"
                        class="inline-flex items-center rounded-lg px-3 py-1.5 text-xs font-semibold transition-colors {{ $setting['value'] ? 'bg-emerald-600 text-white hover:bg-emerald-700' : 'bg-gray-200 text-gray-900 hover:bg-gray-300 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700' }}"
                    >
                        {{ $setting['value'] ? 'On' : 'Off' }}
                    </button>
                </div>
            @endforeach
        </div>
    </x-widget>
</div>
