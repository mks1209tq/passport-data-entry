<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Panel') }}
        </h2>
    </x-slot>

    @section('content')
    <div class="pt-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Welcome! ") }}

                    @if (Auth::user()->is_admin)
                    <a
                        href="{{ route('register') }}"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Register
                    </a><br>

                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="pt-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex flex-row">
                    <div class="px-3">

                        <form action="{{ route('assign-passports') }}" method="POST" class="flex items-center gap-4">
                            @csrf
                            <div>
                                <label for="count" class="block text-sm font-medium text-gray-700">Passports per User</label>
                                <input type="number"
                                    name="count"
                                    id="count"
                                    value="10"
                                    min="1"
                                    class="mt-1 block w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md mt-6">
                                Assign Passports
                            </button>
                        </form>

                        <!-- Flash Messages -->
                        @if (session('success'))
                        <div class="pt-3">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 xl:px-0">
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                    <span class="block sm:inline">{{ session('success') }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if (session('error'))
                        <div class="pt-3">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 xl:px-0">
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                    <span class="block sm:inline">{{ session('error') }}</span>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="pt-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex flex-col">
                    <div class="px-3">

                        <form action="{{ route('assign-users') }}" method="POST" class="flex flex-col items-left gap-4">
                            @csrf
                            <div>
                                <label for="users" class="block text-sm font-medium text-gray-700">Passport Count</label>
                                <input type="number"
                                    name="count"
                                    id="count"
                                    value="10"
                                    min="1"
                                    class="mt-1 block w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            
                            <!--   I want below div in new row -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Select Users</label>
                                <div class="mt-1 max-h-48 overflow-y-auto border rounded-md p-2">
                                    @foreach ($users as $user)
                                        <div class="flex items-center space-x-2">
                                            <input type="checkbox" 
                                                name="users[]" 
                                                id="user-{{ $user->id }}" 
                                                value="{{ $user->id }}"
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <label for="user-{{ $user->id }}" class="text-sm text-gray-700">
                                                {{ $user->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <button type="submit"
                                class="inline-flex w-32 items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md mt-6">
                                Assign Users
                            </button>
                        </form>

                        <!-- Flash Messages -->
                        @if (session('success'))
                        <div class="pt-3">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 xl:px-0">
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                    <span class="block sm:inline">{{ session('success') }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if (session('error'))
                        <div class="pt-3">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 xl:px-0">
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                    <span class="block sm:inline">{{ session('error') }}</span>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>