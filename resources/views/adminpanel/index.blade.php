
@if (Auth::user()->is_admin)
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Panel') }}
        </h2>
    </x-slot>

    @section('content')

    <!--
  This example requires updating your template:

  ```
  <html class="h-full bg-white">
  <body class="h-full">
  ```
-->
<div class="flex min-h-full flex-col border">


  <!-- 3 column wrapper -->
  <div class="mx-auto w-full max-w-7xl grow lg:flex xl:px-1">
    <!-- Left sidebar & main wrapper -->
    <div class="flex-2 xl:flex">
      <div class="border-b px-1 py-2 sm:px-1 lg:pl-1 xl:w-96 xl:shrink-0 xl:border-b-0 xl:border-r xl:pl-2">
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

      <div class="px-1 py-2 sm:px-2 lg:pl-3 xl:flex-1 xl:pl-3">
        <!-- Main area -->
         <!-- register,verifier,assign passports -->
        <div class="pt-1">
        <div class="max-w-7xl mx-auto sm:px-1 lg:px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 text-gray-900">
                    <!-- {{ __("Welcome! ") }} -->
                       <!-- Flash Messages -->
                       @if (session('success'))
                        <div class="pt-1">
                            <div class="max-w-7xl mx-auto sm:px-1 lg:px-2 xl:px-0">
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                    <span class="block sm:inline">{{ session('success') }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if (session('error'))
                        <div class="pt-3">
                            <div class="max-w-7xl mx-auto sm:px-1 lg:px-2 xl:px-0">
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                    <span class="block sm:inline">{{ session('error') }}</span>
                                </div>
                            </div>
                        </div>
                        @endif

                    <!-- make label and button in line -->
                    <div class="p-1 text-gray-900">
                    <label class="pr-2">Register New User</label>
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

    <div class="pt-1">
        <div class="max-w-7xl mx-auto sm:px-1 lg:px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-1 text-gray-900 p-2" >
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
                        <button type="submit"
                            class="inline-flex w-32 items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md mt-6">
                            Set Admin
                        </button>
                    </form>

                    
                </div>
            </div>
        </div>
    </div>
    


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
                        <button type="submit"
                            class="inline-flex w-32 items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md mt-6">
                            Set Verifier
                        </button>
                    </form>
                    <br>

                    
                </div>
            </div>
        </div>
    </div>
    <!-- end of set verifier -->
    <div class="pt-1">
        <div class="max-w-7xl mx-auto sm:px-1 lg:px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 text-gray-900 flex flex-row">
                    <div class="px-1">

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
    <!-- end of assign passports -->

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

    <!-- end of assign users -->
    
    
    </div>

    <div class="shrink-0 border-t px-2 py-2 sm:px-2 lg:w-96 lg:border-l lg:border-t-0 lg:pr-3 xl:pr-3">
      <!-- Right column area -->
      <div class="pt-1">
        <div class="max-w-7xl mx-auto sm:px-1 lg:px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 text-gray-900 flex flex-col">
                    <div class="px-3">
                <!-- assign verifiers -->
                <form action="{{ route('assign-verifiers') }}" method="POST" class="flex items-center gap-4">
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
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md mt-6">
                                Assign Verifiers
                            </button>
                        </form>

                        

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- end of assign verifiers -->
      
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
