@if (Auth::user()->is_admin)
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Panel') }}
        </h2>
    </x-slot>

    @section('content')
    

        

        <!-- main content -->
        <div class="flex min-h-full flex-col">


            <!-- 4 column wrapper -->
            <div class="mx-auto w-full max-w-7xl grow lg:flex xl:px-1">
                <!-- column 1 area -->
                <div class="flex-2 xl:flex">
                    <div class="px-1 py-2 sm:px-1 lg:pl-1 xl:w-96 xl:shrink-0  xl:pl-2">
                        <!-- Left column area -->
                        <div class="py-1">
                            <div class="max-w-7xl mx-auto sm:px-2 lg:px-3">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-1">
                                    <div class="p-2 text-gray-900 flex flex-col">
                                        <div class="px-1">
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
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg py-2">
                                    <div class="p-2 text-gray-900 flex flex-col py-2">
                                        <div class="px-1 py-2">
                                            <!-- Passport per User Count -->
                                            @php
                                            $passportsPerUser = $passports->count() / $users->count();
                                            @endphp
                                            <table class="border border-slate-500">
                                                <th class="border border-slate-500 text-left p-2">User</th>
                                                <th class="border border-slate-500 text-center p-2">Assigned</th>
                                                <th class="border border-slate-500 text-center p-2">Verified</th>
                                                @foreach ($users as $user)
                                                <tr>
                                                    <td class="border border-slate-500 p-2">

                                                        {{ $user->name }}
                                                    </td>
                                                    <td class="border border-slate-500 text-center p-2">
                                                        {{ $passports->where('verifier1', $user->id)->count() + 
                                        $passports->where('verifier2', $user->id)->count() }}
                                                    </td>
                                                    <td class="border border-slate-500 text-center p-2">
                                                        {{ $passports->where('verifier1_id', $user->id) ->count() + 
                                        $passports->where('verifier2_id', $user->id) ->count() }}

                                                    </td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>



                    </div>
                    <!-- end of passport per user count -->



                </div>

                <!-- column 2 area -->

                <div class="px-1 py-2 sm:px-2 lg:pl-3 xl:flex-1 xl:pl-3">

                    <!-- register user -->
                    <div class="pt-1">
                        <div class="max-w-7xl mx-auto sm:px-1 lg:px-2">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-2 text-gray-900">




                                    <!-- make label and button in line -->
                                    <div class="p-1 text-gray-900">
                                        <div class="flex flex-col">
                                            <label class="pr-2">Register New User</label>
                                        </div>
                                        <div class="">
                                            <button
                                                onclick="window.location.href='{{ route('register') }}'"
                                                class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md mt-6">
                                                Register
                                            </button>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of register user -->



                    <!-- set admin -->
                    <div class="pt-1">
                        <div class="max-w-7xl mx-auto sm:px-1 lg:px-2">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-1 text-gray-900 p-2">
                                    <form action="{{ route('set-admin') }}" method="POST">
                                        @csrf
                                        <label class="block text-sm font-medium text-gray-700">Admins</label>
                                        <div class="mt-1 max-h-48 overflow-y-auto border rounded-md p-2">
                                            @foreach ($users as $user)
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox"
                                                    name="selected_users[]"
                                                    id="user-{{ $user->id }}"
                                                    value="{{ $user->id }}"
                                                    {{ $user->is_admin ? 'checked' : '' }}
                                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <label for="user-{{ $user->id }}" class="text-sm text-gray-700">
                                                    {{ $user->name }}
                                                    @if($user->is_admin)

                                                    @endif
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="">
                                            <button type="submit"
                                                class="inline-flex w-32 items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md mt-6">
                                                Set Admin
                                            </button>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of set admin -->

                    <!-- set verifier -->
                    <div class="pt-1">
                        <div class="max-w-7xl mx-auto sm:px-1 lg:px-2">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-2 text-gray-900">
                                    <!-- {{ __("Welcome! ") }} -->
                                    <form action="{{ route('set-verifier') }}" method="POST">
                                        @csrf
                                        <label class="block text-sm font-medium text-gray-700">Verifiers</label>
                                        <div class="mt-1 max-h-48 overflow-y-auto border rounded-md p-2">
                                            @foreach ($users as $user)
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox"
                                                    name="selected_users[]"
                                                    id="user-{{ $user->id }}"
                                                    value="{{ $user->id }}"
                                                    {{ $user->is_verifier ? 'checked' : '' }}
                                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <label for="user-{{ $user->id }}" class="text-sm text-gray-700">
                                                    {{ $user->name }}
                                                    @if($user->is_verifier)

                                                    @endif
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="">
                                            <button type="submit"
                                                class="inline-flex w-32 items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md mt-6">
                                                Set Verifier
                                            </button>
                                        </div>
                                    </form>
                                    <br>


                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of set verifier -->




                </div>



                <!-- column 3 area -->
                <div class="shrink-0 px-2 py-2 sm:px-2 lg:w-96 lg:pr-3 xl:pr-3">

                    <!-- assign passports to all users -->
                    <div class="pt-1">
                        <div class="max-w-7xl mx-auto sm:px-1 lg:px-2">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-2 text-gray-900 flex flex-row">
                                    <div class="px-1">

                                        <form action="{{ route('assign-passports') }}" method="POST" class="flex flex-col gap-4">
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
                                            <div class="">
                                                <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md mt-6">
                                                    Assign Passports
                                                </button>
                                            </div>
                                        </form>



                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of assign passports to all users -->

                    <!-- assign passport to user -->
                    <div class="pt-1">
                        <div class="max-w-7xl mx-auto sm:px-1 lg:px-2">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-2 text-gray-900 flex flex-col">
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
                                            <div class="">
                                                <button type="submit"
                                                    class="inline-flex w-32 items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md mt-6">
                                                    Assign Passports
                                                </button>
                                            </div>
                                        </form>



                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of assign passport to user -->

                    <!-- remove passport -->
                    <div class="pt-1">
                        <div class="max-w-7xl mx-auto sm:px-1 lg:px-2">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-2 text-gray-900 flex flex-col">
                                    <div class="px-3 flex flex-col">
                                        <form action="{{ route('remove-passport-assignments') }}" method="POST" class="flex flex-col gap-4">
                                            @csrf
                                            <div class="flex flex-col">
                                                <label class="block text-sm font-medium text-gray-700">Remove Passport Assignments</label>
                                                <select name="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                    <option value="">Select User</option>
                                                    @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="">
                                                <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md mt-6"
                                                    onclick="return confirm('Are you sure you want to remove all assignments from this user?')">
                                                    Remove Passport
                                                </button>
                                            </div>
                                        </form>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of remove passport -->



                </div>


                <!-- column 4 area -->
                <div class="shrink-0  px-2 py-2 sm:px-2 lg:w-96 lg:pr-3 xl:pr-3">

                    <!-- assign verifiers -->
                    <div class="pt-1">
                        <div class="max-w-7xl mx-auto sm:px-1 lg:px-2">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-2 text-gray-900 flex flex-col">
                                    <div class="px-3">

                                        <form action="{{ route('assign-verifiers') }}" method="POST" class="flex flex-col gap-4">
                                            @csrf
                                            <div>
                                                <label for="count" class="block text-sm font-medium text-gray-700">Verifiers per User</label>
                                                <input type="number"
                                                    name="count"
                                                    id="count"
                                                    value="10"
                                                    min="1"
                                                    class="mt-1 block w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            </div>
                                            <div class="">
                                                <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md mt-6">
                                                    Assign Verifiers
                                                </button>
                                            </div>
                                        </form>



                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of assign verifiers -->

                    <!-- remove verifier -->
                    <div class="pt-1">
                        <div class="max-w-7xl mx-auto sm:px-1 lg:px-2">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-2 text-gray-900 flex flex-col">
                                    <div class="px-3 flex flex-col">
                                        <form action="{{ route('remove-verifier-assignments') }}" method="POST" class="flex flex-col gap-4">
                                            @csrf
                                            <div class="flex flex-col">
                                                <label class="block text-sm font-medium text-gray-700">Remove Verifier Assignments</label>
                                                <select name="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                    <option value="">Select Verifier</option>
                                                    @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="">
                                                <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md mt-6"
                                                    onclick="return confirm('Are you sure you want to remove all assignments from this verifier?')">
                                                    Remove Verifier
                                                </button>
                                            </div>
                                        </form>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of remove verifier -->

                </div>
            </div>

        </div>
        <!-- end of main content -->

    

    <!-- Global notification live region, render this permanently at the end of the document -->
    <div aria-live="assertive" class="pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6"
        x-data="{ show: {{ session('success') || session('error') ? 'true' : 'false' }} }"
        x-init="setTimeout(() => show = false, 5000)"
        
        x-cloak
        >
        <div class="flex w-full flex-col items-center space-y-4 sm:items-end"
        x-show="show"   
        x-transition:enter="transform ease-out duration-800 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-800"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
            <div class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="shrink-0">
                            @if(session('success'))
                            <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            @endif
                            @if(session('error'))
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-red-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>

                            @endif
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            @if(session('success'))
                                <p class="text-sm font-medium text-gray-900">Success!</p>
                                <p class="mt-1 text-sm text-gray-500">{{ session('success') }}</p>
                            @endif
                            @if(session('error'))
                                <p class="text-sm font-medium text-gray-900">Error!</p>
                                <p class="mt-1 text-sm text-gray-500">{{ session('error') }}</p>
                            @endif
                        </div>
                        <div class="ml-4 flex shrink-0">
                            <button type="button" @click="show = false" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <span class="sr-only">Close</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of global notification -->

    

    
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