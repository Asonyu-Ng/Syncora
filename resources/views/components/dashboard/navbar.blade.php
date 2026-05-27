<div x-data="{
    notificationsOpen: false,
    userMenuOpen: false
}" @keydown.escape.window="notificationsOpen = false; userMenuOpen = false" class="sticky top-0 z-40 bg-white border-b border-gray-200 shadow-sm">
    <div class="h-16">
        <div class="flex items-center justify-between h-full px-4 sm:px-6 lg:px-8">
            <div class="flex items-center flex-1">
                <nav class="flex items-center space-x-2 text-sm">
                    <a href="/__dashboards" class="flex items-center text-gray-600 hover:text-gray-900 transition-colors duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="ml-1">Dashboards</span>
                    </a>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-gray-900 font-medium">{{ $currentPage }}</span>
                </nav>
            </div>

            <div class="flex items-center space-x-2">
                <div class="relative">
                    <button
                        @click="notificationsOpen = !notificationsOpen; userMenuOpen = false"
                        @click.outside="notificationsOpen = false"
                        class="relative p-2 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors duration-150"
                        aria-label="Notifications"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @if($notificationCount > 0)
                            <span class="absolute top-1 right-1 inline-flex items-center justify-center px-1.5 py-0.5 rounded-full text-xs font-bold leading-none bg-red-500 text-white transform translate-x-1/4 -translate-y-1/4">
                                {{ $notificationCount > 9 ? '9+' : $notificationCount }}
                            </span>
                        @endif
                    </button>

                    <div
                        x-show="notificationsOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-96 bg-white rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 py-2 z-50"
                        style="display: none;"
                    >
                        <div class="px-4 py-2 border-b border-gray-100">
                            <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                        </div>

                        <div class="max-h-96 overflow-y-auto">
                            @forelse($notifications as $notification)
                                <div class="px-4 py-3 hover:bg-gray-50 transition-colors duration-150 border-b border-gray-100 last:border-b-0 {{ !$notification['read'] ? 'bg-blue-50/30' : '' }}">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0 mt-1">
                                            @switch($notification['icon'])
                                                @case('document-text')
                                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    @break
                                                @case('shield-check')
                                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                    </svg>
                                                    @break
                                                @case('check-circle')
                                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    @break
                                                @default
                                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                            @endswitch
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <p class="text-sm font-semibold text-gray-900">{{ $notification['title'] }}</p>
                                                @if(!$notification['read'])
                                                    <span class="inline-block w-2 h-2 bg-blue-500 rounded-full"></span>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-600 mt-0.5">{{ $notification['description'] }}</p>
                                            <p class="text-xs text-gray-400 mt-1">{{ $notification['time'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="px-4 py-8 text-center">
                                    <p class="text-sm text-gray-500">No notifications</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <button
                        @click="userMenuOpen = !userMenuOpen; notificationsOpen = false"
                        @click.outside="userMenuOpen = false"
                        class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 transition-colors duration-150"
                    >
                        <div class="hidden sm:block text-right">
                            <p class="text-sm font-medium text-gray-900">{{ $getUserName() }}</p>
                            <p class="text-xs text-gray-500">{{ Str::limit($getUserEmail(), 20) }}</p>
                        </div>
                        <div class="w-10 h-10 bg-gradient-to-br {{ $getUserAvatarColor() }} rounded-full flex items-center justify-center text-white font-bold text-sm shadow-md">
                            {{ $getUserInitials() }}
                        </div>
                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="userMenuOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div
                        x-show="userMenuOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 py-2 z-50"
                        style="display: none;"
                    >
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-900">{{ $getUserName() }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $getUserEmail() }}</p>
                        </div>

                        @if(Route::has('profile.show'))
                            <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profile
                            </a>
                        @endif

                        @if(Route::has('settings'))
                            <a href="{{ route('settings') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Settings
                            </a>
                        @endif

                        @if(Route::has('logout'))
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-150"
                            >
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Sign Out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

