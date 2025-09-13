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

                    @if (Auth::user()->is_admin)
                    <div>
                    <a
                        href="{{ route('register') }}"
                        class="rounded-md text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Register a new user
                    </a>
                    <div>
                        Total records assigned: {{ App\Models\LeaveRequest::where('user_id', auth()->user()->id)->count() }}
                    </div>
                    <div>
                        Leaves Data Entered: {{ App\Models\LeaveRequest::where('is_data_entered', true)->where('user_id', auth()->user()->id)->count() }}
                    </div>
                    <div>
                        Leaves Data Verified: {{ App\Models\LeaveRequest::where('verify_count', '>', 0)->where('user_id', auth()->user()->id)->count() }}
                    </div>
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
                            @foreach ($leaves as $leave)
                            <!-- <p>{{ $leave->employee_id }}</p> -->

                            <div class="border-b border-gray-200 pb-4">
                                    <a href="{{ route('leave-requests.edit', $leave->id) }}" class="block hover:bg-gray-50 p-3 rounded">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <span class="font-medium">ID: {{ $leave->id }}</span>
                                                @if($leave->verify_count > 0)
                                                    <span class="ml-4 text-gray-600">Request ID: {{ $leave->leaveRequestId }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            @endforeach
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