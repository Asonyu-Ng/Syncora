<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-['Inter'] text-slate-900 antialiased">
        <div class="min-h-screen bg-slate-50">
            <div class="min-h-screen lg:grid lg:grid-cols-2">
                <div class="relative overflow-hidden bg-slate-950 px-6 py-10 sm:px-10 lg:px-12 lg:py-12">
                    <img
                        class="absolute inset-0 h-full w-full object-cover opacity-75"
                        alt="University students collaborating"
                        src="https://coresg-normal.trae.ai/api/ide/v1/text_to_image?prompt=professional%20photograph%20of%20diverse%20university%20students%20collaborating%20in%20a%20modern%20campus%20workspace%2C%20natural%20light%2C%20realistic%2C%20high%20detail%2C%20shallow%20depth%20of%20field%2C%20no%20text%2C%20no%20logos&image_size=landscape_16_9"
                    />
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-700/80 via-slate-950/70 to-fuchsia-700/70"></div>
                    <div class="absolute -top-28 -left-24 h-80 w-80 rounded-full bg-fuchsia-500/30 blur-3xl"></div>
                    <div class="absolute -bottom-32 -right-20 h-96 w-96 rounded-full bg-indigo-400/25 blur-3xl"></div>

                    <div class="relative mx-auto flex h-full w-full max-w-xl flex-col">
                        <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                            <div class="grid h-10 w-10 place-items-center rounded-xl bg-white/15 ring-1 ring-white/25">
                                <x-application-logo class="h-6 w-6 fill-current text-white" />
                            </div>
                            <div class="text-base font-semibold tracking-tight text-white">{{ config('app.name', 'Syncora') }}</div>
                        </a>

                        <div class="mt-10">
                            <h1 class="text-3xl font-semibold tracking-tight text-white sm:text-4xl">Manage. Supervise. Verify. Succeed.</h1>
                            <p class="mt-4 text-base leading-relaxed text-white/85">Syncora helps universities, students, supervisors, and companies streamline internship management and verification.</p>
                        </div>

                        <ul class="mt-8 space-y-3 text-sm text-white/85">
                            <li class="flex items-start gap-3">
                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-white/80"></span>
                                <span>Internship Placement</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-white/80"></span>
                                <span>Progress Tracking</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-white/80"></span>
                                <span>AI-Assisted Reports</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-white/80"></span>
                                <span>Verification System</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-white/80"></span>
                                <span>Analytics Dashboard</span>
                            </li>
                        </ul>

                        <div class="mt-auto pt-10 text-xs text-white/70">
                            <span class="font-medium text-white/80">Syncora</span> · Internship management platform
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-center px-6 py-10 sm:px-10 lg:px-12 lg:py-12">
                    <div class="w-full max-w-md">
                        <div class="rounded-2xl bg-white p-8 shadow-xl shadow-slate-200/60 ring-1 ring-slate-200">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
