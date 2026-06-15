<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Syncora') }}</title>

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

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-neutral-50 text-neutral-900 antialiased dark:bg-neutral-950 dark:text-neutral-100">
        <div class="relative min-h-screen overflow-hidden">
            <div class="absolute inset-x-0 top-0 h-[28rem] bg-[radial-gradient(circle_at_top_left,_rgba(79,70,229,0.14),_transparent_36%),radial-gradient(circle_at_top_right,_rgba(14,165,233,0.1),_transparent_32%),linear-gradient(to_bottom,_#ffffff,_#f8fafc)] dark:bg-[radial-gradient(circle_at_top_left,_rgba(129,140,248,0.16),_transparent_38%),radial-gradient(circle_at_top_right,_rgba(56,189,248,0.12),_transparent_34%),linear-gradient(to_bottom,_#0b1220,_#050914)]"></div>
            <div class="absolute left-1/2 top-24 h-72 w-72 -translate-x-1/2 rounded-full bg-primary-200/20 blur-3xl dark:bg-primary-500/10"></div>

            <div class="relative mx-auto flex min-h-screen w-full max-w-6xl flex-col px-6 py-8 lg:px-8">
                <header class="flex items-center justify-between gap-4">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-primary-600 text-sm font-semibold text-white shadow-soft">S</span>
                        <span class="min-w-0">
                            <span class="block text-sm font-semibold tracking-tight text-neutral-950 dark:text-neutral-50">{{ config('app.name', 'Syncora') }}</span>
                            <span class="block text-xs font-medium text-neutral-500 dark:text-neutral-400">Secure account access</span>
                        </span>
                    </a>

                    <a href="{{ route('login') }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-neutral-200 bg-white px-5 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-200 dark:hover:bg-neutral-900">
                        Back to sign in
                    </a>
                </header>

                <main class="flex flex-1 items-center justify-center py-10 lg:py-14">
                    <div class="w-full max-w-xl rounded-[30px] border border-neutral-200 bg-white/95 p-6 shadow-[0_30px_80px_-40px_rgba(15,23,42,0.3)] backdrop-blur sm:p-8 dark:border-neutral-800 dark:bg-neutral-950/85 dark:shadow-[0_30px_80px_-40px_rgba(0,0,0,0.75)]">
                        <div class="mb-6">
                            <span class="inline-flex items-center rounded-full border border-primary-100 bg-primary-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 dark:border-primary-500/20 dark:bg-primary-500/10 dark:text-primary-200">
                                Account support
                            </span>
                        </div>

                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
