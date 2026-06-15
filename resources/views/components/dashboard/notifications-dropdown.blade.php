@props([
    'notifications' => [],
    'unreadCount' => 0,
])

<div x-data="{ open: false }" @keydown.escape.window="open = false" class="relative">
    <button
        @click="open = !open"
        @click.outside="open = false"
        class="relative inline-flex h-10 w-10 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-700 transition-colors hover:bg-neutral-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-200 dark:hover:bg-neutral-900"
        aria-label="Notifications"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-primary-600 px-1.5 text-[11px] font-semibold leading-none text-white">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-96 max-w-[calc(100vw-2rem)] bg-white rounded-xl shadow-card ring-1 ring-neutral-900/10 py-2 z-50 dark:bg-neutral-950 dark:ring-neutral-100/10"
        style="display: none;"
    >
        <div class="px-4 py-2 border-b border-neutral-200 flex items-center justify-between dark:border-neutral-800">
            <h3 class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">Notifications</h3>
            <button
                type="button"
                class="text-xs font-medium text-neutral-600 hover:text-neutral-900 focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:text-neutral-400 dark:hover:text-neutral-100"
            >
                Mark all read
            </button>
        </div>

        <div class="max-h-96 overflow-y-auto">
            @forelse($notifications as $notification)
                <div class="px-4 py-3 hover:bg-neutral-50 transition-colors border-b border-neutral-100 last:border-b-0 dark:border-neutral-900 dark:hover:bg-neutral-900/60 {{ empty($notification['read']) ? 'bg-primary-50/60 dark:bg-primary-500/10' : '' }}">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 mt-1">
                            @switch($notification['icon'] ?? null)
                                @case('document-text')
                                    <svg class="w-5 h-5 text-primary-600 dark:text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    @break
                                @case('shield-check')
                                    <svg class="w-5 h-5 text-primary-600 dark:text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    @break
                                @case('check-circle')
                                    <svg class="w-5 h-5 text-primary-600 dark:text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    @break
                                @default
                                    <svg class="w-5 h-5 text-neutral-500 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                            @endswitch
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-3">
                                <p class="text-sm font-semibold text-neutral-900 truncate dark:text-neutral-50">{{ $notification['title'] ?? 'Notification' }}</p>
                                @if(empty($notification['read']))
                                    <span class="inline-block w-2 h-2 bg-primary-600 rounded-full dark:bg-primary-400"></span>
                                @endif
                            </div>
                            @if(!empty($notification['description']))
                                <p class="text-sm text-neutral-600 mt-0.5 dark:text-neutral-300">{{ $notification['description'] }}</p>
                            @endif
                            @if(!empty($notification['time']))
                                <p class="text-xs text-neutral-400 mt-1 dark:text-neutral-500">{{ $notification['time'] }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-4 py-8 text-center">
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">No notifications</p>
                </div>
            @endforelse
        </div>

        <div class="px-4 py-2 border-t border-neutral-200 dark:border-neutral-800">
            <a href="#" class="text-sm font-medium text-neutral-700 hover:text-neutral-900 focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:text-neutral-200 dark:hover:text-neutral-50">
                View all
            </a>
        </div>
    </div>
</div>
