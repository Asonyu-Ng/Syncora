<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Syncora' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-neutral-50 text-neutral-900 antialiased">
    <div
        x-data="{ sidebarOpen: false }"
        @toggle-sidebar.window="sidebarOpen = !sidebarOpen"
        @close-sidebar.window="sidebarOpen = false"
        class="flex min-h-screen"
    >
        <x-dashboard.sidebar />

        <div class="flex-1 min-w-0 flex flex-col transition-all duration-300">
            <x-dashboard.navbar :page-title="($title ?? null)" :breadcrumbs="($breadcrumbs ?? null)" />

            <main class="flex-1 min-w-0">
                <div class="mx-auto w-full max-w-7xl p-3 sm:p-4 lg:p-6 min-w-0">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
