<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Workspace Directory</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-neutral-50 text-neutral-900 antialiased">
    @php
        $workspaces = [
            ['label' => 'Admin', 'href' => '/admin/dashboard', 'meta' => 'System oversight, analytics, reports, and settings'],
            ['label' => 'Student', 'href' => '/student/dashboard', 'meta' => 'Applications, tasks, logbook activity, and profile'],
            ['label' => 'Supervisor', 'href' => '/supervisor/dashboard', 'meta' => 'Monitoring, approvals, reports, and student coordination'],
            ['label' => 'Company', 'href' => '/company/dashboard', 'meta' => 'Open roles, applicants, interns, and evaluations'],
        ];
    @endphp

    <div class="relative min-h-screen overflow-hidden">
        <div class="absolute inset-x-0 top-0 h-[28rem] bg-[radial-gradient(circle_at_top_left,_rgba(79,70,229,0.14),_transparent_36%),radial-gradient(circle_at_top_right,_rgba(14,165,233,0.12),_transparent_32%),linear-gradient(to_bottom,_#ffffff,_#f8fafc)]"></div>

        <div class="relative mx-auto max-w-5xl px-6 py-12 lg:px-8 lg:py-16">
            <div class="overflow-hidden rounded-[30px] border border-neutral-200 bg-white/95 shadow-[0_30px_80px_-40px_rgba(15,23,42,0.3)] backdrop-blur">
                <div class="border-b border-neutral-200 px-6 py-6 sm:px-8">
                    <span class="inline-flex items-center rounded-full border border-primary-100 bg-primary-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700">
                        Workspace directory
                    </span>
                    <h1 class="mt-4 text-3xl font-semibold tracking-tight text-neutral-950">Open the correct Syncora dashboard quickly.</h1>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-neutral-600">
                        This internal directory groups role workspaces in one clean place without exposing raw test-only language.
                    </p>
                </div>

                <div class="grid gap-4 p-6 sm:grid-cols-2 sm:p-8">
                    @foreach ($workspaces as $workspace)
                        <a href="{{ $workspace['href'] }}" class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-soft transition hover:bg-neutral-50 hover:shadow-card">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-neutral-900">{{ $workspace['label'] }}</div>
                                    <p class="mt-2 text-sm leading-6 text-neutral-600">{{ $workspace['meta'] }}</p>
                                </div>
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-neutral-100 text-neutral-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </div>
                            <div class="mt-4 text-xs font-medium text-neutral-400">{{ $workspace['href'] }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</body>
</html>
