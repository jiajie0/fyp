<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('player.login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="PlayerEmail" :value="__('Email')" />
            <x-text-input id="PlayerEmail" class="block mt-1 w-full" type="email" name="PlayerEmail" :value="old('PlayerEmail')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('PlayerEmail')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="PlayerPW" :value="__('Password')" />

            <x-text-input id="PlayerPW" class="block mt-1 w-full"
                            type="password"
                            name="PlayerPW"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('PlayerPW')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in as Player') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-4 text-center">
        <p>Not a player? <a href="{{ route('staff.login') }}" class="text-indigo-600">Switch to Staff Login</a> | <a href="{{ route('developer.login') }}" class="text-indigo-600">Switch to Developer Login</a></p>
        <p>Don't have an account? <a href="{{ route('player.register') }}" class="text-indigo-600">Register as Player</a></p>
    </div>
</x-guest-layout>
