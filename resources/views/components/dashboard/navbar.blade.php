<div class="sticky top-0 z-40 bg-white border-b border-neutral-200 shadow-soft">
    <div class="mx-auto w-full max-w-7xl px-3 sm:px-4 lg:px-6">
        <div class="flex flex-col gap-3 py-3 sm:flex-row sm:items-center sm:gap-4 sm:h-[72px] sm:py-0">
            <div class="order-1 sm:order-none flex items-center gap-3 min-w-0 flex-1">
                <button
                    @click="$dispatch('toggle-sidebar')"
                    class="lg:hidden inline-flex h-10 w-10 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-700 hover:bg-neutral-50 transition-colors"
                    aria-label="Open sidebar"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div class="min-w-0 flex-1">
                    <nav class="hidden sm:flex items-center gap-2 text-sm min-w-0">
                        @foreach($breadcrumbs as $index => $crumb)
                            @php $isLast = $index === count($breadcrumbs) - 1; @endphp
                            @if(!$isLast && !empty($crumb['href']))
                                <a href="{{ $crumb['href'] }}" class="flex items-center text-neutral-500 hover:text-neutral-900 transition-colors min-w-0">
                                    <span class="truncate">{{ $crumb['label'] }}</span>
                                </a>
                                <svg class="w-4 h-4 text-neutral-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            @else
                                <span class="text-neutral-900 font-semibold truncate">{{ $crumb['label'] }}</span>
                            @endif
                        @endforeach
                    </nav>

                    <p class="sm:hidden text-sm font-semibold text-neutral-900 truncate">{{ $pageTitle }}</p>
                </div>
            </div>

            <div class="order-3 sm:order-none w-full sm:max-w-md sm:flex-1">
                <div class="relative">
                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z" />
                    </svg>
                    <input
                        type="search"
                        placeholder="Search..."
                        class="h-10 w-full rounded-xl border border-neutral-200 bg-neutral-50 pl-9 pr-3 text-sm text-neutral-900 shadow-soft placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                    />
                </div>
            </div>

            <div class="order-2 sm:order-none flex items-center gap-2 shrink-0">
                <x-dashboard.notifications-dropdown :notifications="$notifications" :unread-count="$notificationCount" />
                <x-dashboard.profile-dropdown />
            </div>
        </div>
    </div>
</div>
