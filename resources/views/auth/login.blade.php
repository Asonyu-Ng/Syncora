<x-layouts.auth>
    <div class="space-y-8">
        <div class="space-y-4 text-center sm:text-left">
            <span class="inline-flex items-center rounded-full border border-indigo-100 bg-indigo-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-indigo-700">
                Sign in to Syncora
            </span>
            <div class="space-y-2">
                <h1 class="text-3xl font-semibold tracking-tight text-slate-900">Welcome back</h1>
                <p class="mx-auto max-w-md text-sm leading-6 text-slate-600 sm:mx-0">Use your email and password to get back to your dashboard, approvals, and internship workflow activity.</p>
            </div>
        </div>

        <x-auth-session-status :status="session('status')" class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" type="email" name="email" class="mt-1 block w-full" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email address" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <x-input-label for="password" value="Password" />
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-md">Forgot password?</a>
                    @endif
                </div>

                <div class="relative mt-1">
                    <x-text-input id="password" type="password" name="password" class="block w-full pr-16" required autocomplete="current-password" placeholder="Enter your password" />
                    <button type="button" aria-pressed="false" class="absolute inset-y-0 right-0 inline-flex items-center px-3 text-sm font-medium text-slate-500 hover:text-slate-900 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-indigo-500/25 rounded-xl" onclick="const i=document.getElementById('password'); const l=this.querySelector('[data-password-toggle-label]'); if(i){ const show=i.type==='password'; i.type = show ? 'text' : 'password'; if(l){ l.textContent = show ? 'Hide' : 'Show'; } this.setAttribute('aria-pressed', show ? 'true' : 'false'); }">
                        <span data-password-toggle-label>Show</span>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex flex-col gap-3 rounded-[1.5rem] border border-slate-200 bg-slate-50 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                <label class="inline-flex items-center gap-3">
                    <input type="checkbox" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember" @checked(old('remember'))>
                    <span class="text-sm font-medium text-slate-700">Remember me</span>
                </label>
                <span class="text-xs text-slate-500">Private device recommended</span>
            </div>

            <x-primary-button class="h-12 w-full rounded-2xl justify-center text-sm">
                Sign in
            </x-primary-button>
        </form>

        <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50/90 px-4 py-4 text-sm text-slate-600">
            <p class="font-medium text-slate-900">Need help signing in?</p>
            <p class="mt-1">Use the email address linked to your account to access your role-based workspace and keep your browser updated for the best experience.</p>
        </div>

        <p class="border-t border-slate-200 pt-4 text-center text-sm text-slate-600">
            <span>Don't have an account?</span>
            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-md">Register</a>
        </p>
    </div>
</x-layouts.auth>
