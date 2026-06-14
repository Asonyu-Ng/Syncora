@php
    $roleLabel = Auth::user()?->role ? \Illuminate\Support\Str::title(Auth::user()->role) : 'Workspace';
@endphp

<div class="sticky top-0 z-40 border-b border-neutral-200 bg-white/95 backdrop-blur">
    <div class="mx-auto w-full max-w-7xl px-3 sm:px-4 lg:px-6">
        <div class="flex flex-col gap-3 py-3 lg:flex-row lg:items-center lg:gap-6">
            <div class="order-1 flex min-w-0 flex-1 items-center gap-3">
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
                    <div class="min-w-0">
                        <div class="flex min-w-0 items-center gap-2">
                            <p class="truncate text-lg font-semibold leading-tight text-neutral-900 sm:text-xl">{{ $pageTitle }}</p>
                        </div>
                        <p class="mt-0.5 hidden truncate text-xs text-neutral-500 xl:block">{{ $pageSummary }}</p>
                    </div>
                </div>
            </div>

            <div class="order-3 w-full lg:order-2 lg:max-w-sm lg:flex-1">
                <div class="relative">
                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z" />
                    </svg>
                    <input
                        type="search"
                        placeholder="Search dashboard"
                        class="h-10 w-full rounded-xl border border-neutral-200 bg-neutral-50 pl-9 pr-3 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                    />
                </div>
            </div>

            <div class="order-2 lg:order-3 flex items-center justify-end">
                <div class="flex items-center gap-2 rounded-2xl border border-neutral-200 bg-neutral-50 p-1">
                    <x-dashboard.notifications-dropdown :notifications="$notifications" :unread-count="$notificationCount" />
                    <x-dashboard.profile-dropdown />
                </div>
            </div>
        </div>
    </div>
</div>
