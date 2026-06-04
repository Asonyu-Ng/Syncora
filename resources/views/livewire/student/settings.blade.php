<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div class="min-w-0">
            <h1 class="text-3xl font-semibold text-neutral-900 tracking-tight">Settings</h1>
            <p class="mt-2 text-sm text-neutral-600">Manage your account preferences and keep your information secure.</p>
        </div>
    </div>

    @if(session('message'))
        <div class="rounded-2xl border border-primary-200 bg-primary-50 px-5 py-4 text-sm font-semibold text-primary-900 shadow-soft">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex overflow-x-auto border-b border-neutral-200 pb-1 -mx-3 px-3 sm:mx-0 sm:px-0">
        @foreach($tabs as $entry)
            @php $active = $tab === $entry['key']; @endphp

            <button
                type="button"
                wire:click="$set('tab', '{{ $entry['key'] }}')"
                class="mr-6 whitespace-nowrap border-b-2 pb-3 text-sm font-semibold transition focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 {{ $active ? 'border-primary-600 text-primary-700' : 'border-transparent text-neutral-600 hover:text-neutral-900' }}"
            >
                {{ $entry['label'] }}
            </button>
        @endforeach
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <div class="space-y-6 lg:col-span-8">
            @if($tab === 'general')
                <div class="rounded-2xl border border-neutral-200 bg-white shadow-card overflow-hidden">
                    <div class="flex items-start justify-between gap-4 border-b border-neutral-200 px-5 py-4 sm:px-6">
                        <div>
                            <h2 class="text-sm font-semibold text-neutral-900">Profile Information</h2>
                            <p class="mt-1 text-sm text-neutral-600">Update your personal information and how others see you.</p>
                        </div>
                        <a href="{{ route('student.profile') }}" class="inline-flex h-10 items-center justify-center gap-2 rounded-xl border border-primary-200 bg-white px-4 text-sm font-semibold text-primary-700 shadow-soft transition hover:bg-primary-50">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l9.932-9.931z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 7.125L16.875 4.5" />
                            </svg>
                            Edit Profile
                        </a>
                    </div>

                    <div class="px-5 py-5 sm:px-6">
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-neutral-100 text-base font-semibold text-neutral-700">
                                        {{ Str::of($profileCard['name'] ?? 'S')->trim()->substr(0, 1)->upper() }}
                                    </div>
                                    <button type="button" class="absolute -bottom-2 -right-2 inline-flex h-8 w-8 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h2l2-2h6l2 2h2a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-neutral-900">{{ $profileCard['name'] ?? '—' }}</div>
                                    <div class="mt-1 text-sm text-neutral-600">{{ $profileCard['email'] ?? '—' }}</div>
                                </div>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2 sm:gap-8">
                                <div class="space-y-1">
                                    <div class="text-xs font-semibold uppercase tracking-wide text-neutral-500">Phone Number</div>
                                    <div class="text-sm font-semibold text-neutral-900">{{ $profileCard['phone'] ?? '—' }}</div>
                                </div>
                                <div class="space-y-1">
                                    <div class="text-xs font-semibold uppercase tracking-wide text-neutral-500">Location</div>
                                    <div class="text-sm font-semibold text-neutral-900">{{ $profileCard['location'] ?? '—' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-neutral-200 bg-white shadow-card overflow-hidden">
                    <div class="flex items-start justify-between gap-4 border-b border-neutral-200 px-5 py-4 sm:px-6">
                        <div>
                            <h2 class="text-sm font-semibold text-neutral-900">Email Notifications</h2>
                            <p class="mt-1 text-sm text-neutral-600">Choose what you want to be notified about.</p>
                        </div>
                        <button type="button" wire:click="manageNotifications" class="inline-flex h-10 items-center justify-center rounded-xl border border-primary-200 bg-white px-4 text-sm font-semibold text-primary-700 shadow-soft transition hover:bg-primary-50">
                            Manage Notifications
                        </button>
                    </div>

                    <div class="divide-y divide-neutral-100">
                        <div class="flex items-start justify-between gap-4 px-5 py-4 sm:px-6">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-primary-50 text-primary-700">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5-1a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-neutral-900">Application Updates</div>
                                    <div class="mt-1 text-sm text-neutral-600">Receive notifications about your applications.</div>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="notifyApplicationUpdates" class="sr-only peer">
                                <div class="h-6 w-11 rounded-full bg-neutral-200 peer-checked:bg-primary-600 after:absolute after:left-1 after:top-1 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition peer-checked:after:translate-x-5"></div>
                            </label>
                        </div>

                        <div class="flex items-start justify-between gap-4 px-5 py-4 sm:px-6">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-primary-50 text-primary-700">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-neutral-900">Task Reminders</div>
                                    <div class="mt-1 text-sm text-neutral-600">Get reminded about upcoming and pending tasks.</div>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="notifyTaskReminders" class="sr-only peer">
                                <div class="h-6 w-11 rounded-full bg-neutral-200 peer-checked:bg-primary-600 after:absolute after:left-1 after:top-1 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition peer-checked:after:translate-x-5"></div>
                            </label>
                        </div>

                        <div class="flex items-start justify-between gap-4 px-5 py-4 sm:px-6">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-primary-50 text-primary-700">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 6H7a2 2 0 01-2-2V4a2 2 0 012-2h7l5 5v13a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-neutral-900">Logbook Updates</div>
                                    <div class="mt-1 text-sm text-neutral-600">Receive updates on logbook reviews and feedback.</div>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="notifyLogbookUpdates" class="sr-only peer">
                                <div class="h-6 w-11 rounded-full bg-neutral-200 peer-checked:bg-primary-600 after:absolute after:left-1 after:top-1 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition peer-checked:after:translate-x-5"></div>
                            </label>
                        </div>

                        <div class="flex items-start justify-between gap-4 px-5 py-4 sm:px-6">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-primary-50 text-primary-700">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-neutral-900">Announcements</div>
                                    <div class="mt-1 text-sm text-neutral-600">Receive important announcements and news.</div>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="notifyAnnouncements" class="sr-only peer">
                                <div class="h-6 w-11 rounded-full bg-neutral-200 peer-checked:bg-primary-600 after:absolute after:left-1 after:top-1 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition peer-checked:after:translate-x-5"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-neutral-200 bg-white shadow-card overflow-hidden">
                    <div class="flex items-start justify-between gap-4 border-b border-neutral-200 px-5 py-4 sm:px-6">
                        <div>
                            <h2 class="text-sm font-semibold text-neutral-900">Privacy Settings</h2>
                            <p class="mt-1 text-sm text-neutral-600">Manage your privacy and data preferences.</p>
                        </div>
                    </div>

                    <div class="divide-y divide-neutral-100">
                        <div class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                            <div>
                                <div class="text-sm font-semibold text-neutral-900">Profile Visibility</div>
                                <div class="mt-1 text-sm text-neutral-600">Choose who can see your profile information.</div>
                            </div>
                            <select wire:model.live="privacyProfileVisibility" class="h-10 w-full rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 sm:w-72">
                                @foreach($privacyVisibilityOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                            <div>
                                <div class="text-sm font-semibold text-neutral-900">Data & Activity</div>
                                <div class="mt-1 text-sm text-neutral-600">Manage how your data is used across the platform.</div>
                            </div>
                            <button type="button" wire:click="quickAction('download_data')" class="inline-flex h-10 items-center justify-center rounded-xl border border-primary-200 bg-white px-4 text-sm font-semibold text-primary-700 shadow-soft transition hover:bg-primary-50">
                                Manage
                            </button>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-neutral-200 bg-white shadow-card overflow-hidden">
                    <div class="px-5 py-4 sm:px-6 border-b border-neutral-200">
                        <h2 class="text-sm font-semibold text-neutral-900">Language & Region</h2>
                        <p class="mt-1 text-sm text-neutral-600">Set your preferred language and regional settings.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 px-5 py-5 sm:grid-cols-2 sm:px-6">
                        <div>
                            <label class="text-xs font-semibold uppercase tracking-wide text-neutral-500">Language</label>
                            <select wire:model.live="language" class="mt-2 h-10 w-full rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                @foreach($languageOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-semibold uppercase tracking-wide text-neutral-500">Time Zone</label>
                            <select wire:model.live="timezone" class="mt-2 h-10 w-full rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                @foreach($timezoneOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            @elseif($tab === 'notifications')
                <div class="rounded-2xl border border-neutral-200 bg-white shadow-card overflow-hidden">
                    <div class="px-5 py-4 sm:px-6 border-b border-neutral-200">
                        <h2 class="text-sm font-semibold text-neutral-900">Notifications</h2>
                        <p class="mt-1 text-sm text-neutral-600">Choose what you want to be notified about.</p>
                    </div>

                    <div class="divide-y divide-neutral-100">
                        <div class="flex items-start justify-between gap-4 px-5 py-4 sm:px-6">
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-neutral-900">Application Updates</div>
                                <div class="mt-1 text-sm text-neutral-600">Receive notifications about your applications.</div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="notifyApplicationUpdates" class="sr-only peer">
                                <div class="h-6 w-11 rounded-full bg-neutral-200 peer-checked:bg-primary-600 after:absolute after:left-1 after:top-1 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition peer-checked:after:translate-x-5"></div>
                            </label>
                        </div>
                        <div class="flex items-start justify-between gap-4 px-5 py-4 sm:px-6">
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-neutral-900">Task Reminders</div>
                                <div class="mt-1 text-sm text-neutral-600">Get reminded about upcoming and pending tasks.</div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="notifyTaskReminders" class="sr-only peer">
                                <div class="h-6 w-11 rounded-full bg-neutral-200 peer-checked:bg-primary-600 after:absolute after:left-1 after:top-1 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition peer-checked:after:translate-x-5"></div>
                            </label>
                        </div>
                        <div class="flex items-start justify-between gap-4 px-5 py-4 sm:px-6">
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-neutral-900">Logbook Updates</div>
                                <div class="mt-1 text-sm text-neutral-600">Receive updates on logbook reviews and feedback.</div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="notifyLogbookUpdates" class="sr-only peer">
                                <div class="h-6 w-11 rounded-full bg-neutral-200 peer-checked:bg-primary-600 after:absolute after:left-1 after:top-1 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition peer-checked:after:translate-x-5"></div>
                            </label>
                        </div>
                        <div class="flex items-start justify-between gap-4 px-5 py-4 sm:px-6">
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-neutral-900">Announcements</div>
                                <div class="mt-1 text-sm text-neutral-600">Receive important announcements and news.</div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="notifyAnnouncements" class="sr-only peer">
                                <div class="h-6 w-11 rounded-full bg-neutral-200 peer-checked:bg-primary-600 after:absolute after:left-1 after:top-1 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition peer-checked:after:translate-x-5"></div>
                            </label>
                        </div>
                    </div>
                </div>
            @elseif($tab === 'privacy')
                <div class="rounded-2xl border border-neutral-200 bg-white shadow-card overflow-hidden">
                    <div class="px-5 py-4 sm:px-6 border-b border-neutral-200">
                        <h2 class="text-sm font-semibold text-neutral-900">Privacy</h2>
                        <p class="mt-1 text-sm text-neutral-600">Manage your privacy and data preferences.</p>
                    </div>
                    <div class="px-5 py-5 sm:px-6">
                        <label class="text-xs font-semibold uppercase tracking-wide text-neutral-500">Profile Visibility</label>
                        <select wire:model.live="privacyProfileVisibility" class="mt-2 h-10 w-full rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                            @foreach($privacyVisibilityOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @elseif($tab === 'security')
                <div class="rounded-2xl border border-neutral-200 bg-white p-10 text-center shadow-card">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-neutral-100 text-neutral-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.105 0 2-.895 2-2V7a2 2 0 00-4 0v2c0 1.105.895 2 2 2zm0 0v2m8 4v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-base font-semibold text-neutral-900">Security</h2>
                    <p class="mt-2 text-sm text-neutral-600">Use the panel on the right to manage security options.</p>
                </div>
            @else
                <div class="rounded-2xl border border-neutral-200 bg-white shadow-card overflow-hidden">
                    <div class="px-5 py-4 sm:px-6 border-b border-neutral-200">
                        <h2 class="text-sm font-semibold text-neutral-900">Appearance</h2>
                        <p class="mt-1 text-sm text-neutral-600">Customize how Syncora looks for you.</p>
                    </div>
                    <div class="px-5 py-5 sm:px-6">
                        <label class="text-xs font-semibold uppercase tracking-wide text-neutral-500">Theme</label>
                        <select wire:model.live="theme" class="mt-2 h-10 w-full rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                            @foreach($themeOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
        </div>

        <aside class="space-y-6 lg:col-span-4">
            @if($tab === 'security')
                <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                    <h2 class="text-sm font-semibold text-neutral-900">Account Security</h2>
                    <p class="mt-2 text-sm text-neutral-600">Keep your account secure and protected.</p>

                    <div class="mt-5 space-y-4">
                        <div class="flex items-center justify-between gap-4 rounded-2xl border border-neutral-200 bg-white px-4 py-3 shadow-soft">
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-neutral-900">Password</div>
                                <div class="mt-1 text-sm text-neutral-600">••••••••</div>
                            </div>
                            <button type="button" x-data x-on:click.prevent="$dispatch('open-modal', 'student-password-change')" class="inline-flex h-9 items-center justify-center rounded-xl border border-primary-200 bg-white px-3 text-sm font-semibold text-primary-700 shadow-soft transition hover:bg-primary-50">
                                Change
                            </button>
                        </div>

                        <div class="flex items-center justify-between gap-4 rounded-2xl border border-neutral-200 bg-white px-4 py-3 shadow-soft">
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-neutral-900">Two-Factor Authentication</div>
                                <div class="mt-1 text-sm text-neutral-600">Add an extra layer of security.</div>
                            </div>
                            <button type="button" wire:click="openSecurityAction('two_factor')" class="inline-flex h-9 items-center justify-center rounded-xl border border-primary-200 bg-white px-3 text-sm font-semibold text-primary-700 shadow-soft transition hover:bg-primary-50">
                                Enable
                            </button>
                        </div>

                        <div class="flex items-center justify-between gap-4 rounded-2xl border border-neutral-200 bg-white px-4 py-3 shadow-soft">
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-neutral-900">Active Sessions</div>
                                <div class="mt-1 text-sm text-neutral-600">Manage your active sessions.</div>
                            </div>
                            <button type="button" wire:click="openSecurityAction('sessions')" class="inline-flex h-9 items-center justify-center rounded-xl border border-primary-200 bg-white px-3 text-sm font-semibold text-primary-700 shadow-soft transition hover:bg-primary-50">
                                View
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <h2 class="text-sm font-semibold text-neutral-900">Quick Actions</h2>
                <div class="mt-5 space-y-2">
                    <button type="button" wire:click="quickAction('download_data')" class="flex w-full items-center justify-between rounded-xl px-3 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-50">
                        Download My Data
                        <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    <button type="button" wire:click="quickAction('deactivated')" class="flex w-full items-center justify-between rounded-xl px-3 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-50">
                        Deactivated Accounts
                        <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    <button type="button" wire:click="quickAction('devices')" class="flex w-full items-center justify-between rounded-xl px-3 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-50">
                        Connected Devices
                        <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    <button type="button" wire:click="quickAction('delete_account')" class="flex w-full items-center justify-between rounded-xl px-3 py-2 text-sm font-semibold text-danger-600 hover:bg-danger-50">
                        Delete Account
                        <svg class="h-4 w-4 text-danger-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-primary-50 text-primary-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4-.943L3 17l1.115-3.346A7.006 7.006 0 013 10c0-3.866 3.582-7 8-7s8 3.134 8 7z" />
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-sm font-semibold text-neutral-900">Need Help?</h2>
                        <p class="mt-2 text-sm text-neutral-600">If you have any questions or need assistance with your account settings, we’re here to help.</p>
                        <button type="button" wire:click="quickAction('support')" class="mt-4 inline-flex h-11 w-full items-center justify-center rounded-xl border border-primary-200 bg-white px-5 text-sm font-semibold text-primary-700 shadow-soft transition hover:bg-primary-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                            Contact Support
                        </button>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    <x-modal name="student-password-change" focusable maxWidth="xl">
        <div class="p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-neutral-900">Change password</h2>
                    <p class="mt-2 text-sm text-neutral-600">Use a strong password you don’t use elsewhere.</p>
                </div>
                <button type="button" x-on:click="$dispatch('close-modal', 'student-password-change')" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-5">
                @csrf
                @method('put')

                <div>
                    <label class="block text-sm font-semibold text-neutral-900" for="current_password">Current password</label>
                    <div class="mt-2">
                        <input id="current_password" name="current_password" type="password" autocomplete="current-password" class="h-11 w-full rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold text-neutral-900" for="password">New password</label>
                        <div class="mt-2">
                            <input id="password" name="password" type="password" autocomplete="new-password" class="h-11 w-full rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-900" for="password_confirmation">Confirm password</label>
                        <div class="mt-2">
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="h-11 w-full rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <button type="button" x-on:click="$dispatch('close-modal', 'student-password-change')" class="inline-flex h-11 items-center justify-center rounded-xl border border-neutral-200 bg-white px-5 text-sm font-semibold text-neutral-900 shadow-soft transition hover:bg-neutral-50">
                        Cancel
                    </button>
                    <button type="submit" class="inline-flex h-11 items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                        Update password
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
