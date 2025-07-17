<x-app-layout>
    @include('passport.partials.subnav')
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verify Passports') }}
        </h2>
    </x-slot>

    @section('content')
    
    <div class="pt-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="py-3">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 xl:px-0">
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                    <span class="block sm:inline">{{ session('success') }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if (session('error'))
                        <div class="py-3">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 xl:px-0">
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                    <span class="block sm:inline">{{ session('error') }}</span>
                                </div>
                            </div>
                </div>
                @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Welcome! ") }} 
                    
                    @if (Auth::user()->is_admin)
                        <a
                            href="{{ route('register') }}"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Register
                        </a><br>
                        <div>
                        Passports Data Entered: {{ App\Models\Passport::where('is_data_entered', true)->count() }}
                        </div>
                        <div>
                        Passports Data Verified: {{ App\Models\Passport::where('verify_count', '>', 1)->count() }}
                        </div>
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
                   
                    

                    @foreach ($passports as $passport)
                        <!-- <p>{{ $passport->employee_id }}</p> -->
                        <p>
                            <a href="{{ route('verify-passports.edit', $passport->id) }}">
                            {{ $passport->id}} &nbsp;
                            {{ $passport->file_name }} &nbsp;
                            {{ $passport->verifier1 }} &nbsp;    
                            {{ $passport->verifier2 }} &nbsp;
                        </a>
                        </p>

                        

                    @endforeach
                    </div>
                    <div class="px-3">
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
    @endsection
