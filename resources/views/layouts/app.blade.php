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
        <div class="min-h-screen bg-neutral-50 dark:bg-neutral-950">
            @include('layouts.navigation')

            @isset($header)
                <header class="border-b border-neutral-200 bg-white/95 backdrop-blur dark:border-neutral-800 dark:bg-neutral-950/80">
                    <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="py-8 sm:py-10">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
