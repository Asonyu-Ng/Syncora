@props([
    'cardWidth' => 'md',
    'variant' => 'card',
])

@php
    $cardWidthClass = match ($cardWidth) {
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        default => 'max-w-md',
    };

    $authBrandName = trim((string) config('app.name', ''));
    $authBrandName = $authBrandName !== '' && strcasecmp($authBrandName, 'Laravel') !== 0
        ? $authBrandName
        : 'Syncora';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? $authBrandName }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            (function () {
                try {
                    var stored = localStorage.getItem('theme');
                    var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                    var theme = stored ? stored : (prefersDark ? 'dark' : 'light');
                    var root = document.documentElement;
                    if (theme === 'dark') {
                        root.classList.add('dark');
                    } else {
                        root.classList.remove('dark');
                    }
                } catch (e) {}
            })();
        </script>
    </head>
    <body class="bg-neutral-50 font-['Inter'] text-neutral-900 antialiased dark:bg-neutral-950 dark:text-neutral-100">
        @if ($variant === 'split')
            <div class="relative min-h-screen overflow-hidden bg-[#f5f7fb] dark:bg-neutral-950">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(99,102,241,0.12),_transparent_30%),radial-gradient(circle_at_bottom_right,_rgba(14,165,233,0.12),_transparent_28%),linear-gradient(180deg,_#f8fafc_0%,_#eff4ff_100%)] dark:bg-[radial-gradient(circle_at_top_left,_rgba(129,140,248,0.16),_transparent_34%),radial-gradient(circle_at_bottom_right,_rgba(56,189,248,0.10),_transparent_30%),linear-gradient(180deg,_rgba(10,10,10,1)_0%,_rgba(3,7,18,1)_100%)]"></div>
                <div class="absolute inset-y-0 left-0 hidden w-1/2 bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.28),_transparent_42%)] dark:bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.06),_transparent_42%)] lg:block"></div>

                <main class="relative flex min-h-screen items-center justify-center px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8">
                    <button
                        type="button"
                        data-theme-toggle
                        aria-label="Toggle theme"
                        class="absolute right-5 top-5 z-20 inline-flex h-10 w-10 items-center justify-center rounded-xl border border-white/60 bg-white/70 text-neutral-700 shadow-soft backdrop-blur transition hover:bg-white focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-200 dark:hover:bg-neutral-900"
                    >
                        <svg data-theme-icon="light" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364l-1.414 1.414M7.05 16.95l-1.414 1.414m12.728 0l-1.414-1.414M7.05 7.05 5.636 5.636M12 8a4 4 0 100 8 4 4 0 000-8z" />
                        </svg>
                        <svg data-theme-icon="dark" class="hidden h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z" />
                        </svg>
                    </button>
                    <div class="w-full max-w-7xl overflow-hidden rounded-[2rem] border border-neutral-200/70 bg-white shadow-[0_45px_120px_-48px_rgba(15,23,42,0.35)] dark:border-neutral-800 dark:bg-neutral-950 dark:shadow-[0_45px_120px_-48px_rgba(0,0,0,0.72)]">
                        <div class="grid min-h-[720px] lg:grid-cols-[1.08fr_minmax(420px,0.92fr)]">
                            <section class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-primary-600 to-sky-500 px-6 py-7 text-white sm:px-8 sm:py-8 lg:px-10 lg:py-10 dark:from-neutral-950 dark:via-neutral-950 dark:to-primary-500/15">
                                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(255,255,255,0.30),_transparent_34%),radial-gradient(circle_at_72%_24%,_rgba(255,255,255,0.18),_transparent_30%),linear-gradient(180deg,_rgba(255,255,255,0.08)_0%,_rgba(0,0,0,0.05)_100%)] dark:bg-[radial-gradient(circle_at_top_left,_rgba(129,140,248,0.18),_transparent_34%),radial-gradient(circle_at_72%_24%,_rgba(56,189,248,0.10),_transparent_30%),linear-gradient(180deg,_rgba(0,0,0,0.08)_0%,_rgba(0,0,0,0.32)_100%)]"></div>
                                <div class="absolute inset-x-8 top-0 h-px bg-gradient-to-r from-white/0 via-white/40 to-white/0"></div>
                                <div class="absolute -left-20 bottom-10 h-52 w-52 rounded-full bg-white/18 blur-3xl dark:bg-indigo-400/20"></div>
                                <div class="absolute right-0 top-16 h-56 w-56 rounded-full bg-white/12 blur-3xl dark:bg-cyan-400/16"></div>

                                <div class="relative flex h-full flex-col">
                                    <a href="{{ url('/') }}" class="inline-flex w-fit items-center gap-3 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-left backdrop-blur transition hover:bg-white/14 focus:outline-none focus:ring-4 focus:ring-white/15">
                                        <div class="grid h-11 w-11 place-items-center rounded-full bg-white text-neutral-950 shadow-lg shadow-black/15">
                                            <x-application-logo class="h-6 w-6 fill-current text-neutral-950" />
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold tracking-tight text-white">{{ $authBrandName }}</div>
                                            <div class="text-[12px] leading-5 text-white/80">Internship workflow platform</div>
                                        </div>
                                    </a>

                                    <div class="mt-8 flex-1">
                                        {{ $hero ?? '' }}
                                    </div>

                                    <div class="mt-6 grid gap-3 sm:grid-cols-3">
                                        <div class="rounded-[1.5rem] border border-white/10 bg-white/8 px-4 py-3.5 backdrop-blur">
                                            <div class="text-[11px] font-semibold uppercase tracking-[0.12em] text-white/75">Unified Access</div>
                                            <div class="mt-1.5 text-[13px] leading-5 text-white">One secure entry point for students, supervisors, and company teams.</div>
                                        </div>
                                        <div class="rounded-[1.5rem] border border-white/10 bg-white/8 px-4 py-3.5 backdrop-blur">
                                            <div class="text-[11px] font-semibold uppercase tracking-[0.12em] text-white/75">Live Workflow</div>
                                            <div class="mt-1.5 text-[13px] leading-5 text-white">Stay aligned on approvals, task progress, reports, and internship milestones.</div>
                                        </div>
                                        <div class="rounded-[1.5rem] border border-white/10 bg-white/8 px-4 py-3.5 backdrop-blur">
                                            <div class="text-[11px] font-semibold uppercase tracking-[0.12em] text-white/75">Trusted Routing</div>
                                            <div class="mt-1.5 text-[13px] leading-5 text-white">Sign in and land in the right dashboard with the same protected auth flow.</div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section class="flex items-center bg-white px-5 py-7 sm:px-8 sm:py-8 lg:px-10 lg:py-10 dark:bg-neutral-950">
                                <div class="mx-auto w-full {{ $cardWidthClass }}">
                                    {{ $slot }}
                                </div>
                            </section>
                        </div>
                    </div>
                </main>
            </div>
        @else
            <div class="relative min-h-screen overflow-hidden bg-neutral-50 dark:bg-neutral-950">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(99,102,241,0.16),_transparent_32%),radial-gradient(circle_at_18%_20%,_rgba(236,72,153,0.10),_transparent_24%),linear-gradient(180deg,_#f8fafc_0%,_#eef2ff_48%,_#fdf2f8_100%)] dark:bg-[radial-gradient(circle_at_top,_rgba(129,140,248,0.16),_transparent_34%),radial-gradient(circle_at_18%_20%,_rgba(56,189,248,0.10),_transparent_30%),linear-gradient(180deg,_rgba(10,10,10,1)_0%,_rgba(3,7,18,1)_100%)]"></div>
                <div class="absolute inset-x-0 top-0 h-72 bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.95),_transparent_58%)] dark:bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.06),_transparent_58%)]"></div>
                <div class="absolute -top-28 left-1/2 h-80 w-80 -translate-x-[130%] rounded-full bg-fuchsia-300/25 blur-3xl dark:bg-primary-500/14"></div>
                <div class="absolute bottom-0 right-0 h-96 w-96 translate-x-1/3 translate-y-1/4 rounded-full bg-indigo-200/30 blur-3xl dark:bg-indigo-500/14"></div>
                <div class="absolute inset-0 opacity-[0.18] dark:opacity-[0.12]" style="background-image:linear-gradient(to right, rgba(148,163,184,0.22) 1px, transparent 1px), linear-gradient(to bottom, rgba(148,163,184,0.22) 1px, transparent 1px); background-size: 44px 44px;"></div>

                <main class="relative flex min-h-screen items-center justify-center px-4 py-10 sm:px-6 lg:px-8">
                    <button
                        type="button"
                        data-theme-toggle
                        aria-label="Toggle theme"
                        class="absolute right-5 top-5 z-20 inline-flex h-10 w-10 items-center justify-center rounded-xl border border-white/60 bg-white/70 text-neutral-700 shadow-soft backdrop-blur transition hover:bg-white focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-200 dark:hover:bg-neutral-900"
                    >
                        <svg data-theme-icon="light" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364l-1.414 1.414M7.05 16.95l-1.414 1.414m12.728 0l-1.414-1.414M7.05 7.05 5.636 5.636M12 8a4 4 0 100 8 4 4 0 000-8z" />
                        </svg>
                        <svg data-theme-icon="dark" class="hidden h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z" />
                        </svg>
                    </button>
                    <div class="w-full max-w-7xl">
                        <div class="mx-auto flex max-w-3xl flex-col items-center text-center">
                            <a href="{{ url('/') }}" class="inline-flex items-center gap-3 rounded-full border border-white/70 bg-white/80 px-4 py-2 text-left shadow-lg shadow-indigo-100/40 backdrop-blur-xl transition hover:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15 dark:border-neutral-800 dark:bg-neutral-950/70 dark:shadow-black/30 dark:hover:bg-neutral-950">
                                <div class="grid h-11 w-11 place-items-center rounded-full bg-slate-900 text-white shadow-lg shadow-indigo-200/60 dark:bg-neutral-50 dark:text-neutral-950">
                                    <x-application-logo class="h-6 w-6 fill-current text-white dark:text-neutral-950" />
                                </div>
                                <div>
                                    <div class="text-sm font-semibold tracking-tight text-slate-900 dark:text-neutral-50">{{ $authBrandName }}</div>
                                    <div class="text-[12px] leading-5 text-slate-500 dark:text-neutral-300">Internship workflow platform</div>
                                </div>
                            </a>

                            <div class="mt-6 space-y-3">
                                <span class="inline-flex items-center rounded-full border border-indigo-100 bg-white/75 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-indigo-700 shadow-sm shadow-indigo-100/60 backdrop-blur-xl dark:border-primary-500/20 dark:bg-neutral-950/60 dark:text-primary-200">
                                    Secure Access
                                </span>
                                <h1 class="text-3xl font-semibold leading-tight tracking-tight text-slate-900 sm:text-4xl dark:text-neutral-50">
                                    Sign in or create your {{ $authBrandName }} workspace.
                                </h1>
                                <p class="max-w-2xl text-[15px] leading-6 text-slate-600 dark:text-neutral-300">
                                    A focused, role-aware entry point for students, supervisors, and companies managing internship workflows.
                                </p>
                            </div>

                            <div class="mt-8 w-full {{ $cardWidthClass }}">
                                <div class="rounded-[2rem] border border-white/70 bg-white/92 p-6 shadow-[0_40px_120px_-42px_rgba(99,102,241,0.28)] ring-1 ring-indigo-100/70 backdrop-blur-2xl sm:p-8 dark:border-neutral-800 dark:bg-neutral-950/80 dark:ring-neutral-800 dark:shadow-[0_40px_120px_-42px_rgba(0,0,0,0.72)]">
                                    {{ $slot }}
                                </div>
                            </div>

                            <p class="mt-4 max-w-lg text-center text-[14px] leading-6 text-slate-600 dark:text-neutral-300">
                                Protected access with role-specific onboarding, validation feedback, and the same workflow logic used across {{ $authBrandName }}.
                            </p>
                        </div>
                    </div>
                </main>
            </div>
        @endif
        <script>
            (function () {
                function isDark() {
                    return document.documentElement.classList.contains('dark');
                }

                function setTheme(theme) {
                    var root = document.documentElement;
                    if (theme === 'dark') {
                        root.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                    } else {
                        root.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                    }
                }

                function syncIcons() {
                    var dark = isDark();
                    document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
                        var lightIcon = btn.querySelector('[data-theme-icon="light"]');
                        var darkIcon = btn.querySelector('[data-theme-icon="dark"]');
                        if (lightIcon) lightIcon.classList.toggle('hidden', dark);
                        if (darkIcon) darkIcon.classList.toggle('hidden', !dark);
                    });
                }

                window.addEventListener('DOMContentLoaded', function () {
                    syncIcons();
                    document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
                        btn.addEventListener('click', function () {
                            setTheme(isDark() ? 'light' : 'dark');
                            syncIcons();
                        });
                    });
                });
            })();
        </script>
    </body>
</html>
