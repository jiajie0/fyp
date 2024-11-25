<x-guest-layout>
    <form method="POST" action="{{ route('developer.register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="DeveloperName" :value="__('Name')" />
            <x-text-input id="DeveloperName" class="block mt-1 w-full" type="text" name="DeveloperName" :value="old('DeveloperName')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('DeveloperName')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="DeveloperEmail" :value="__('Email')" />
            <x-text-input id="DeveloperEmail" class="block mt-1 w-full" type="email" name="DeveloperEmail" :value="old('DeveloperEmail')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('DeveloperEmail')" class="mt-2" />
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="CompanyName" :value="__('Company Name')" />
            <x-text-input id="CompanyName" class="block mt-1 w-full" type="text" name="CompanyName" :value="old('CompanyName')" />
            <x-input-error :messages="$errors->get('CompanyName')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="DeveloperPW" :value="__('Password')" />

            <x-text-input id="DeveloperPW" class="block mt-1 w-full"
                            type="password"
                            name="DeveloperPW"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('DeveloperPW')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="DeveloperPW_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="DeveloperPW_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="DeveloperPW_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('DeveloperPW_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('developer.login') }}">
                {{ __('Already have an account? Log in') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register as Developer') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-4 text-center">
        <p>Not a developer? <a href="{{ route('player.register') }}" class="text-indigo-600">Switch to Player Registration</a> | <a href="{{ route('staff.register') }}" class="text-indigo-600">Switch to Staff Registration</a></p>
    </div>
</x-guest-layout>
