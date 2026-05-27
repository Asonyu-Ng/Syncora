<div x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false" class="relative min-h-screen">
    <button
        @click="sidebarOpen = !sidebarOpen"
        class="fixed top-4 left-4 z-50 lg:hidden p-2 rounded-lg bg-white shadow-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200"
        aria-label="Toggle sidebar"
    >
        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <div
        x-show="sidebarOpen"
        x-transition:enter="transition-opacity ease-in-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in-out duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden"
        style="display: none;"
    ></div>

    <aside
        x-show="sidebarOpen || window.innerWidth >= 1024"
        x-transition:enter="transform transition ease-in-out duration-200"
        x-transition:enter-start="-translate-x-full lg:translate-x-0"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full lg:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed lg:sticky top-0 left-0 h-screen w-64 bg-white border-r border-gray-200 shadow-lg flex flex-col z-40"
        style="display: none;"
    >
        <div class="flex flex-col h-full">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Syncora</h1>
                        <p class="text-xs text-gray-500">Internship Management</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto py-4 px-3">
                <div class="space-y-1">
                    @foreach($navigationItems as $item)
                        <a
                            href="{{ $item['href'] }}"
                            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                                {{ $item['active']
                                    ? 'bg-gray-900 text-white shadow-md'
                                    : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}"
                        >
                            @switch($item['icon'])
                                @case('home')
                                    <svg class="mr-3 h-5 w-5 {{ $item['active'] ? 'text-white' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    @break
                                @default
                                    <svg class="mr-3 h-5 w-5 {{ $item['active'] ? 'text-white' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                            @endswitch
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </nav>

            <div class="border-t border-gray-200 p-4 bg-gray-50">
                <div class="flex items-center space-x-3 p-2 rounded-xl">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center text-white font-semibold text-sm">
                        {{ substr(Auth::user()?->name ?? 'U', 0, 2) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            {{ Auth::user()?->name ?? 'User' }}
                        </p>
                        <p class="text-xs text-gray-500 truncate">
                            {{ Auth::user()?->email ?? 'user@example.com' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>
