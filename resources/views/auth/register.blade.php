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
        $inputClass = 'mt-1 block h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-[13px] leading-5 text-neutral-900 shadow-soft placeholder:text-neutral-400 transition focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 disabled:cursor-not-allowed disabled:bg-neutral-100 disabled:text-neutral-500 lg:h-11 lg:px-3.5';
        $passwordInputClass = $inputClass.' pr-16';
    @endphp

    <x-slot:hero>
        <div class="space-y-7">
            <div class="space-y-3.5">
                <span class="inline-flex items-center rounded-full border border-white/15 bg-white/10 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-100">
                    Start with the right workspace
                </span>
                <div class="space-y-3">
                    <h1 class="max-w-xl text-4xl font-semibold leading-[1.02] tracking-tight text-white sm:text-5xl">
                        Create a Syncora account that matches how you manage internships.
                    </h1>
                    <p class="max-w-xl text-[15px] leading-6 text-slate-300">
                        Choose a role first, then complete only the details needed for your student, supervisor, or company onboarding flow.
                    </p>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-[1.75rem] border border-white/10 bg-white/10 p-4 backdrop-blur lg:p-4.5">
                    <p class="text-[13px] font-semibold tracking-tight text-white">Role-aware onboarding</p>
                    <p class="mt-1.5 text-[13px] leading-6 text-slate-300">
                        Each account type gets the right fields, dashboard setup, and workflow access from the start.
                    </p>
                </div>
                <div class="rounded-[1.75rem] border border-white/10 bg-white/10 p-4 backdrop-blur lg:p-4.5">
                    <p class="text-[13px] font-semibold tracking-tight text-white">Same secure foundation</p>
                    <p class="mt-1.5 text-[13px] leading-6 text-slate-300">
                        Registration keeps the same validation, account creation rules, and protected Syncora auth flow.
                    </p>
                </div>
            </div>
        </div>
    </x-slot:hero>

    <div class="space-y-4">
        <div class="space-y-2.5">
            <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-600">
                Create your Syncora account
            </span>
            <div class="space-y-1.5">
                <h1 class="text-3xl font-semibold leading-[1.08] tracking-tight text-slate-950 lg:text-[1.8rem]">{{ __('Start your onboarding') }}</h1>
                <p class="max-w-xl text-[14px] leading-6 text-slate-600">{{ __('Choose a role, complete the matching details, and create your workspace.') }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4.5 lg:space-y-4" id="registration-form">
            @csrf
            <input id="registration-role" type="hidden" name="role" value="{{ $selectedRole }}" />

            <div class="space-y-2.5 rounded-[1.35rem] border border-slate-200/80 bg-white/80 p-4 shadow-sm ring-1 ring-slate-100/80 backdrop-blur">
                <div class="flex flex-col gap-1.5 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500">{{ __('Choose your workspace') }}</p>
                        <p class="text-[13px] leading-5 text-slate-500">{{ __('Pick the account type that matches how you will use Syncora.') }}</p>
                    </div>
                    <span id="selected-role-pill" class="inline-flex w-fit rounded-full border border-indigo-100 bg-indigo-50 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.12em] text-indigo-700 lg:py-0.5">
                        {{ $selectedRoleConfig['pill'] }}
                    </span>
                </div>

                <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 xl:grid-cols-3" role="radiogroup" aria-label="{{ __('Choose a role') }}">
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
                            class="{{ $isSelected ? 'border-indigo-200 bg-indigo-50/80 text-slate-900 shadow-lg shadow-indigo-100/50 ring-1 ring-indigo-100' : 'border-slate-200 bg-white text-slate-700 hover:border-slate-300 hover:bg-slate-50' }} h-full rounded-[1.05rem] border px-3 py-2.5 text-left transition focus:outline-none focus:ring-4 focus:ring-indigo-500/20"
                        >
                            <div class="flex items-center gap-2.5">
                                <span data-role-icon-badge class="{{ $isSelected ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600' }} inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-xl text-[11px] font-semibold">
                                    {{ $details['icon'] }}
                                </span>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-[13px] font-semibold leading-4 tracking-tight">{{ $details['label'] }}</span>
                                        <span data-role-status class="{{ $isSelected ? 'bg-white text-indigo-700 ring-1 ring-indigo-100' : 'bg-slate-100 text-slate-500' }} rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.08em]">
                                            {{ $isSelected ? 'Selected' : 'Choose' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div class="space-y-3.5 rounded-[1.4rem] border border-slate-200 bg-slate-50/90 p-4 sm:p-5">
                <div class="rounded-[1.1rem] border border-white bg-white/90 p-4 shadow-sm ring-1 ring-slate-100">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <span id="selected-role-badge" class="inline-flex rounded-full border border-slate-200 bg-slate-50 px-2.5 py-0.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-600">
                                {{ $selectedRoleConfig['pill'] }}
                            </span>
                            <h2 id="selected-role-title" class="mt-2 text-[17px] font-semibold leading-6 tracking-tight text-slate-900">{{ $selectedRoleConfig['title'] }}</h2>
                            <p id="selected-role-description" class="mt-1.5 max-w-xl text-[13px] leading-5 text-slate-600">{{ $selectedRoleConfig['description'] }}</p>
                        </div>
                        <span id="selected-role-icon" class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-900 text-xs font-semibold text-white">
                            {{ $selectedRoleConfig['icon'] }}
                        </span>
                    </div>
                </div>

                <div
                    data-role-field-group="student"
                    class="{{ $selectedRole === 'student' ? '' : 'hidden' }} space-y-3.5"
                    aria-hidden="{{ $selectedRole === 'student' ? 'false' : 'true' }}"
                >
                    <div>
                        <x-input-label for="student-name" :value="__('Full Name')" />
                        <input id="student-name" class="{{ $inputClass }}" type="text" name="name" value="{{ old('name') }}" autocomplete="name" placeholder="Enter your full name" data-required="true" @disabled($selectedRole !== 'student') @required($selectedRole === 'student') {{ $selectedRole === 'student' ? 'autofocus' : '' }} />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="grid gap-3.5 lg:grid-cols-2">
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
                            <button type="button" data-password-toggle data-password-target="student-password" aria-pressed="false" class="absolute inset-y-0 right-0 inline-flex items-center px-3 text-sm font-medium text-slate-500 hover:text-slate-900 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-indigo-500/25 rounded-xl">
                                <span data-password-toggle-label>Show</span>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>

                <div
                    data-role-field-group="supervisor"
                    class="{{ $selectedRole === 'supervisor' ? '' : 'hidden' }} space-y-3.5"
                    aria-hidden="{{ $selectedRole === 'supervisor' ? 'false' : 'true' }}"
                >
                    <div>
                        <x-input-label for="supervisor-name" :value="__('Full Name')" />
                        <input id="supervisor-name" class="{{ $inputClass }}" type="text" name="name" value="{{ old('name') }}" autocomplete="name" placeholder="Enter your full name" data-required="true" @disabled($selectedRole !== 'supervisor') @required($selectedRole === 'supervisor') {{ $selectedRole === 'supervisor' ? 'autofocus' : '' }} />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="grid gap-3.5 lg:grid-cols-2">
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

                    <div class="grid gap-3.5 lg:grid-cols-2">
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
                            <button type="button" data-password-toggle data-password-target="supervisor-password" aria-pressed="false" class="absolute inset-y-0 right-0 inline-flex items-center px-3 text-sm font-medium text-slate-500 hover:text-slate-900 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-indigo-500/25 rounded-xl">
                                <span data-password-toggle-label>Show</span>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>

                <div
                    data-role-field-group="company"
                    class="{{ $selectedRole === 'company' ? '' : 'hidden' }} space-y-3.5"
                    aria-hidden="{{ $selectedRole === 'company' ? 'false' : 'true' }}"
                >
                    <div>
                        <x-input-label for="company-name" :value="__('Company Name')" />
                        <input id="company-name" class="{{ $inputClass }}" type="text" name="company_name" value="{{ old('company_name') }}" autocomplete="organization" placeholder="Enter your company name" data-required="true" @disabled($selectedRole !== 'company') @required($selectedRole === 'company') {{ $selectedRole === 'company' ? 'autofocus' : '' }} />
                        <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                    </div>

                    <div class="grid gap-3.5 sm:grid-cols-2">
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
                            <button type="button" data-password-toggle data-password-target="company-password" aria-pressed="false" class="absolute inset-y-0 right-0 inline-flex items-center px-3 text-sm font-medium text-slate-500 hover:text-slate-900 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-indigo-500/25 rounded-xl">
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

                <div class="rounded-[1.1rem] border border-slate-200 bg-slate-50/90 px-4 py-3 text-[13px] leading-5 text-slate-600">
                    <p class="font-medium tracking-tight text-slate-900">{{ __('Role-aware onboarding') }}</p>
                    <p class="mt-1">{{ __('Your role determines the dashboard experience and profile setup you will see after registration.') }}</p>
                </div>
            </div>
        </form>

        <p class="border-t border-slate-200 pt-4 text-center text-sm text-slate-600">
            <span>{{ __('Already registered?') }}</span>
            <a href="{{ route('login') }}" class="rounded-md font-semibold text-indigo-600 hover:text-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
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
            const activeButtonClasses = ['border-indigo-200', 'bg-indigo-50/80', 'text-slate-900', 'shadow-lg', 'shadow-indigo-100/50', 'ring-1', 'ring-indigo-100'];
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
                        status.textContent = active ? 'Selected' : 'Choose';
                        status.classList.toggle('bg-white', active);
                        status.classList.toggle('text-indigo-700', active);
                        status.classList.toggle('ring-1', active);
                        status.classList.toggle('ring-indigo-100', active);
                        status.classList.toggle('bg-slate-100', !active);
                        status.classList.toggle('text-slate-500', !active);
                    }

                    const description = button.querySelector('p');
                    if (description) {
                        description.classList.toggle('text-slate-600', active);
                        description.classList.toggle('text-slate-500', !active);
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
