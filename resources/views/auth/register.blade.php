<x-layouts.auth>
    <div class="space-y-6">
        <div class="space-y-2">
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">{{ __('Create an account') }}</h1>
            <p class="text-sm text-slate-600">{{ __('Get started and access your dashboard') }}</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="role" value="student" />

            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="matricule" :value="__('Matricule')" />
                <x-text-input id="matricule" class="mt-1 block w-full" type="text" name="matricule" :value="old('matricule')" required autocomplete="off" />
                <x-input-error :messages="$errors->get('matricule')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="mt-1 block w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <x-primary-button class="w-full">
                {{ __('Create account') }}
            </x-primary-button>
        </form>

        <p class="text-center text-sm text-slate-600">
            <span>{{ __('Already registered?') }}</span>
            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-md">
                {{ __('Sign in') }}
            </a>
        </p>
    </div>
</x-layouts.auth>
