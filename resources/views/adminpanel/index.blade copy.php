
@if (Auth::user()->is_admin)
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
                    <!-- {{ __("Welcome! ") }} -->
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

                    
                    <button
                        onclick="window.location.href='{{ route('register') }}'"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md mt-6">
                        Register
                    </button>
                    

                    
                </div>
            </div>
        </div>
    </div>
    <div class="pt-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 p-4" >
                    <!-- {{ __("Welcome! ") }} -->
                    <form action="{{ route('set-admin') }}" method="POST">
                        @csrf
                        Choose User
                        <select class="mx-2" name="user" id="user">
                            @foreach ($non_admins as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md mt-6">
                            Set Admin
                        </button>
                    </form>
                    <br>

                    
                </div>
            </div>
        </div>
    </div>
    <div class="pt-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- {{ __("Welcome! ") }} -->
                    <form action="{{ route('set-verifier') }}" method="POST">
                        @csrf
                        Choose User
                        <select class="mx-2" name="user" id="user">
                            @foreach ($non_verifiers as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md mt-6">
                            Set Verifier
                        </button>
                    </form>
                    <br>

                    
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
                        <!-- Passport per User Count -->
                        @php
                            $passportsPerUser = $passports->count() / $users->count();
                        @endphp 
                        <table class="border border-slate-500">
                            <th class="border border-slate-500 text-left p-2">User</th>
                            <th class="border border-slate-500 text-center p-2">Assigned</th>
                            <th class="border border-slate-500 text-center p-2">Entered</th>
                        @foreach ($users as $user)
                        <tr>
                                <td class="border border-slate-500 p-2">
                            
                                    {{ $user->name }}
                                </td>
                                <td class="border border-slate-500 text-center p-2">
                                    {{ $passports->where('user_id', $user->id)->count() }}
                                </td>
                                <td class="border border-slate-500 text-center p-2">
                                    {{ $passports->where('user_id', $user->id)
                                    ->where('is_data_entered', true)
                                    ->count() }}
                                
                            </td>
                        </tr>
                        @endforeach
                        </table>
                    </div>

                </div>
            </div>
            </div>
        
    @endsection
</x-app-layout>
@else
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Access Denied') }}
        </h2>
    </x-slot>
</x-app-layout>
@endif
