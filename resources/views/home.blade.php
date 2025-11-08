<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @section('content')
    <div class="pt-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Welcome! ") }}

                    <!-- to be removed--mk -->
                    @php
                    $currentRoute = Route::currentRouteName();
                    @endphp   
                </div>
                <div class="p-6 text-gray-900 flex flex-row">
                    <div class="px-3">
                        <a href="{{ route('ppdashboard') }}">
                            <button class="{{ $currentRoute == 'ppdashboard' ? 'bg-blue-600 text-white' : 'bg-gray-800 text-white' }} px-4 py-2 rounded-md">
                                Passport
                            </button>
                        </a>
                    </div>
                    <div class="px-3">
                        <a href="{{ route('lrdashboard') }}">
                            <button class="{{ $currentRoute == 'lrdashboard' ? 'bg-blue-600 text-white' : 'bg-gray-800 text-white' }} px-4 py-2 rounded-md">
                                Leave
                            </button>
                        </a>
                    </div>
                    <div class="px-3">
                        <a href="{{ route('events.index') }}">
                            <button class="{{ $currentRoute == 'events.index' || $currentRoute == 'events.create' || $currentRoute == 'events.show' || $currentRoute == 'events.edit' ? 'bg-blue-600 text-white' : 'bg-gray-800 text-white' }} px-4 py-2 rounded-md">
                                Events
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex flex-row">
                   
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>