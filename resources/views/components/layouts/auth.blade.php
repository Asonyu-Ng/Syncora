@props(['cardWidth' => 'md'])

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
    </head>
    <body class="bg-slate-50 font-['Inter'] text-slate-900 antialiased">
        <div class="relative min-h-screen overflow-hidden bg-slate-50">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(99,102,241,0.16),_transparent_32%),radial-gradient(circle_at_18%_20%,_rgba(236,72,153,0.10),_transparent_24%),linear-gradient(180deg,_#f8fafc_0%,_#eef2ff_48%,_#fdf2f8_100%)]"></div>
            <div class="absolute inset-x-0 top-0 h-72 bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.95),_transparent_58%)]"></div>
            <div class="absolute -top-28 left-1/2 h-80 w-80 -translate-x-[130%] rounded-full bg-fuchsia-300/25 blur-3xl"></div>
            <div class="absolute bottom-0 right-0 h-96 w-96 translate-x-1/3 translate-y-1/4 rounded-full bg-indigo-200/30 blur-3xl"></div>
            <div class="absolute inset-0 opacity-[0.18]" style="background-image:linear-gradient(to right, rgba(148,163,184,0.22) 1px, transparent 1px), linear-gradient(to bottom, rgba(148,163,184,0.22) 1px, transparent 1px); background-size: 44px 44px;"></div>

            <main class="relative flex min-h-screen items-center justify-center px-4 py-10 sm:px-6 lg:px-8">
                <div class="w-full max-w-7xl">
                    <div class="mx-auto flex max-w-3xl flex-col items-center text-center">
                        <a href="{{ url('/') }}" class="inline-flex items-center gap-3 rounded-full border border-white/70 bg-white/80 px-4 py-2 text-left shadow-lg shadow-indigo-100/40 backdrop-blur-xl transition hover:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15">
                            <div class="grid h-11 w-11 place-items-center rounded-full bg-slate-900 text-white shadow-lg shadow-indigo-200/60">
                                <x-application-logo class="h-6 w-6 fill-current text-white" />
                            </div>
                            <div>
                                <div class="text-sm font-semibold tracking-tight text-slate-900">{{ $authBrandName }}</div>
                                <div class="text-xs text-slate-500">Internship workflow platform</div>
                            </div>
                        </a>

                        <div class="mt-6 space-y-3">
                            <span class="inline-flex items-center rounded-full border border-indigo-100 bg-white/75 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.24em] text-indigo-700 shadow-sm shadow-indigo-100/60 backdrop-blur-xl">
                                Secure Access
                            </span>
                            <h1 class="text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">
                                Sign in or create your {{ $authBrandName }} workspace.
                            </h1>
                            <p class="max-w-2xl text-sm leading-6 text-slate-600 sm:text-base">
                                A focused, role-aware entry point for students, supervisors, and companies managing internship workflows.
                            </p>
                        </div>

                        <div class="mt-8 w-full {{ $cardWidthClass }}">
                            <div class="rounded-[2rem] border border-white/70 bg-white/92 p-6 shadow-[0_40px_120px_-42px_rgba(99,102,241,0.28)] ring-1 ring-indigo-100/70 backdrop-blur-2xl sm:p-8">
                                {{ $slot }}
                            </div>
                        </div>

                        <p class="mt-4 max-w-lg text-center text-sm leading-6 text-slate-600">
                            Protected access with role-specific onboarding, validation feedback, and the same workflow logic used across {{ $authBrandName }}.
                        </p>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
