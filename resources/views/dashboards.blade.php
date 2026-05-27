<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboards</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50">
    <div class="max-w-2xl mx-auto py-16 px-6">
        <h1 class="text-3xl font-bold text-gray-900">Dashboards</h1>
        <p class="mt-2 text-sm text-gray-600">Direct links for testing.</p>

        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="/admin/dashboard" class="block p-4 bg-white rounded-xl border border-gray-200 hover:shadow-md transition-shadow">
                <div class="text-sm font-semibold text-gray-900">Admin</div>
                <div class="text-xs text-gray-500 mt-1">/admin/dashboard</div>
            </a>
            <a href="/student/dashboard" class="block p-4 bg-white rounded-xl border border-gray-200 hover:shadow-md transition-shadow">
                <div class="text-sm font-semibold text-gray-900">Student</div>
                <div class="text-xs text-gray-500 mt-1">/student/dashboard</div>
            </a>
            <a href="/supervisor/dashboard" class="block p-4 bg-white rounded-xl border border-gray-200 hover:shadow-md transition-shadow">
                <div class="text-sm font-semibold text-gray-900">Supervisor</div>
                <div class="text-xs text-gray-500 mt-1">/supervisor/dashboard</div>
            </a>
            <a href="/company/dashboard" class="block p-4 bg-white rounded-xl border border-gray-200 hover:shadow-md transition-shadow">
                <div class="text-sm font-semibold text-gray-900">Company</div>
                <div class="text-xs text-gray-500 mt-1">/company/dashboard</div>
            </a>
        </div>
    </div>
</body>
</html>

