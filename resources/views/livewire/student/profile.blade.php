<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div class="min-w-0">
            <h1 class="text-3xl font-semibold text-neutral-900 tracking-tight">My Profile</h1>
            <p class="mt-2 text-sm text-neutral-600">View and manage your personal information and academic details.</p>
        </div>

        <button type="button" wire:click="openEditProfile" class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-primary-200 bg-white px-5 text-sm font-semibold text-primary-700 shadow-soft transition hover:bg-primary-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-1 0v14m0-14l-7 7m7-7l7 7" />
            </svg>
            Edit Profile
        </button>
    </div>

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
            @if($tab === 'profile')
                <div class="rounded-2xl border border-neutral-200 bg-white shadow-card overflow-hidden">
                    <div class="p-5 sm:p-6">
                        <div class="flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between">
                            <div class="flex min-w-0 items-start gap-4">
                                <div class="relative">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-neutral-100 text-lg font-semibold text-neutral-700">
                                        {{ Str::of($profileCard['name'])->trim()->substr(0, 1)->upper() }}
                                    </div>
                                    <button type="button" class="absolute -bottom-2 -right-2 inline-flex h-8 w-8 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h2l2-2h6l2 2h2a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <div class="text-lg font-semibold text-neutral-900">{{ $profileCard['name'] }}</div>
                                        <span class="inline-flex items-center rounded-full bg-success-50 px-3 py-1 text-xs font-semibold text-success-700 ring-1 ring-inset ring-success-100">
                                            {{ $profileCard['status'] }}
                                        </span>
                                    </div>

                                    <div class="mt-3 space-y-2 text-sm font-semibold text-neutral-700">
                                        @if($profileCard['email'])
                                            <div class="flex items-center gap-2">
                                                <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l9 6 9-6v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 8l-9 6-9-6 9-6 9 6z" />
                                                </svg>
                                                <span class="truncate">{{ $profileCard['email'] }}</span>
                                            </div>
                                        @endif
                                        @if($profileCard['phone'])
                                            <div class="flex items-center gap-2">
                                                <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.5 4.5a1 1 0 01-.502 1.21l-2.257 1.129a11.042 11.042 0 005.516 5.516l1.129-2.257a1 1 0 011.21-.502l4.5 1.5A1 1 0 0121 17.72V21a2 2 0 01-2 2h-1C9.163 23 1 14.837 1 4V3a2 2 0 012-2z" />
                                                </svg>
                                                <span class="truncate">{{ $profileCard['phone'] }}</span>
                                            </div>
                                        @endif
                                        @if($profileCard['location'])
                                            <div class="flex items-center gap-2">
                                                <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11a3 3 0 100-6 3 3 0 000 6z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 11c0 7-7.5 11-7.5 11S4.5 18 4.5 11a7.5 7.5 0 1115 0z" />
                                                </svg>
                                                <span class="truncate">{{ $profileCard['location'] }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="grid w-full gap-4 sm:w-auto sm:min-w-[280px] sm:grid-cols-2">
                                <div class="space-y-1">
                                    <div class="text-xs font-semibold uppercase tracking-wide text-neutral-500">Member Since</div>
                                    <div class="text-sm font-semibold text-neutral-900">{{ $profileCard['member_since'] ?? '—' }}</div>
                                </div>
                                <div class="space-y-1">
                                    <div class="text-xs font-semibold uppercase tracking-wide text-neutral-500">Student ID (Matricule)</div>
                                    <div class="text-sm font-semibold text-neutral-900">{{ $profileCard['matricule'] ?? '—' }}</div>
                                </div>
                                <div class="space-y-1">
                                    <div class="text-xs font-semibold uppercase tracking-wide text-neutral-500">Date of Birth</div>
                                    <div class="text-sm font-semibold text-neutral-900">—</div>
                                </div>
                                <div class="space-y-1">
                                    <div class="text-xs font-semibold uppercase tracking-wide text-neutral-500">Gender</div>
                                    <div class="text-sm font-semibold text-neutral-900">—</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-sm font-semibold text-neutral-900">About Me</h2>
                            <p class="mt-2 text-sm text-neutral-600">{{ $aboutCard['body'] }}</p>
                        </div>
                        <button type="button" wire:click="openEditProfile" class="inline-flex h-9 items-center justify-center gap-2 rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2M12 4v2m-7 8h14m-8 8h2" />
                            </svg>
                            Edit
                        </button>
                    </div>
                </div>

                <div class="rounded-2xl border border-neutral-200 bg-white shadow-card overflow-hidden">
                    <div class="flex items-start justify-between gap-4 border-b border-neutral-200 px-5 py-4 sm:px-6">
                        <h2 class="text-sm font-semibold text-neutral-900">Contact Information</h2>
                        <button type="button" wire:click="openEditProfile" class="inline-flex h-9 items-center justify-center gap-2 rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4 12.5-12.5z" />
                            </svg>
                            Edit
                        </button>
                    </div>
                    <div class="divide-y divide-neutral-100">
                        <div class="grid grid-cols-1 gap-2 px-5 py-4 sm:grid-cols-3 sm:items-center sm:px-6">
                            <div class="text-xs font-semibold uppercase tracking-wide text-neutral-500">Email Address</div>
                            <div class="text-sm font-semibold text-neutral-900 sm:col-span-2">{{ $contactCard['email'] ?? '—' }}</div>
                        </div>
                        <div class="grid grid-cols-1 gap-2 px-5 py-4 sm:grid-cols-3 sm:items-center sm:px-6">
                            <div class="text-xs font-semibold uppercase tracking-wide text-neutral-500">Phone Number</div>
                            <div class="text-sm font-semibold text-neutral-900 sm:col-span-2">{{ $contactCard['phone'] ?? '—' }}</div>
                        </div>
                        <div class="grid grid-cols-1 gap-2 px-5 py-4 sm:grid-cols-3 sm:items-center sm:px-6">
                            <div class="text-xs font-semibold uppercase tracking-wide text-neutral-500">Alternative Email</div>
                            <div class="text-sm font-semibold text-neutral-900 sm:col-span-2">{{ $contactCard['alternative_email'] ?? '—' }}</div>
                        </div>
                        <div class="grid grid-cols-1 gap-2 px-5 py-4 sm:grid-cols-3 sm:items-center sm:px-6">
                            <div class="text-xs font-semibold uppercase tracking-wide text-neutral-500">Address</div>
                            <div class="text-sm font-semibold text-neutral-900 sm:col-span-2">{{ $contactCard['address'] ?? '—' }}</div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-neutral-200 bg-white shadow-card overflow-hidden">
                    <div class="flex items-start justify-between gap-4 border-b border-neutral-200 px-5 py-4 sm:px-6">
                        <h2 class="text-sm font-semibold text-neutral-900">Social Links</h2>
                        <button type="button" wire:click="openEditProfile" class="inline-flex h-9 items-center justify-center gap-2 rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4 12.5-12.5z" />
                            </svg>
                            Edit
                        </button>
                    </div>
                    <div class="grid grid-cols-1 gap-4 px-5 py-5 sm:grid-cols-3 sm:px-6">
                        <a href="https://{{ $socialCard['linkedin'] }}" target="_blank" rel="noreferrer" class="flex items-center gap-3 rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-info-50 text-info-700">in</span>
                            <span class="truncate">{{ $socialCard['linkedin'] }}</span>
                        </a>
                        <a href="https://{{ $socialCard['github'] }}" target="_blank" rel="noreferrer" class="flex items-center gap-3 rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-neutral-900 text-white">GH</span>
                            <span class="truncate">{{ $socialCard['github'] }}</span>
                        </a>
                        <a href="https://{{ $socialCard['twitter'] }}" target="_blank" rel="noreferrer" class="flex items-center gap-3 rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-info-50 text-info-700">X</span>
                            <span class="truncate">{{ $socialCard['twitter'] }}</span>
                        </a>
                    </div>
                </div>
            @elseif($tab === 'academic')
                <div class="rounded-2xl border border-neutral-200 bg-white shadow-card overflow-hidden">
                    <div class="px-5 py-4 sm:px-6 border-b border-neutral-200">
                        <h2 class="text-sm font-semibold text-neutral-900">Academic Information</h2>
                        <p class="mt-1 text-sm text-neutral-600">Update your academic details used for internship verification.</p>
                    </div>
                    <div class="divide-y divide-neutral-100">
                        <div class="grid grid-cols-1 gap-2 px-5 py-4 sm:grid-cols-3 sm:items-center sm:px-6">
                            <div class="text-xs font-semibold uppercase tracking-wide text-neutral-500">Institution</div>
                            <div class="text-sm font-semibold text-neutral-900 sm:col-span-2">{{ $academicSummary['institution'] ?? '—' }}</div>
                        </div>
                        <div class="grid grid-cols-1 gap-2 px-5 py-4 sm:grid-cols-3 sm:items-center sm:px-6">
                            <div class="text-xs font-semibold uppercase tracking-wide text-neutral-500">Faculty</div>
                            <div class="text-sm font-semibold text-neutral-900 sm:col-span-2">{{ $academicSummary['faculty'] ?? '—' }}</div>
                        </div>
                        <div class="grid grid-cols-1 gap-2 px-5 py-4 sm:grid-cols-3 sm:items-center sm:px-6">
                            <div class="text-xs font-semibold uppercase tracking-wide text-neutral-500">Department</div>
                            <div class="text-sm font-semibold text-neutral-900 sm:col-span-2">{{ $academicSummary['department'] ?? '—' }}</div>
                        </div>
                        <div class="grid grid-cols-1 gap-2 px-5 py-4 sm:grid-cols-3 sm:items-center sm:px-6">
                            <div class="text-xs font-semibold uppercase tracking-wide text-neutral-500">Level</div>
                            <div class="text-sm font-semibold text-neutral-900 sm:col-span-2">{{ $academicSummary['level'] ?? '—' }}</div>
                        </div>
                        <div class="grid grid-cols-1 gap-2 px-5 py-4 sm:grid-cols-3 sm:items-center sm:px-6">
                            <div class="text-xs font-semibold uppercase tracking-wide text-neutral-500">Academic Year</div>
                            <div class="text-sm font-semibold text-neutral-900 sm:col-span-2">{{ $academicSummary['academic_year'] ?? '—' }}</div>
                        </div>
                    </div>
                </div>
            @elseif($tab === 'documents')
                <div class="rounded-2xl border border-dashed border-neutral-200 bg-white p-10 text-center shadow-card">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-neutral-100 text-neutral-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 6H7a2 2 0 01-2-2V4a2 2 0 012-2h7l5 5v13a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-base font-semibold text-neutral-900">Documents</h2>
                    <p class="mt-2 text-sm text-neutral-600">Upload verification documents and certificates here.</p>
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-neutral-200 bg-white p-10 text-center shadow-card">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-neutral-100 text-neutral-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-base font-semibold text-neutral-900">Preferences</h2>
                    <p class="mt-2 text-sm text-neutral-600">Set your notification and dashboard preferences.</p>
                </div>
            @endif
        </div>

        <aside class="space-y-6 lg:col-span-4">
            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-primary-50 text-primary-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.5c-2.75 0-5.25-.99-7.16-2.922L12 14z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h2 class="text-sm font-semibold text-neutral-900">Academic Summary</h2>
                        <div class="mt-4 space-y-3 text-sm font-semibold text-neutral-700">
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-neutral-500">Institution</span>
                                <span class="text-neutral-900 truncate">{{ $academicSummary['institution'] ?? '—' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-neutral-500">Faculty</span>
                                <span class="text-neutral-900 truncate">{{ $academicSummary['faculty'] ?? '—' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-neutral-500">Department</span>
                                <span class="text-neutral-900 truncate">{{ $academicSummary['department'] ?? '—' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-neutral-500">Level</span>
                                <span class="text-neutral-900 truncate">{{ $academicSummary['level'] ?? '—' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-neutral-500">Academic Year</span>
                                <span class="text-neutral-900 truncate">{{ $academicSummary['academic_year'] ?? '—' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-neutral-100 text-neutral-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.105 0 2-.895 2-2V7a2 2 0 00-4 0v2c0 1.105.895 2 2 2zm0 0v2m8 4v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-sm font-semibold text-neutral-900">Account Security</h2>
                        <p class="mt-2 text-sm text-neutral-600">Keep your account secure and protect your personal information.</p>
                        <a href="{{ route('profile.edit') }}" class="mt-4 inline-flex h-11 w-full items-center justify-center rounded-xl border border-primary-200 bg-white px-5 text-sm font-semibold text-primary-700 shadow-soft transition hover:bg-primary-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                            Change Password
                        </a>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <h2 class="text-sm font-semibold text-neutral-900">Profile Completion</h2>
                <div class="mt-6 flex items-center gap-6">
                    <div class="relative h-28 w-28 shrink-0 rounded-full" style="background: {{ $completion['style'] }};">
                        <div class="absolute inset-3 rounded-full bg-white"></div>
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                            <div class="text-2xl font-semibold text-neutral-900">{{ $completion['percent'] }}%</div>
                            <div class="text-xs font-semibold text-neutral-500">Complete</div>
                        </div>
                    </div>

                    <div class="min-w-0 space-y-2 text-sm font-semibold">
                        @foreach($completion['items'] as $item)
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-neutral-700">{{ $item['label'] }}</span>
                                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full {{ $item['done'] ? 'bg-success-50 text-success-700' : 'bg-neutral-100 text-neutral-400' }}">
                                    @if($item['done'])
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    @else
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    @endif
                                </span>
                            </div>
                        @endforeach
                        <button type="button" wire:click="openEditProfile" class="pt-2 text-left text-sm font-semibold text-primary-700 hover:text-primary-800">
                            Complete your profile to 100% →
                        </button>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    <x-modal name="student-profile-edit" focusable maxWidth="2xl">
        <div class="p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-neutral-900">Edit profile</h2>
                    <p class="mt-2 text-sm text-neutral-600">Update your personal and academic details.</p>
                </div>
                <button type="button" x-on:click="$dispatch('close-modal', 'student-profile-edit')" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-500 shadow-soft transition hover:bg-neutral-50 hover:text-neutral-900">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mt-6 space-y-5">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold text-neutral-900" for="profile-name">Full name</label>
                        <div class="mt-2">
                            <input id="profile-name" type="text" wire:model.defer="name" class="h-11 w-full rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-900" for="profile-phone">Phone</label>
                        <div class="mt-2">
                            <input id="profile-phone" type="text" wire:model.defer="phone" class="h-11 w-full rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-neutral-900" for="profile-address">Address</label>
                    <div class="mt-2">
                        <input id="profile-address" type="text" wire:model.defer="address" class="h-11 w-full rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-semibold text-neutral-900" for="profile-level">Level</label>
                        <div class="mt-2">
                            <input id="profile-level" type="text" wire:model.defer="level" class="h-11 w-full rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                            <x-input-error :messages="$errors->get('level')" class="mt-2" />
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-neutral-900" for="profile-department">Department</label>
                        <div class="mt-2">
                            <input id="profile-department" type="text" wire:model.defer="department" class="h-11 w-full rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                            <x-input-error :messages="$errors->get('department')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-neutral-900" for="profile-university">Institution</label>
                    <div class="mt-2">
                        <input id="profile-university" type="text" wire:model.defer="university" class="h-11 w-full rounded-xl border border-neutral-200 bg-white px-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                        <x-input-error :messages="$errors->get('university')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-neutral-900" for="profile-bio">About me</label>
                    <div class="mt-2">
                        <textarea id="profile-bio" rows="5" wire:model.defer="bio" class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-3 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"></textarea>
                        <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-end">
                <button type="button" x-on:click="$dispatch('close-modal', 'student-profile-edit')" class="inline-flex h-11 items-center justify-center rounded-xl border border-neutral-200 bg-white px-5 text-sm font-semibold text-neutral-900 shadow-soft transition hover:bg-neutral-50">
                    Cancel
                </button>
                <button type="button" wire:click="saveProfile" class="inline-flex h-11 items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                    Save changes
                </button>
            </div>
        </div>
    </x-modal>
</div>
