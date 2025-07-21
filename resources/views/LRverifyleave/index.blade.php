<x-app-layout>
    <x-slot name="header">
        @include('leaveRequest.partials.subnav')
        <h2 class="font-semibold text-xl py-4 text-gray-800 leading-tight">
            {{ __('Verify Leaves') }}
        </h2>
    </x-slot>

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
                    {{ __("Welcome!") }}

                    @if (Auth::user()->is_admin)
                        <a
                            href="{{ route('register') }}"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Register
                        </a><br>

                        <div>
                            Leaves Data Entered: {{ App\Models\LeaveRequest::where('is_data_entered', true)->count() }}
                        </div>
                        <div>
                            Leaves Data Verified: {{ App\Models\LeaveRequest::where('verify_count', '>', 1)->count() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="pt-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($leaves->count() > 0)
                        <div class="space-y-4">
                            @foreach ($leaves as $leave)
                                <div class="border-b border-gray-200 pb-4">
                                    <a href="{{ route('verify-leaves.edit', $leave->id) }}" class="block hover:bg-gray-50 p-3 rounded">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <span class="font-medium">ID: {{ $leave->id }}</span>
                                                @if($leave->leaveRequestId)
                                                    <span class="ml-4 text-gray-600">Request ID: {{ $leave->leaveRequestId }}</span>
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                @if($leave->verifier1)
                                                    <span>Verifier 1: {{ $leave->verifier1 }}</span>
                                                @endif
                                                @if($leave->verifier2)
                                                    <span class="ml-2">Verifier 2: {{ $leave->verifier2 }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $leaves->links() }}
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            No leaves available for verification.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
