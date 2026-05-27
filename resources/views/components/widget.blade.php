<div
    x-data="{ collapsed: false }"
    class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden transition-shadow duration-300 hover:shadow-lg"
>
    <div
        @if($collapsible)@click="collapsed = !collapsed"@endif
        class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50 cursor-{{ $collapsible ? 'pointer' : 'default' }} select-none"
    >
        <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>

        <div class="flex items-center space-x-3">
            @if(isset($actions))
                <div class="flex items-center space-x-3">
                    {{ $actions }}
                </div>
            @endif

            @if($collapsible)
                <button
                    type="button"
                    class="text-gray-500 hover:text-gray-700 transition-colors duration-200 focus:outline-none"
                    aria-label="Toggle collapse"
                >
                    <svg
                        x-show="!collapsed"
                        class="w-5 h-5 transform rotate-180 transition-transform duration-300"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    <svg
                        x-show="collapsed"
                        class="w-5 h-5 transition-transform duration-300"
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
        class="p-6"
    >
        <div class="space-y-4">
            {{ $slot }}
        </div>
    </div>
</div>

