<div
    x-data="{ collapsed: false }"
    class="overflow-hidden rounded-2xl border border-neutral-200 bg-white shadow-card transition-shadow duration-200 hover:shadow-soft dark:border-neutral-800 dark:bg-neutral-950"
>
    <div
        @if($collapsible)@click="collapsed = !collapsed"@endif
        class="flex items-center justify-between gap-3 border-b border-neutral-200 bg-white px-5 py-4 cursor-{{ $collapsible ? 'pointer' : 'default' }} select-none sm:px-6 dark:border-neutral-800 dark:bg-neutral-950"
    >
        <div class="min-w-0 flex-1">
            <h3 class="truncate text-sm font-semibold text-neutral-900 sm:text-[15px] dark:text-neutral-50">{{ $title }}</h3>
        </div>

        <div class="flex items-center gap-2">
            @if(isset($actions))
                <div class="flex items-center gap-2">
                    {{ $actions }}
                </div>
            @endif

            @if($collapsible)
                <button
                    type="button"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 transition-colors duration-200 hover:bg-neutral-50 hover:text-neutral-700 focus:outline-none focus:ring-4 focus:ring-primary-500/15 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-200"
                    aria-label="Toggle collapse"
                >
                    <svg
                        x-show="!collapsed"
                        class="h-4 w-4 rotate-180 transform transition-transform duration-300"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    <svg
                        x-show="collapsed"
                        class="h-4 w-4 transition-transform duration-300"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            @endif
        </div>
    </div>

    <div
        x-show="!collapsed"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform -translate-y-1"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-1"
        class="p-5 sm:p-6"
    >
        <div class="space-y-4">
            {{ $slot }}
        </div>
    </div>
</div>
