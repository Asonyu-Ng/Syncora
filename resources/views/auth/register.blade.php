<x-layouts.auth variant="split" card-width="xl">
    @php
        $roleDetails = [
            'student' => [
                'label' => 'Student',
                'icon' => 'S',
                'pill' => 'Student account',
                'title' => 'Tell us about your academic profile',
                'description' => 'Use your school details so we can prepare the right dashboard, tasks, and internship workflow.',
                'cta' => 'Create Student Account',
            ],
            'supervisor' => [
                'label' => 'Supervisor',
                'icon' => 'P',
                'pill' => 'Supervisor account',
                'title' => 'Set up your supervision workspace',
                'description' => 'Add your institutional role so you can monitor interns, reviews, and progress approvals with the correct permissions.',
                'cta' => 'Create Supervisor Account',
            ],
            'company' => [
                'label' => 'Company',
                'icon' => 'C',
                'pill' => 'Company account',
                'title' => 'Launch your company onboarding space',
                'description' => 'Share your business details so you can post opportunities, manage applicants, and coordinate interns efficiently.',
                'cta' => 'Create Company Account',
            ],
        ];

        $selectedRole = old('role', 'student');
        $selectedRole = array_key_exists($selectedRole, $roleDetails) ? $selectedRole : 'student';
        $selectedRoleConfig = $roleDetails[$selectedRole];
        $inputClass = 'mt-1 block h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-[13px] leading-5 text-neutral-900 shadow-soft placeholder:text-neutral-400 transition focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 disabled:cursor-not-allowed disabled:bg-neutral-100 disabled:text-neutral-500 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-100 dark:placeholder:text-neutral-500 dark:disabled:bg-neutral-900 dark:disabled:text-neutral-500 lg:h-11 lg:px-3.5';
        $passwordInputClass = $inputClass.' pr-16';
    @endphp

    <x-slot:hero>
        <div class="space-y-7">
            <div class="space-y-3.5">
                <span class="inline-flex items-center rounded-full border border-white/15 bg-white/10 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-100">
                    Start with the right workspace
                </span>
                <div class="space-y-3">
                    <h1 class="max-w-xl text-4xl font-semibold leading-[1.04] tracking-tight text-white sm:text-5xl">
                        Create a Syncora account that matches how you manage internships.
                    </h1>
                    <p class="max-w-xl text-[15px] leading-6 text-white/80">
                        Choose a role first, then complete only the details needed for your student, supervisor, or company onboarding flow.
                    </p>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-[1.75rem] border border-white/10 bg-white/10 p-4 backdrop-blur lg:p-4.5">
                    <p class="text-[13px] font-semibold tracking-tight text-white">Role-aware onboarding</p>
                        <p class="mt-1.5 text-[13px] leading-6 text-white/80">
                        Each account type gets the right fields, dashboard setup, and workflow access from the start.
                    </p>
                </div>
                <div class="rounded-[1.75rem] border border-white/10 bg-white/10 p-4 backdrop-blur lg:p-4.5">
                    <p class="text-[13px] font-semibold tracking-tight text-white">Same secure foundation</p>
                        <p class="mt-1.5 text-[13px] leading-6 text-white/80">
                        Registration keeps the same validation, account creation rules, and protected Syncora auth flow.
                    </p>
                </div>
            </div>
        </div>
    </x-slot:hero>

    <div class="space-y-3.5">
        <div class="space-y-2">
            <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-600 dark:border-neutral-800 dark:bg-neutral-900/60 dark:text-neutral-300">
                Create your Syncora account
            </span>
            <div class="space-y-1">
                <h1 class="text-[1.95rem] font-semibold leading-[1.08] tracking-tight text-slate-950 lg:text-[1.9rem] dark:text-neutral-50">{{ __('Start your onboarding') }}</h1>
                <p class="max-w-xl text-[14px] leading-6 text-slate-600 dark:text-neutral-300">{{ __('Choose your role, fill in the matching details, and create your workspace.') }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-3.5 lg:space-y-3.5" id="registration-form">
            @csrf
            <input id="registration-role" type="hidden" name="role" value="{{ $selectedRole }}" />

            <div class="space-y-2 rounded-[1.35rem] border border-slate-200/80 bg-white/85 p-3.5 shadow-sm ring-1 ring-slate-100/80 backdrop-blur sm:p-4 dark:border-neutral-800 dark:bg-neutral-950/70 dark:ring-neutral-800">
                <div class="flex flex-col gap-1.5 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-neutral-400">{{ __('Choose your workspace') }}</p>
                        <p class="text-[13px] leading-5 text-slate-500 dark:text-neutral-400">{{ __('Pick the account type that matches how you will use Syncora.') }}</p>
                    </div>
                    <span id="selected-role-pill" class="inline-flex w-fit rounded-full border border-indigo-100 bg-indigo-50 px-2.5 py-0.5 text-[10px] font-semibold uppercase tracking-[0.08em] text-indigo-700 dark:border-primary-500/20 dark:bg-primary-500/10 dark:text-primary-200">
                        {{ $selectedRoleConfig['pill'] }}
                    </span>
                </div>

                <div class="grid grid-cols-1 gap-2 sm:grid-cols-3" role="radiogroup" aria-label="{{ __('Choose a role') }}">
                    @foreach ($roleDetails as $role => $details)
                        @php($isSelected = $selectedRole === $role)
                        <button
                            type="button"
                            data-role-option
                            data-role-value="{{ $role }}"
                            data-role-pill="{{ $details['pill'] }}"
                            data-role-title="{{ $details['title'] }}"
                            data-role-description="{{ $details['description'] }}"
                            data-role-cta="{{ $details['cta'] }}"
                            data-role-icon="{{ $details['icon'] }}"
                            aria-pressed="{{ $isSelected ? 'true' : 'false' }}"
                            class="{{ $isSelected ? 'border-indigo-200 bg-indigo-50 text-slate-900 ring-1 ring-indigo-100 dark:border-primary-500/30 dark:bg-primary-500/10 dark:text-neutral-50 dark:ring-primary-500/10' : 'border-slate-200 bg-white text-slate-700 hover:border-slate-300 hover:bg-slate-50 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-200 dark:hover:border-neutral-700 dark:hover:bg-neutral-900' }} rounded-[1.05rem] border px-3 py-2.5 text-left transition focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                        >
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex min-w-0 items-center gap-2.5">
                                <span data-role-icon-badge class="{{ $isSelected ? 'bg-slate-900 text-white dark:bg-white dark:text-neutral-950' : 'bg-slate-100 text-slate-600 dark:bg-neutral-900 dark:text-neutral-300' }} inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-xl text-[11px] font-semibold">
                                    {{ $details['icon'] }}
                                </span>
                                    <span class="truncate text-[13px] font-semibold leading-4 tracking-tight">{{ $details['label'] }}</span>
                                </div>
                                <span data-role-status class="{{ $isSelected ? 'bg-indigo-600 dark:bg-primary-400' : 'bg-slate-300 dark:bg-neutral-700' }} inline-flex h-2.5 w-2.5 shrink-0 rounded-full"></span>
                            </div>
                        </button>
                    @endforeach
                </div>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div class="space-y-3 rounded-[1.4rem] border border-slate-200 bg-slate-50/90 p-4 sm:p-4.5 dark:border-neutral-800 dark:bg-neutral-900/40">
                <div class="flex flex-col gap-2 rounded-[1.1rem] border border-white bg-white/90 px-3.5 py-3 shadow-sm ring-1 ring-slate-100 sm:flex-row sm:items-start sm:justify-between dark:border-neutral-800 dark:bg-neutral-950/70 dark:ring-neutral-800">
                    <div class="space-y-1">
                        <span id="selected-role-badge" class="inline-flex rounded-full border border-slate-200 bg-slate-50 px-2.5 py-0.5 text-[10px] font-semibold uppercase tracking-[0.08em] text-slate-600 dark:border-neutral-800 dark:bg-neutral-900/60 dark:text-neutral-300">
                            {{ $selectedRoleConfig['pill'] }}
                        </span>
                        <h2 id="selected-role-title" class="text-[16px] font-semibold leading-6 tracking-tight text-slate-900 dark:text-neutral-50">{{ $selectedRoleConfig['title'] }}</h2>
                        <p id="selected-role-description" class="max-w-xl text-[13px] leading-5 text-slate-600 dark:text-neutral-300">{{ $selectedRoleConfig['description'] }}</p>
                    </div>
                    <span id="selected-role-icon" class="inline-flex h-8 w-8 items-center justify-center rounded-2xl bg-slate-900 text-[11px] font-semibold text-white dark:bg-white dark:text-neutral-950">
                        {{ $selectedRoleConfig['icon'] }}
                    </span>
                </div>

                <div
                    data-role-field-group="student"
                    class="{{ $selectedRole === 'student' ? '' : 'hidden' }} space-y-3"
                    aria-hidden="{{ $selectedRole === 'student' ? 'false' : 'true' }}"
                >
                    <div>
                        <x-input-label for="student-name" :value="__('Full Name')" />
                        <input id="student-name" class="{{ $inputClass }}" type="text" name="name" value="{{ old('name') }}" autocomplete="name" placeholder="Enter your full name" data-required="true" @disabled($selectedRole !== 'student') @required($selectedRole === 'student') {{ $selectedRole === 'student' ? 'autofocus' : '' }} />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="grid gap-3 lg:grid-cols-2">
                        <div>
                            <x-input-label for="student-email" :value="__('Email Address')" />
                            <input id="student-email" class="{{ $inputClass }}" type="email" name="email" value="{{ old('email') }}" autocomplete="username" placeholder="Enter your email address" data-required="true" @disabled($selectedRole !== 'student') @required($selectedRole === 'student') />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="student-institution" :value="__('Institution')" />
                            <input id="student-institution" class="{{ $inputClass }}" type="text" name="institution" value="{{ old('institution') }}" autocomplete="organization" placeholder="Enter your institution" data-required="true" @disabled($selectedRole !== 'student') @required($selectedRole === 'student') />
                            <x-input-error :messages="$errors->get('institution')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="student-department" :value="__('Department')" />
                        <input id="student-department" class="{{ $inputClass }}" type="text" name="department" value="{{ old('department') }}" autocomplete="organization-title" placeholder="Enter your department" data-required="true" @disabled($selectedRole !== 'student') @required($selectedRole === 'student') />
                        <x-input-error :messages="$errors->get('department')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="student-password" :value="__('Password')" />
                        <div class="relative mt-1">
                            <input id="student-password" class="{{ $passwordInputClass }}" type="password" name="password" autocomplete="new-password" placeholder="Create a password" data-required="true" @disabled($selectedRole !== 'student') @required($selectedRole === 'student') />
                            <button type="button" data-password-toggle data-password-target="student-password" aria-pressed="false" class="absolute inset-y-0 right-0 inline-flex items-center px-3 text-sm font-medium text-neutral-500 hover:text-neutral-900 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 rounded-xl dark:text-neutral-400 dark:hover:text-neutral-50">
                                <span data-password-toggle-label>Show</span>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>

                <div
                    data-role-field-group="supervisor"
                    class="{{ $selectedRole === 'supervisor' ? '' : 'hidden' }} space-y-3"
                    aria-hidden="{{ $selectedRole === 'supervisor' ? 'false' : 'true' }}"
                >
                    <div>
                        <x-input-label for="supervisor-name" :value="__('Full Name')" />
                        <input id="supervisor-name" class="{{ $inputClass }}" type="text" name="name" value="{{ old('name') }}" autocomplete="name" placeholder="Enter your full name" data-required="true" @disabled($selectedRole !== 'supervisor') @required($selectedRole === 'supervisor') {{ $selectedRole === 'supervisor' ? 'autofocus' : '' }} />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="grid gap-3 lg:grid-cols-2">
                        <div>
                            <x-input-label for="supervisor-institution" :value="__('Institution')" />
                            <input id="supervisor-institution" class="{{ $inputClass }}" type="text" name="institution" value="{{ old('institution') }}" autocomplete="organization" placeholder="Enter your institution" data-required="true" @disabled($selectedRole !== 'supervisor') @required($selectedRole === 'supervisor') />
                            <x-input-error :messages="$errors->get('institution')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="supervisor-position" :value="__('Position')" />
                            <input id="supervisor-position" class="{{ $inputClass }}" type="text" name="position" value="{{ old('position') }}" autocomplete="organization-title" placeholder="Enter your role or title" data-required="true" @disabled($selectedRole !== 'supervisor') @required($selectedRole === 'supervisor') />
                            <x-input-error :messages="$errors->get('position')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid gap-3 lg:grid-cols-2">
                        <div>
                            <x-input-label for="supervisor-department" :value="__('Department')" />
                            <input id="supervisor-department" class="{{ $inputClass }}" type="text" name="department" value="{{ old('department') }}" autocomplete="organization-title" placeholder="Enter your department" data-required="true" @disabled($selectedRole !== 'supervisor') @required($selectedRole === 'supervisor') />
                            <x-input-error :messages="$errors->get('department')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="supervisor-email" :value="__('Email Address')" />
                            <input id="supervisor-email" class="{{ $inputClass }}" type="email" name="email" value="{{ old('email') }}" autocomplete="username" placeholder="Enter your email address" data-required="true" @disabled($selectedRole !== 'supervisor') @required($selectedRole === 'supervisor') />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="supervisor-password" :value="__('Password')" />
                        <div class="relative mt-1">
                            <input id="supervisor-password" class="{{ $passwordInputClass }}" type="password" name="password" autocomplete="new-password" placeholder="Create a password" data-required="true" @disabled($selectedRole !== 'supervisor') @required($selectedRole === 'supervisor') />
                            <button type="button" data-password-toggle data-password-target="supervisor-password" aria-pressed="false" class="absolute inset-y-0 right-0 inline-flex items-center px-3 text-sm font-medium text-neutral-500 hover:text-neutral-900 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 rounded-xl dark:text-neutral-400 dark:hover:text-neutral-50">
                                <span data-password-toggle-label>Show</span>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>

                <div
                    data-role-field-group="company"
                    class="{{ $selectedRole === 'company' ? '' : 'hidden' }} space-y-3"
                    aria-hidden="{{ $selectedRole === 'company' ? 'false' : 'true' }}"
                >
                    <div>
                        <x-input-label for="company-name" :value="__('Company Name')" />
                        <input id="company-name" class="{{ $inputClass }}" type="text" name="company_name" value="{{ old('company_name') }}" autocomplete="organization" placeholder="Enter your company name" data-required="true" @disabled($selectedRole !== 'company') @required($selectedRole === 'company') {{ $selectedRole === 'company' ? 'autofocus' : '' }} />
                        <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <x-input-label for="company-industry-type" :value="__('Industry Type')" />
                            <input id="company-industry-type" class="{{ $inputClass }}" type="text" name="industry_type" value="{{ old('industry_type') }}" autocomplete="organization-title" placeholder="Enter your industry type" data-required="true" @disabled($selectedRole !== 'company') @required($selectedRole === 'company') />
                            <x-input-error :messages="$errors->get('industry_type')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="company-email" :value="__('Email Address')" />
                            <input id="company-email" class="{{ $inputClass }}" type="email" name="email" value="{{ old('email') }}" autocomplete="username" placeholder="Enter your business email" data-required="true" @disabled($selectedRole !== 'company') @required($selectedRole === 'company') />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="company-location" :value="__('Company Location')" />
                        <input id="company-location" class="{{ $inputClass }}" type="text" name="company_location" value="{{ old('company_location') }}" autocomplete="street-address" placeholder="Enter your company location" data-required="true" @disabled($selectedRole !== 'company') @required($selectedRole === 'company') />
                        <x-input-error :messages="$errors->get('company_location')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="company-password" :value="__('Password')" />
                        <div class="relative mt-1">
                            <input id="company-password" class="{{ $passwordInputClass }}" type="password" name="password" autocomplete="new-password" placeholder="Create a password" data-required="true" @disabled($selectedRole !== 'company') @required($selectedRole === 'company') />
                            <button type="button" data-password-toggle data-password-target="company-password" aria-pressed="false" class="absolute inset-y-0 right-0 inline-flex items-center px-3 text-sm font-medium text-neutral-500 hover:text-neutral-900 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 rounded-xl dark:text-neutral-400 dark:hover:text-neutral-50">
                                <span data-password-toggle-label>Show</span>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <x-primary-button class="h-12 w-full rounded-2xl justify-center text-sm">
                    <span id="selected-role-cta">{{ $selectedRoleConfig['cta'] }}</span>
                </x-primary-button>
            </div>
        </form>

        <p class="border-t border-slate-200 pt-4 text-center text-sm text-slate-600 dark:border-neutral-800 dark:text-neutral-300">
            <span>{{ __('Already registered?') }}</span>
            <a href="{{ route('login') }}" class="rounded-md font-semibold text-primary-600 hover:text-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-white dark:text-primary-200 dark:hover:text-primary-100 dark:focus:ring-offset-neutral-950">
                {{ __('Sign in') }}
            </a>
        </p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const roleInput = document.getElementById('registration-role');
            const roleButtons = Array.from(document.querySelectorAll('[data-role-option]'));
            const roleGroups = Array.from(document.querySelectorAll('[data-role-field-group]'));
            const rolePill = document.getElementById('selected-role-pill');
            const roleBadge = document.getElementById('selected-role-badge');
            const roleTitle = document.getElementById('selected-role-title');
            const roleDescription = document.getElementById('selected-role-description');
            const roleIcon = document.getElementById('selected-role-icon');
            const roleCta = document.getElementById('selected-role-cta');
            const activeButtonClasses = ['border-indigo-200', 'bg-indigo-50', 'text-slate-900', 'ring-1', 'ring-indigo-100'];
            const inactiveButtonClasses = ['border-slate-200', 'bg-white', 'text-slate-700'];

            const updatePasswordToggle = (button, isPassword) => {
                button.setAttribute('aria-pressed', isPassword ? 'false' : 'true');
                const label = button.querySelector('[data-password-toggle-label]');
                if (label) {
                    label.textContent = isPassword ? 'Show' : 'Hide';
                }
            };

            const setRole = (role) => {
                roleInput.value = role;

                roleButtons.forEach((button) => {
                    const active = button.dataset.roleValue === role;
                    button.setAttribute('aria-pressed', active ? 'true' : 'false');
                    button.classList.toggle('hover:border-slate-300', !active);
                    button.classList.toggle('hover:bg-slate-50', !active);

                    activeButtonClasses.forEach((className) => button.classList.toggle(className, active));
                    inactiveButtonClasses.forEach((className) => button.classList.toggle(className, !active));

                    const icon = button.querySelector('[data-role-icon-badge]');
                    if (icon) {
                        icon.classList.toggle('bg-slate-900', active);
                        icon.classList.toggle('text-white', active);
                        icon.classList.toggle('bg-slate-100', !active);
                        icon.classList.toggle('text-slate-600', !active);
                    }

                    const status = button.querySelector('[data-role-status]');
                    if (status) {
                        status.classList.toggle('bg-indigo-600', active);
                        status.classList.toggle('bg-slate-300', !active);
                    }

                    if (active) {
                        if (rolePill) rolePill.textContent = button.dataset.rolePill;
                        if (roleBadge) roleBadge.textContent = button.dataset.rolePill;
                        if (roleTitle) roleTitle.textContent = button.dataset.roleTitle;
                        if (roleDescription) roleDescription.textContent = button.dataset.roleDescription;
                        if (roleIcon) roleIcon.textContent = button.dataset.roleIcon;
                        if (roleCta) roleCta.textContent = button.dataset.roleCta;
                    }
                });

                roleGroups.forEach((group) => {
                    const active = group.dataset.roleFieldGroup === role;
                    group.classList.toggle('hidden', !active);
                    group.setAttribute('aria-hidden', active ? 'false' : 'true');

                    group.querySelectorAll('input, select, textarea').forEach((field) => {
                        field.disabled = !active;
                        field.required = active && field.dataset.required === 'true';
                    });
                });
            };

            roleButtons.forEach((button) => {
                button.addEventListener('click', () => setRole(button.dataset.roleValue));
            });

            document.querySelectorAll('[data-password-toggle]').forEach((button) => {
                button.addEventListener('click', () => {
                    const target = document.getElementById(button.dataset.passwordTarget);
                    if (!target) {
                        return;
                    }

                    const isPassword = target.type === 'password';
                    target.type = isPassword ? 'text' : 'password';
                    updatePasswordToggle(button, !isPassword);
                });

                updatePasswordToggle(button, true);
            });

            setRole(roleInput.value || 'student');
        });
    </script>
</x-layouts.auth>
