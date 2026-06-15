@php
    $unreadThreads = collect($threads)->where('unread', true)->count();
@endphp

<div class="space-y-6">
    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                    Supervisor messages
                </span>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950">Stay on top of intern conversations without losing priority signals.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">
                    Review thread previews, spot unread discussions quickly, and keep communication flowing around task progress and internship issues.
                </p>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">Conversation status</div>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ count($threads) }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Threads</div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white px-4 py-3">
                        <div class="text-2xl font-semibold tracking-tight text-neutral-950">{{ $unreadThreads }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400">Unread</div>
                    </div>
                </div>
            </div>
        </div>
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
