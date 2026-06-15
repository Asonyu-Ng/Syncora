<nav x-data="{ open: false }" class="border-b border-neutral-200 bg-white/95 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex min-h-[4.5rem] items-center justify-between gap-4">
            <div class="flex items-center gap-8">
                <div class="shrink-0">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-primary-600 text-sm font-semibold text-white shadow-soft">
                            S
                        </span>
                        <span class="min-w-0">
                            <span class="block text-sm font-semibold tracking-tight text-neutral-950">Syncora</span>
                            <span class="block text-xs font-medium text-neutral-500">Account workspace</span>
                        </span>
                    </a>
                </div>

                <div class="hidden sm:flex sm:items-center sm:gap-2">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-3 rounded-2xl border border-neutral-200 bg-neutral-50/80 px-3 py-2 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-white focus:outline-none">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary-600 text-xs font-semibold text-white">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </span>
                            <span class="text-left">
                                <span class="block text-sm font-semibold text-neutral-900">{{ Auth::user()->name }}</span>
                                <span class="block text-xs font-medium text-neutral-500">{{ Auth::user()->email }}</span>
                            </span>

                            <div class="ms-1">
                                <svg class="h-4 w-4 fill-current text-neutral-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 transition hover:bg-neutral-50 hover:text-neutral-700 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="space-y-1 border-t border-neutral-200 px-4 pb-3 pt-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <div class="border-t border-neutral-200 px-4 pb-4 pt-4">
            <div class="px-4">
                <div class="text-base font-semibold text-neutral-900">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-neutral-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
