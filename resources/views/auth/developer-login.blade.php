<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('developer.login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="DeveloperEmail" :value="__('Email')" />
            <x-text-input id="DeveloperEmail" class="block mt-1 w-full" type="email" name="DeveloperEmail" :value="old('DeveloperEmail')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('DeveloperEmail')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="DeveloperPW" :value="__('Password')" />
            <x-text-input id="DeveloperPW" class="block mt-1 w-full" type="password" name="DeveloperPW" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('DeveloperPW')" class="mt-2" />
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
                {{ __('Log in as Developer') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-4 text-center">
        <p>Not a developer? <a href="{{ route('player.login') }}" class="text-indigo-600">Switch to Player Login</a> | <a href="{{ route('staff.login') }}" class="text-indigo-600">Switch to Staff Login</a></p>
        <p>Don't have an account? <a href="{{ route('developer.register') }}" class="text-indigo-600">Register as Developer</a></p>
    </div>
</x-guest-layout>
