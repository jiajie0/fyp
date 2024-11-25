<x-guest-layout>
    <form method="POST" action="{{ route('player.register') }}">
        @csrf

        <!-- Player Name -->
        <div>
            <x-input-label for="PlayerName" :value="__('Player Name')" />
            <x-text-input id="PlayerName" class="block mt-1 w-full" type="text" name="PlayerName" :value="old('PlayerName')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('PlayerName')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="PlayerEmail" :value="__('Email')" />
            <x-text-input id="PlayerEmail" class="block mt-1 w-full" type="email" name="PlayerEmail" :value="old('PlayerEmail')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('PlayerEmail')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="PlayerPW" :value="__('Password')" />

            <x-text-input id="PlayerPW" class="block mt-1 w-full"
                            type="password"
                            name="PlayerPW"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('PlayerPW')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="PlayerPW_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="PlayerPW_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="PlayerPW_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('PlayerPW_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('player.login') }}">
                {{ __('Already have an account? Log in') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register as Player') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-4 text-center">
        <p>Not a player? <a href="{{ route('staff.register') }}" class="text-indigo-600">Switch to Staff Registration</a> | <a href="{{ route('developer.register') }}" class="text-indigo-600">Switch to Developer Registration</a></p>
    </div>
</x-guest-layout>
