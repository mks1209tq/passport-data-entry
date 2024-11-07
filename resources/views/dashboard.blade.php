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
                    <p>
                        Total records assigned: {{ App\Models\Passport::where('user_id', 4)->count() }}
                    </p>

                    @if (Auth::user()->is_admin)
                    <a
                        href="{{ route('register') }}"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
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
                        <?php
                        @if (Auth::user()->is_admin)
                        $passports = App\Models\Passport::all()->where('is_data_entered', false);
                        @else
                        $passports = App\Models\Passport::all()->where('is_data_entered', false)->where('user_id', auth()->user()->id);
                        @endif
                        ?>
                        <table class="">
                            <th class="">&nbsp; &nbsp;</th>
                            <th class="text-left">Passport ID</th>
                            @foreach ($passports as $passport)
                            <!-- <p>{{ $passport->employee_id }}</p> -->

                            <tr>
                                <td>
                                    @if ($passport->verify_count > 1)
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('passports.edit', $passport->id) }}">{{ $passport->id}}&nbsp;
                                        {{ $passport->file_name }}
                                    </a>
                                </td>
                            </tr>

                            @endforeach
                        </table>
                    </div>
                    <div class="px-3">

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>