<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('staff.login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="StaffEmail" :value="__('Email')" />
            <x-text-input id="StaffEmail" class="block mt-1 w-full" type="email" name="StaffEmail" :value="old('StaffEmail')"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('StaffEmail')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="StaffPW" :value="__('Password')" />
            <x-text-input id="StaffPW" class="block mt-1 w-full" type="password" name="StaffPW" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('StaffPW')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in as Staff') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-4 text-center">
        <p>Not a staff? <a href="{{ route('player.login') }}" class="text-indigo-600">Switch to Player Login</a> | <a
                href="{{ route('developer.login') }}" class="text-indigo-600">Switch to Developer Login</a></p>
        <p>Don't have an account? <a href="{{ route('staff.register') }}" class="text-indigo-600">Register as Staff</a>
        </p>
    </div>
</x-guest-layout>
