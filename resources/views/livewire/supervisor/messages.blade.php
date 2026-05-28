<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Messages</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Conversation threads (stub)</p>
    </div>

    <x-widget title="Threads" :collapsible="true">
        <div class="space-y-3">
            @foreach($threads as $index => $thread)
                <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $thread['student'] }}</div>
                                @if($thread['unread'])
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-200">Unread</span>
                                @endif
                            </div>
                            <div class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ $thread['preview'] }}</div>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            <div class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $thread['time'] }}</div>
                            <button
                                type="button"
                                wire:click="markAsRead({{ $index }})"
                                class="px-3 py-2 text-sm font-medium rounded-lg bg-gray-900 hover:bg-gray-800 text-white disabled:opacity-50"
                                @disabled(!$thread['unread'])
                            >
                                Mark read
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-widget>
</div>

