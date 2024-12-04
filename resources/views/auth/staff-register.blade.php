<x-guest-layout>
    <form method="POST" action="{{ route('staff.register') }}">
        @csrf

        <!-- Staff Name -->
        <div>
            <x-input-label for="StaffName" :value="__('Staff Name')" />
            <x-text-input id="StaffName" class="block mt-1 w-full" type="text" name="StaffName" :value="old('StaffName')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('StaffName')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="StaffEmail" :value="__('Email')" />
            <x-text-input id="StaffEmail" class="block mt-1 w-full" type="email" name="StaffEmail" :value="old('StaffEmail')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('StaffEmail')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="StaffPW" :value="__('Password')" />

            <x-text-input id="StaffPW" class="block mt-1 w-full"
                            type="password"
                            name="StaffPW"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('StaffPW')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="StaffPW_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="StaffPW_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="StaffPW_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('StaffPW_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('staff.login') }}">
                {{ __('Already have an account? Log in') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register as Staff') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-4 text-center">
        <p>Not a staff? <a href="{{ route('staff.register') }}" class="text-indigo-600">Switch to Staff
                Registration</a> | <a href="{{ route('developer.register') }}" class="text-indigo-600">Switch to
                Developer Registration</a></p>
    </div>
</x-guest-layout>
