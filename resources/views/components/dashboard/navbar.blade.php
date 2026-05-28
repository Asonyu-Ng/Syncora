<div class="sticky top-0 z-40 bg-white border-b border-neutral-200 shadow-soft">
    <div class="h-[72px]">
        <div class="flex items-center justify-between h-full px-4 sm:px-6 lg:px-8">
            <div class="flex items-center flex-1 min-w-0 gap-3">
                <button
                    @click="$dispatch('toggle-sidebar')"
                    class="lg:hidden p-2 rounded-xl bg-white border border-neutral-200 hover:bg-neutral-50 transition-colors"
                    aria-label="Open sidebar"
                >
                    <svg class="w-5 h-5 text-neutral-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <nav class="hidden sm:flex items-center space-x-2 text-sm min-w-0">
                    @foreach($breadcrumbs as $index => $crumb)
                        @php $isLast = $index === count($breadcrumbs) - 1; @endphp
                        @if(!$isLast && !empty($crumb['href']))
                            <a href="{{ $crumb['href'] }}" class="flex items-center text-neutral-600 hover:text-neutral-900 transition-colors">
                                <span class="truncate">{{ $crumb['label'] }}</span>
                            </a>
                            <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        @else
                            <span class="text-neutral-900 font-medium truncate">{{ $crumb['label'] }}</span>
                        @endif
                    @endforeach
                </nav>

                <div class="sm:hidden flex-1 min-w-0">
                    <p class="text-sm font-semibold text-neutral-900 truncate">{{ $pageTitle }}</p>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <x-dashboard.notifications-dropdown :notifications="$notifications" :unread-count="$notificationCount" />
                <x-dashboard.profile-dropdown />
            </div>
        </div>
    </div>
</div>
