<x-layouts.auth variant="split">
    <x-slot:hero>
        <div class="space-y-6">
            <div class="space-y-3">
                <span class="inline-flex items-center rounded-full border border-white/15 bg-white/10 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-100">
                    Welcome back
                </span>
                <div class="space-y-3">
                    <h1 class="max-w-xl text-4xl font-semibold leading-[1.04] tracking-tight text-white sm:text-5xl">
                        Manage internships, approvals, and reporting in one focused workspace.
                    </h1>
                    <p class="max-w-xl text-[15px] leading-6 text-white/80">
                        Syncora keeps students, supervisors, and companies aligned with one secure sign-in experience for daily internship operations.
                    </p>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-[1.75rem] border border-white/10 bg-white/10 p-4 backdrop-blur">
                    <p class="text-[13px] font-semibold tracking-tight text-white">Clear workflow visibility</p>
                    <p class="mt-1.5 text-[13px] leading-6 text-slate-300">
                        Review placements, submissions, monitoring tasks, and shared updates without switching tools.
                    </p>
                </div>
                <div class="rounded-[1.75rem] border border-white/10 bg-white/10 p-4 backdrop-blur">
                    <p class="text-[13px] font-semibold tracking-tight text-white">Consistent protected access</p>
                    <p class="mt-1.5 text-[13px] leading-6 text-slate-300">
                        Existing validation, redirects, and account security stay exactly the same behind the redesigned screen.
                    </p>
                </div>
            </div>
        </div>
    </x-slot:hero>

    <div class="space-y-6">
        <div class="space-y-3">
            <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-600 dark:border-neutral-800 dark:bg-neutral-900/60 dark:text-neutral-300">
                Sign in to Syncora
            </span>
            <div class="space-y-2">
                <h2 class="text-[1.95rem] font-semibold leading-[1.08] tracking-tight text-slate-950 dark:text-neutral-50">Access your account</h2>
                <p class="max-w-md text-[14px] leading-6 text-slate-600 dark:text-neutral-300">
                    Enter your email and password to continue to your dashboard, approvals, and internship workflow activity.
                </p>
            </div>
        </div>

        <x-auth-session-status :status="session('status')" class="rounded-[1.25rem] border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-200" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4.5">
            @csrf

            <div class="space-y-2">
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" type="email" name="email" class="block w-full" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email address" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="space-y-2">
                <div class="flex items-center justify-between gap-4">
                    <x-input-label for="password" value="Password" />
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="rounded-md text-sm font-medium text-primary-600 hover:text-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-white dark:text-primary-200 dark:hover:text-primary-100 dark:focus:ring-offset-neutral-950">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <div class="relative">
                    <x-text-input id="password" type="password" name="password" class="block w-full pr-16" required autocomplete="current-password" placeholder="Enter your password" />
                    <button type="button" aria-pressed="false" class="absolute inset-y-0 right-0 inline-flex items-center px-3 text-sm font-medium text-neutral-500 hover:text-neutral-900 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 rounded-xl dark:text-neutral-400 dark:hover:text-neutral-50" onclick="const i=document.getElementById('password'); const l=this.querySelector('[data-password-toggle-label]'); if(i){ const show=i.type==='password'; i.type = show ? 'text' : 'password'; if(l){ l.textContent = show ? 'Hide' : 'Show'; } this.setAttribute('aria-pressed', show ? 'true' : 'false'); }">
                        <span data-password-toggle-label>Show</span>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex flex-col gap-2.5 rounded-[1.5rem] border border-slate-200 bg-slate-50 px-4 py-3 sm:flex-row sm:items-center sm:justify-between dark:border-neutral-800 dark:bg-neutral-900/60">
                <label class="inline-flex items-center gap-3">
                    <input type="checkbox" class="rounded border-neutral-300 text-primary-600 shadow-sm focus:ring-primary-500/20 dark:border-neutral-700 dark:bg-neutral-950" name="remember" @checked(old('remember'))>
                    <span class="text-[14px] font-medium text-slate-700 dark:text-neutral-200">Remember me</span>
                </label>
                <span class="text-[12px] leading-5 text-slate-500 dark:text-neutral-400">Private device recommended</span>
            </div>

            <x-primary-button class="h-12 w-full rounded-[1.25rem] justify-center text-sm shadow-[0_18px_40px_-20px_rgba(79,70,229,0.65)]">
                Sign in
            </x-primary-button>
        </form>

        <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50/90 px-4 py-3.5 text-[14px] leading-6 text-slate-600 dark:border-neutral-800 dark:bg-neutral-900/40 dark:text-neutral-300">
            <p class="font-medium tracking-tight text-slate-900 dark:text-neutral-50">Need help signing in?</p>
            <p class="mt-1">
                Use the email address linked to your account to access your role-based workspace and keep your browser updated for the best experience.
            </p>
        </div>

        <p class="border-t border-slate-200 pt-4 text-center text-sm text-slate-600 dark:border-neutral-800 dark:text-neutral-300">
            <span>Don't have an account?</span>
            <a href="{{ route('register') }}" class="rounded-md font-semibold text-primary-600 hover:text-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-white dark:text-primary-200 dark:hover:text-primary-100 dark:focus:ring-offset-neutral-950">
                Register
            </a>
        </p>
    </div>
</x-layouts.auth>
