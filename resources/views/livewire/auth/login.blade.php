<div class="space-y-6">
    <div class="space-y-2">
        <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Welcome Back</h1>
        <p class="text-sm text-slate-600">Sign in to continue to your dashboard</p>
    </div>

    <x-auth-session-status :status="session('status')" />

    <form wire:submit.prevent="authenticate" class="space-y-4">
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" class="mt-1 block w-full" wire:model="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <div class="flex items-center justify-between">
                <x-input-label for="password" value="Password" />
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-md">Forgot password?</a>
                @endif
            </div>

            <div class="relative mt-1">
                <x-text-input id="password" type="password" class="block w-full pr-14" wire:model="password" required autocomplete="current-password" x-show="!show" x-cloak />
                <x-text-input id="password_text" type="text" class="block w-full pr-14" wire:model="password" required autocomplete="current-password" x-show="show" x-cloak />
                <button type="button" class="absolute inset-y-0 right-0 inline-flex items-center px-3 text-sm font-medium text-slate-600 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-md" x-on:click="show = !show" x-bind:aria-pressed="show.toString()" x-bind:aria-label="show ? 'Hide password' : 'Show password'">
                    <span x-text="show ? 'Hide' : 'Show'"></span>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label class="inline-flex items-center gap-2">
                <input type="checkbox" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500" wire:model="remember">
                <span class="text-sm text-slate-600">Remember me</span>
            </label>
        </div>

        <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-indigo-600/30 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-70" wire:loading.attr="disabled" wire:target="authenticate">
            <span wire:loading.remove wire:target="authenticate">Sign in</span>
            <span wire:loading wire:target="authenticate">Signing in…</span>
        </button>
    </form>

    <p class="text-center text-sm text-slate-600">
        <span>New to {{ config('app.name', 'Syncora') }}?</span>
        <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-md">Create an account</a>
    </p>
</div>
