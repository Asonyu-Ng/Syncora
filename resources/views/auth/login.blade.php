<x-layouts.auth>
    <div class="space-y-6">
        <div class="space-y-2">
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Welcome Back</h1>
            <p class="text-sm text-slate-600">Sign in to continue to your dashboard</p>
        </div>

        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" type="email" name="email" class="mt-1 block w-full" :value="old('email')" required autofocus autocomplete="username" />
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
                    <x-text-input id="password" type="password" name="password" class="block w-full pr-14" required autocomplete="current-password" />
                    <button type="button" class="absolute inset-y-0 right-0 inline-flex items-center px-3 text-sm font-medium text-slate-600 hover:text-slate-900 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-indigo-500/25 rounded-xl" onclick="const i=document.getElementById('password'); if(i){ i.type = i.type === 'password' ? 'text' : 'password'; }">
                        <span>Show</span>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="text-sm text-slate-600">Remember me</span>
                </label>
            </div>

            <x-primary-button class="w-full">
                Sign in
            </x-primary-button>
        </form>

        <p class="text-center text-sm text-slate-600">
            <span>Don't have an account?</span>
            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-md">Register</a>
        </p>
    </div>
</x-layouts.auth>
