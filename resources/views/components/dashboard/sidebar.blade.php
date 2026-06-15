<div class="relative min-h-screen">
    @php
        $navigationGroups = collect($navigationItems)->groupBy('section');
        $user = Auth::user();
        $roleLabel = $user?->role ? \Illuminate\Support\Str::title($user->role) : 'User';
    @endphp

    <div
        x-show="sidebarOpen"
        x-transition:enter="transition-opacity ease-in-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in-out duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/40 z-30 lg:hidden"
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
        class="fixed lg:sticky top-0 left-0 h-screen w-72 bg-white border-r border-neutral-200 shadow-soft flex flex-col z-40 dark:bg-neutral-950 dark:border-neutral-800"
        style="display: none;"
    >
        <div class="flex flex-col h-full">
            <div class="border-b border-neutral-200 px-6 py-5 dark:border-neutral-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center shadow-soft shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold leading-tight text-neutral-900 dark:text-neutral-50">Syncora</h1>
                        <p class="text-[12px] leading-5 text-neutral-500 dark:text-neutral-400">Internship Management</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto px-4 py-5">
                <div class="space-y-5">
                    @foreach($navigationGroups as $section => $items)
                        <div class="space-y-2">
                            <p class="px-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-neutral-400 dark:text-neutral-500">{{ $section }}</p>

                            <div class="space-y-1">
                                @foreach($items as $item)
                                    <a
                                        href="{{ $item['href'] }}"
                                        class="group relative flex items-center gap-3 rounded-2xl px-3.5 py-2.5 text-sm font-semibold transition-colors duration-150 focus:outline-none focus:ring-4 focus:ring-primary-500/20
                                            {{ $item['active']
                                                ? 'bg-primary-600 text-white shadow-soft'
                                                : 'text-neutral-700 hover:bg-neutral-50 hover:text-neutral-900 dark:text-neutral-200 dark:hover:bg-neutral-900/70 dark:hover:text-neutral-50' }}"
                                    >
                                        @if($item['active'])
                                            <span class="absolute left-0 top-2.5 h-7 w-1 rounded-r-full bg-white/80"></span>
                                        @endif

                                        <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $item['active'] ? 'bg-white/15' : 'bg-neutral-100 group-hover:bg-white dark:bg-neutral-900 dark:group-hover:bg-neutral-950' }}">
                                            @switch($item['icon'])
                                                @case('home')
                                                    <svg class="h-5 w-5 shrink-0 {{ $item['active'] ? 'text-white' : 'text-neutral-500 group-hover:text-neutral-700 dark:text-neutral-400 dark:group-hover:text-neutral-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                                    </svg>
                                                    @break
                                                @case('briefcase')
                                                    <svg class="h-5 w-5 shrink-0 {{ $item['active'] ? 'text-white' : 'text-neutral-500 group-hover:text-neutral-700 dark:text-neutral-400 dark:group-hover:text-neutral-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6a2 2 0 114 0v2h-4V6zM4 8h16v10a2 2 0 01-2 2H6a2 2 0 01-2-2V8z"/>
                                                    </svg>
                                                    @break
                                                @case('document')
                                                    <svg class="h-5 w-5 shrink-0 {{ $item['active'] ? 'text-white' : 'text-neutral-500 group-hover:text-neutral-700 dark:text-neutral-400 dark:group-hover:text-neutral-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 11h10M7 15h7M5 4h10l4 4v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                                                    </svg>
                                                    @break
                                                @case('check-circle')
                                                    <svg class="h-5 w-5 shrink-0 {{ $item['active'] ? 'text-white' : 'text-neutral-500 group-hover:text-neutral-700 dark:text-neutral-400 dark:group-hover:text-neutral-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    @break
                                                @case('clock')
                                                    <svg class="h-5 w-5 shrink-0 {{ $item['active'] ? 'text-white' : 'text-neutral-500 group-hover:text-neutral-700 dark:text-neutral-400 dark:group-hover:text-neutral-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    @break
                                                @case('chart-bar')
                                                    <svg class="h-5 w-5 shrink-0 {{ $item['active'] ? 'text-white' : 'text-neutral-500 group-hover:text-neutral-700 dark:text-neutral-400 dark:group-hover:text-neutral-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6m4 6V7m4 10v-4M4 19h16"/>
                                                    </svg>
                                                    @break
                                                @case('user')
                                                    <svg class="h-5 w-5 shrink-0 {{ $item['active'] ? 'text-white' : 'text-neutral-500 group-hover:text-neutral-700 dark:text-neutral-400 dark:group-hover:text-neutral-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 14a4 4 0 10-8 0m8 0a4 4 0 11-8 0m8 0v1a7 7 0 01-14 0v-1"/>
                                                    </svg>
                                                    @break
                                                @case('users')
                                                    <svg class="h-5 w-5 shrink-0 {{ $item['active'] ? 'text-white' : 'text-neutral-500 group-hover:text-neutral-700 dark:text-neutral-400 dark:group-hover:text-neutral-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-1a4 4 0 00-5-3.87M17 20H7m10 0v-1c0-1.33-.53-2.6-1.46-3.54M7 20H2v-1a4 4 0 015-3.87M7 20v-1c0-1.33.53-2.6 1.46-3.54m0 0a5 5 0 017.08 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 2a2 2 0 11-4 0 2 2 0 014 0zM7 9a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                    </svg>
                                                    @break
                                                @case('cog')
                                                    <svg class="h-5 w-5 shrink-0 {{ $item['active'] ? 'text-white' : 'text-neutral-500 group-hover:text-neutral-700 dark:text-neutral-400 dark:group-hover:text-neutral-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.983 13.987a2.004 2.004 0 100-4.008 2.004 2.004 0 000 4.008z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.4 15a7.963 7.963 0 00.054-2l2.06-1.6-2-3.464-2.48 1a7.978 7.978 0 00-1.73-1l-.38-2.65H9.08l-.38 2.65a7.978 7.978 0 00-1.73 1l-2.48-1-2 3.464 2.06 1.6a7.963 7.963 0 000 2l-2.06 1.6 2 3.464 2.48-1c.54.4 1.12.74 1.73 1l.38 2.65h5.84l.38-2.65c.61-.26 1.19-.6 1.73-1l2.48 1 2-3.464L19.4 15z"/>
                                                    </svg>
                                                    @break
                                                @default
                                                    <svg class="h-5 w-5 shrink-0 {{ $item['active'] ? 'text-white' : 'text-neutral-500 group-hover:text-neutral-700 dark:text-neutral-400 dark:group-hover:text-neutral-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                                    </svg>
                                            @endswitch
                                        </span>

                                        <span class="min-w-0 flex-1 truncate">{{ $item['label'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </nav>

            <div class="border-t border-neutral-200 p-4 dark:border-neutral-800">
                <div class="rounded-2xl border border-neutral-200 bg-neutral-50/80 p-3 dark:border-neutral-800 dark:bg-neutral-900/60">
                    <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary-600 flex items-center justify-center text-white font-semibold text-sm shrink-0">
                        {{ substr(Auth::user()?->name ?? 'U', 0, 2) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-neutral-900 truncate dark:text-neutral-50">
                            {{ Auth::user()?->name ?? 'User' }}
                        </p>
                        <p class="text-[12px] leading-5 font-medium text-neutral-500 truncate dark:text-neutral-400">
                            {{ $roleLabel }}
                        </p>
                        <p class="mt-1 text-[12px] leading-5 text-neutral-400 truncate dark:text-neutral-500">
                            {{ Auth::user()?->email ?? 'user@example.com' }}
                        </p>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </aside>
</div>
