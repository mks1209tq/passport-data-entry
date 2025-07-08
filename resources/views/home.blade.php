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
                    
                </div>
                <div class="p-6 text-gray-900 flex flex-row">
                    <div class="px-3">
                        <a href="{{ route('ppdashboard') }}">
                            <button class="bg-gray-800 text-white px-4 py-2 rounded-md">
                                Passport
                            </button>
                        </a>
                    </div>
                    <div class="px-3">
                        <a href="{{ route('leaveApplication') }}">
                            <button class="bg-gray-800 text-white px-4 py-2 rounded-md">
                                Leave
                            </button>
                        </a>
                    </div>
                     
                        
                    <!-- make the below border -->
                    <div class="px-3">
                        

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