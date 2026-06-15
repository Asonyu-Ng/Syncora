@php
    $roleLabel = Auth::user()?->role ? \Illuminate\Support\Str::title(Auth::user()->role) : 'Workspace';
@endphp

<div
    x-data="{
        darkMode: document.documentElement.classList.contains('dark'),
        toggleTheme() {
            this.darkMode = !this.darkMode;
            const root = document.documentElement;
            if (this.darkMode) {
                root.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                root.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        },
    }"
    class="sticky top-0 z-40 border-b border-neutral-200 bg-white/95 backdrop-blur dark:border-neutral-800 dark:bg-neutral-950/80"
>
    <div class="mx-auto w-full max-w-7xl px-3 sm:px-4 lg:px-6">
        <div class="flex flex-col gap-2.5 py-3 lg:flex-row lg:items-center lg:gap-5">
            <div class="order-1 flex min-w-0 flex-1 items-center gap-3">
                <button
                    @click="$dispatch('toggle-sidebar')"
                    class="lg:hidden inline-flex h-10 w-10 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-700 transition-colors hover:bg-neutral-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-200 dark:hover:bg-neutral-900"
                    aria-label="Open sidebar"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div class="min-w-0 flex-1">
                    <div class="min-w-0">
                        <div class="flex min-w-0 items-center gap-2">
                            <p class="truncate text-[1.05rem] font-semibold leading-tight tracking-tight text-neutral-900 sm:text-[1.2rem] dark:text-neutral-50">{{ $pageTitle }}</p>
                        </div>
                        <div class="mt-0.5 hidden min-w-0 items-center gap-2 xl:flex">
                            <nav aria-label="Breadcrumb" class="min-w-0 flex-1">
                                <ol class="flex min-w-0 items-center gap-2 text-[12px] font-medium text-neutral-500 dark:text-neutral-400">
                                    @foreach($breadcrumbs as $index => $crumb)
                                        <li class="min-w-0 flex items-center gap-2">
                                            @if($crumb['href'])
                                                <a href="{{ $crumb['href'] }}" class="truncate transition hover:text-neutral-900 dark:hover:text-neutral-200">
                                                    {{ $crumb['label'] }}
                                                </a>
                                            @else
                                                <span class="truncate text-neutral-500 dark:text-neutral-300">{{ $crumb['label'] }}</span>
                                            @endif
                                            @if($index < count($breadcrumbs) - 1)
                                                <svg class="h-3.5 w-3.5 shrink-0 text-neutral-300 dark:text-neutral-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            @endif
                                        </li>
                                    @endforeach
                                </ol>
                            </nav>
                            <span class="hidden text-neutral-300 dark:text-neutral-700 xl:inline">•</span>
                            <p class="hidden truncate text-[12px] leading-5 text-neutral-500 dark:text-neutral-400 xl:block">{{ $pageSummary }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="order-3 w-full lg:order-2 lg:max-w-sm lg:flex-1">
                <div class="relative">
                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-neutral-400 dark:text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z" />
                    </svg>
                    <input
                        type="search"
                        placeholder="Search dashboard"
                        class="h-10 w-full rounded-xl border border-neutral-200 bg-neutral-50/80 pl-9 pr-3 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:border-neutral-800 dark:bg-neutral-900/60 dark:text-neutral-100 dark:placeholder:text-neutral-500"
                    />
                </div>
            </div>

            <div class="order-2 lg:order-3 flex items-center justify-end">
                <div class="flex items-center gap-2 rounded-2xl border border-neutral-200 bg-neutral-50/80 p-1 dark:border-neutral-800 dark:bg-neutral-900/60">
                    <button
                        type="button"
                        @click="toggleTheme()"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-700 transition-colors hover:bg-neutral-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-200 dark:hover:bg-neutral-900"
                        aria-label="Toggle theme"
                    >
                        <svg x-show="!darkMode" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364l-1.414 1.414M7.05 16.95l-1.414 1.414m12.728 0l-1.414-1.414M7.05 7.05 5.636 5.636M12 8a4 4 0 100 8 4 4 0 000-8z" />
                        </svg>
                        <svg x-show="darkMode" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z" />
                        </svg>
                    </button>
                    <x-dashboard.notifications-dropdown :notifications="$notifications" :unread-count="$notificationCount" />
                    <x-dashboard.profile-dropdown />
                </div>
            </div>
        </div>
    </div>
</div>
