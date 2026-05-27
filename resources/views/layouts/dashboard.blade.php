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

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --color-primary: #4f46e5;
            --color-primary-hover: #4338ca;
            --color-background: #ffffff;
            --color-surface: #f9fafb;
            --color-border: #e5e7eb;
            --color-text-primary: #111827;
            --color-text-secondary: #6b7280;
            --color-text-muted: #9ca3af;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-surface);
            color: var(--color-text-primary);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-gray-50">
    <div class="flex min-h-screen">
        <x-dashboard.sidebar />

        <div class="flex-1 flex flex-col lg:ml-64 transition-all duration-300">
            <x-dashboard.navbar />

            <main class="flex-1 py-8 px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
