@php
    $user = Auth::user();
    $name = $user?->name ?? 'User';
    $email = $user?->email ?? 'user@example.com';
    $roleLabel = $user?->role ? Str::title($user->role) : 'User';

    $role = $user?->role;
    $profileRouteName = match ($role) {
        'student' => 'student.profile',
        'supervisor' => 'supervisor.profile',
        'company' => 'company.profile',
        default => null,
    };
    $profileFallbackPath = match ($role) {
        'student' => '/student/profile',
        'supervisor' => '/supervisor/profile',
        'company' => '/company/profile',
        default => null,
    };
    $profileHref = ($profileRouteName && Route::has($profileRouteName))
        ? route($profileRouteName)
        : ($profileFallbackPath ?? (Route::has('profile.edit') ? route('profile.edit') : '#'));

    $settingsRouteName = match ($role) {
        'student' => 'student.settings',
        'supervisor' => 'supervisor.settings',
        'company' => 'company.settings',
        'admin' => 'admin.settings',
        default => null,
    };
    $settingsFallbackPath = match ($role) {
        'student' => '/student/settings',
        'supervisor' => '/supervisor/settings',
        'company' => '/company/settings',
        'admin' => '/admin/settings',
        default => '#',
    };
    $settingsHref = ($settingsRouteName && Route::has($settingsRouteName))
        ? route($settingsRouteName)
        : $settingsFallbackPath;
@endphp

<div x-data="{ open: false }" @keydown.escape.window="open = false" class="relative">
    <button
        @click="open = !open"
        @click.outside="open = false"
        class="flex items-center gap-3 h-10 pl-2 pr-3 rounded-xl border border-neutral-200 bg-white hover:bg-neutral-50 transition-colors"
        aria-label="Open profile menu"
    >
        <x-avatar :name="$name" :email="$email" size="md" />
        <div class="hidden sm:block min-w-0">
            <p class="text-sm font-semibold text-neutral-900 leading-tight truncate">{{ $name }}</p>
            <p class="text-xs text-neutral-500 leading-tight truncate">{{ $roleLabel }}</p>
        </div>
        <svg class="w-4 h-4 text-neutral-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-card ring-1 ring-neutral-900/10 py-2 z-50"
        style="display: none;"
    >
        <div class="px-4 py-3 border-b border-neutral-200">
            <p class="text-sm font-semibold text-neutral-900">{{ $name }}</p>
            <p class="text-xs text-neutral-500 mt-0.5">{{ $email }}</p>
            <p class="text-xs text-neutral-500 mt-0.5">{{ $roleLabel }}</p>
        </div>

        <a
            href="{{ $profileHref }}"
            class="flex items-center px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 transition-colors"
        >
            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Profile
        </a>

        <a
            href="{{ $settingsHref }}"
            class="flex items-center px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 transition-colors"
        >
            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Settings
        </a>

        @if(Route::has('logout'))
            <button
                type="button"
                onclick="event.preventDefault(); document.getElementById('dashboard-logout-form').submit();"
                class="w-full text-left flex items-center px-4 py-2 text-sm text-danger-600 hover:bg-danger-50 transition-colors"
            >
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Sign out
            </button>
            <form id="dashboard-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        @endif
    </div>
</div>
