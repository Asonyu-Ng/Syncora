<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Syncora') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-neutral-50 text-neutral-900 antialiased">
        @php
            $featureCards = [
                ['title' => 'Student workflow', 'body' => 'Track applications, submit task evidence, and keep your internship logbook up to date.'],
                ['title' => 'Supervisor review', 'body' => 'Monitor student progress, approve logbooks, and export reports without leaving the dashboard.'],
                ['title' => 'Company coordination', 'body' => 'Publish internship openings, manage applicants, and keep placement activity organised.'],
            ];

            $platformStats = [
                ['label' => 'Workspaces', 'value' => '3 roles'],
                ['label' => 'Core flows', 'value' => 'Applications, tasks, logbooks'],
                ['label' => 'Focus', 'value' => 'Structured internship delivery'],
            ];
        @endphp

        <div class="relative overflow-hidden">
            <div class="absolute inset-x-0 top-0 h-[34rem] bg-[radial-gradient(circle_at_top_left,_rgba(79,70,229,0.16),_transparent_40%),radial-gradient(circle_at_top_right,_rgba(14,165,233,0.12),_transparent_34%),linear-gradient(to_bottom,_#ffffff,_#f8fafc)]"></div>
            <div class="absolute left-1/2 top-24 h-72 w-72 -translate-x-1/2 rounded-full bg-primary-200/20 blur-3xl"></div>

            <div class="relative mx-auto flex min-h-screen w-full max-w-7xl flex-col px-6 py-6 lg:px-8">
                <header class="flex items-center justify-between gap-4">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-primary-600 text-sm font-semibold text-white shadow-soft">S</span>
                        <span class="min-w-0">
                            <span class="block text-sm font-semibold tracking-tight text-neutral-950">{{ config('app.name', 'Syncora') }}</span>
                            <span class="block text-xs font-medium text-neutral-500">Internship workflow platform</span>
                        </span>
                    </a>

                    @if (Route::has('login'))
                        <nav class="flex items-center gap-3">
                            @auth
                                <a href="{{ route('dashboard') }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-neutral-200 bg-white px-5 text-sm font-semibold text-neutral-800 shadow-soft transition hover:bg-neutral-100">
                                    Go to dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-neutral-200 bg-white px-5 text-sm font-semibold text-neutral-800 shadow-soft transition hover:bg-neutral-100">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500">
                                        Create account
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </header>

                <main class="flex flex-1 items-center py-12 lg:py-16">
                    <div class="grid w-full items-center gap-10 lg:grid-cols-[1.1fr_0.9fr]">
                        <section class="max-w-2xl">
                            <span class="inline-flex items-center rounded-full border border-primary-100 bg-white/85 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700 shadow-soft">
                                Internship coordination, refined
                            </span>

                            <h1 class="mt-6 text-4xl font-semibold tracking-tight text-neutral-950 sm:text-5xl lg:text-[3.65rem] lg:leading-[1.02]">
                                Manage the internship journey from application to final review.
                            </h1>

                            <p class="mt-5 max-w-xl text-[15px] leading-7 text-neutral-600 sm:text-base">
                                Syncora brings students, supervisors, and companies into one calmer workflow for placement tracking, task submissions, approvals, and reporting.
                            </p>

                            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                                @auth
                                    <a href="{{ route('dashboard') }}" class="inline-flex h-12 items-center justify-center rounded-xl bg-primary-600 px-6 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500">
                                        Open dashboard
                                    </a>
                                @else
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="inline-flex h-12 items-center justify-center rounded-xl bg-primary-600 px-6 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500">
                                            Start onboarding
                                        </a>
                                    @endif

                                    <a href="{{ route('login') }}" class="inline-flex h-12 items-center justify-center rounded-xl border border-neutral-200 bg-white px-6 text-sm font-semibold text-neutral-800 shadow-soft transition hover:bg-neutral-100">
                                        Access existing workspace
                                    </a>
                                @endauth
                            </div>

                            <div class="mt-10 grid gap-3 sm:grid-cols-3">
                                @foreach ($platformStats as $stat)
                                    <div class="rounded-2xl border border-neutral-200 bg-white/80 p-4 shadow-soft backdrop-blur">
                                        <div class="text-lg font-semibold tracking-tight text-neutral-950">{{ $stat['value'] }}</div>
                                        <div class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-neutral-500">{{ $stat['label'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </section>

                        <section class="relative">
                            <div class="rounded-[32px] border border-neutral-200 bg-white/90 p-5 shadow-[0_30px_80px_-40px_rgba(15,23,42,0.28)] backdrop-blur sm:p-6">
                                <div class="rounded-[28px] border border-primary-100 bg-gradient-to-br from-primary-50 via-white to-sky-50 p-6">
                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700">Product Snapshot</p>
                                            <h2 class="mt-3 text-2xl font-semibold tracking-tight text-neutral-950">A single workspace for internship operations.</h2>
                                        </div>
                                        <span class="inline-flex items-center rounded-full border border-white/80 bg-white/90 px-3 py-1 text-xs font-semibold text-neutral-600 shadow-soft">
                                            Live dashboards
                                        </span>
                                    </div>

                                    <div class="mt-6 grid gap-3">
                                        @foreach ($featureCards as $card)
                                            <div class="rounded-2xl border border-white/80 bg-white/85 p-4 shadow-soft">
                                                <div class="text-sm font-semibold text-neutral-900">{{ $card['title'] }}</div>
                                                <p class="mt-2 text-sm leading-6 text-neutral-600">{{ $card['body'] }}</p>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                                        <a href="{{ route('student.dashboard') }}" class="rounded-2xl border border-white/80 bg-white/90 p-4 shadow-soft transition hover:bg-white">
                                            <div class="text-sm font-semibold text-neutral-900">Student dashboard</div>
                                            <p class="mt-2 text-sm leading-6 text-neutral-600">Applications, task evidence, logbook entries, and profile completion in one place.</p>
                                        </a>

                                        <a href="{{ route('company.internships.create') }}" class="rounded-2xl border border-white/80 bg-white/90 p-4 shadow-soft transition hover:bg-white">
                                            <div class="text-sm font-semibold text-neutral-900">Post an internship</div>
                                            <p class="mt-2 text-sm leading-6 text-neutral-600">Create opportunities, manage placements, and organise follow-up without friction.</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
