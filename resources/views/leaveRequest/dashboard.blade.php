<x-app-layout>
    
    <x-slot name="header">
        @include('leaveRequest.partials.subnav')
        <h2 class="font-semibold text-xl py-4 text-gray-800 leading-tight">
            {{ __('Leave Dashboard') }}
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
                        Total records assigned: {{ App\Models\LeaveRequest::where('user_id', auth()->user()->id)->count() }}
                    </p>
                    <div>
                        Leaves Data Entered: {{ App\Models\LeaveRequest::where('is_data_entered', true)->where('user_id', auth()->user()->id)->count() }}
                    </div>
                    <div>
                        Leaves Data Verified: {{ App\Models\LeaveRequest::where('verify_count', '>', 1)->where('user_id', auth()->user()->id)->count() }}
                    </div>
                    @if (Auth::user()->is_admin)
                    <div>
                    <a
                        href="{{ route('register') }}"
                        class="rounded-md text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Register a new user
                    </a>
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
                        if (Auth::user()->is_admin) {
                            $leaves = App\Models\LeaveRequest::all()->where('is_data_entered', false);
                        } else {
                            $leaves = App\Models\LeaveRequest::all()->where('is_data_entered', false)->where('user_id', auth()->user()->id);
                        }
                        ?>
                        <table class="">
                            <th class="">&nbsp; &nbsp; </th>
                            <th class="text-left">Leave ID</th>
                            @foreach ($leaves as $leave)
                            <!-- <p>{{ $leave->employee_id }}</p> -->

                            <tr>
                                <td>
                                    @if ($leave->verify_count > 1)
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('leave-requests.edit', $leave->id) }}">{{ $leave->id}}&nbsp;
                                        {{ $leave->employee_id }}
                                    </a>
                                </td>
                            </tr>

                            @endforeach
                        </table>
                    </div>
                    <!-- make the below border -->
                    <div class="px-3">
                        

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>