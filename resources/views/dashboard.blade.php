<x-app-layout>
    <x-slot name="header">
        <div class="min-w-0">
            <span class="inline-flex items-center rounded-full border border-primary-100 bg-primary-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700">
                Workspace access
            </span>
            <h2 class="mt-3 text-3xl font-semibold tracking-tight text-neutral-950">
                {{ __('Your account is active and ready to continue.') }}
            </h2>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-neutral-600">
                {{ __('Use this safe fallback view to continue into the correct role dashboard if you are redirected here unexpectedly.') }}
            </p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
            <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
                <div>
                    <h3 class="text-lg font-semibold tracking-tight text-neutral-950">{{ __("You're logged in.") }}</h3>
                    <p class="mt-2 text-sm leading-6 text-neutral-600">
                        {{ __('If you already have a role-specific workspace, continue there directly. If not, use your account settings to review your current details.') }}
                    </p>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('profile.edit') }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500">
                            {{ __('Open account settings') }}
                        </a>
                        <a href="{{ url('/__dashboards') }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-neutral-200 bg-white px-5 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50">
                            {{ __('View workspace links') }}
                        </a>
                    </div>
                </div>

                <div class="rounded-2xl border border-neutral-200 bg-white/90 p-5 shadow-soft">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">{{ __('Routing note') }}</p>
                    <p class="mt-2 text-sm leading-6 text-neutral-600">
                        {{ __('This page acts as a clean fallback surface so the product stays consistent even outside the main role dashboards.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
