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
                        Passports Data Correct: {{ App\Models\Passport::where('is_data_correct', true)->count() }}
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
                    <?php
                    $passports = App\Models\Passport::all()->where('is_data_entered', '!=', null);
                    ?>
                    @foreach ($passports as $passport)
                        <!-- <p>{{ $passport->employee_id }}</p> -->
                        <p>
                            <a href="{{ route('verify', $passport->id) }}">{{ $passport->id}}</a>&nbsp;
                            <a href="{{ route('verify', $passport->id) }}">{{ $passport->file_name }}</a>
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
</x-app-layout>
