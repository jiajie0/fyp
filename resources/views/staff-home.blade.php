<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- 添加开发者的名字和 ID -->
                    <p>Welcome, <strong>{{ Auth::guard('staff')->user()->StaffName }}</strong>!</p>
                    <p>Your ID: <strong>{{ Auth::guard('staff')->user()->StaffID }}</strong></p>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="btn btn-danger">Logout</button>
                    </form>


                    <p>Here is your dashboard.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
