<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
            <div class="min-w-0">
                <span class="inline-flex items-center rounded-full border border-primary-100 bg-primary-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-700">
                    Account settings
                </span>
                <h2 class="mt-3 text-3xl font-semibold tracking-tight text-neutral-950">
                    {{ __('Manage your account with the same clarity as the rest of Syncora.') }}
                </h2>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-neutral-600">
                    {{ __('Update your personal details, strengthen access security, and review account actions from one organised page.') }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-6 xl:grid-cols-[1.05fr_0.95fr]">
            <div class="space-y-6">
                <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-white to-primary-50/60 shadow-card">
                    <div class="grid gap-4 px-6 py-6 sm:px-8 lg:grid-cols-[1.1fr_0.9fr]">
                        <div>
                            <h3 class="text-lg font-semibold tracking-tight text-neutral-950">{{ __('Account overview') }}</h3>
                            <p class="mt-2 text-sm leading-6 text-neutral-600">
                                {{ __('Keep your profile accurate so your workspace, notifications, and identity details remain consistent across the platform.') }}
                            </p>
                        </div>
                        <div class="rounded-2xl border border-neutral-200 bg-white/90 p-4 shadow-soft">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500">{{ __('Security note') }}</p>
                            <p class="mt-2 text-sm leading-6 text-neutral-600">
                                {{ __('Use a strong password and a current email address so recovery and verification flows continue to work smoothly.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-8">
                    <div class="max-w-2xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-8">
                    <div class="max-w-2xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                    <h3 class="text-sm font-semibold text-neutral-900">{{ __('Quick guidance') }}</h3>
                    <div class="mt-4 space-y-3">
                        <div class="rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-3 text-sm leading-6 text-neutral-600">
                            {{ __('Keep your displayed name aligned with your role workspace so collaboration and approvals stay clear.') }}
                        </div>
                        <div class="rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-3 text-sm leading-6 text-neutral-600">
                            {{ __('Password updates should use a strong, unique phrase that you do not reuse elsewhere.') }}
                        </div>
                        <div class="rounded-2xl border border-danger-200 bg-danger-50 px-4 py-3 text-sm leading-6 text-danger-700">
                            {{ __('Delete account remains available below and is intentionally separated from everyday settings.') }}
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-8">
                    <div class="max-w-2xl">
                        @include('profile.partials.delete-user-form')
                </div>
            </div>
            </div>
        </div>
    </div>
</x-app-layout>
