<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Guest Details') }}
        </h2>
    </x-slot>

    <div class="pt-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 flex justify-between items-center">
                        <a href="{{ route('guests.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Guests</a>
                        <div class="space-x-2">
                            @if($guest->attendance === 'Present')
                                <span class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    ✓ Present
                                </span>
                            @else
                                <button 
                                    type="button"
                                    onclick="markPresent({{ $guest->id }}, this)"
                                    class="mark-present-btn inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out"
                                    style="background-color: #16a34a; color: #ffffff; min-width: 120px;"
                                >
                                    Mark Present
                                </button>
                            @endif
                            <a href="{{ route('guests.edit', $guest->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Edit
                            </a>
                            <form action="{{ route('guests.destroy', $guest->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this guest?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">ID</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $guest->id }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $guest->name }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Designation</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $guest->designation ?? 'N/A' }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Company</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $guest->company ?? 'N/A' }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Category</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $guest->category ?? 'N/A' }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Proposal By</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $guest->proposalBy ?? 'N/A' }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Guest Of</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $guest->guestOf ?? 'N/A' }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">RSVP</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $guest->RSVP ?? 'N/A' }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Table Allocation</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $guest->tableAllocation ?? 'N/A' }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Attendance</dt>
                                <dd class="mt-1 text-sm text-gray-900" id="attendance-display">
                                    @if($guest->attendance === 'Present')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            ✓ {{ $guest->attendance }}
                                        </span>
                                    @else
                                        {{ $guest->attendance ?? 'N/A' }}
                                    @endif
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $guest->created_at->format('M d, Y H:i') }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Updated At</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $guest->updated_at->format('M d, Y H:i') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Mark guest as present
        function markPresent(guestId, buttonElement) {
            // Disable button to prevent multiple clicks
            buttonElement.disabled = true;
            buttonElement.textContent = 'Marking...';
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            // Make AJAX request
            window.axios.post('{{ url("/guests") }}/' + guestId + '/mark-present', {}, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                }
            })
            .then(function(response) {
                // Replace button with success badge
                const parent = buttonElement.parentElement;
                parent.innerHTML = '<span class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">✓ Present</span>' + parent.innerHTML;
                
                // Update attendance display
                const attendanceDisplay = document.getElementById('attendance-display');
                if (attendanceDisplay) {
                    attendanceDisplay.innerHTML = '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">✓ Present</span>';
                }
            })
            .catch(function(error) {
                // Re-enable button on error
                buttonElement.disabled = false;
                buttonElement.textContent = 'Mark Present';
                
                console.error('Error marking guest as present:', error);
                alert('Failed to mark guest as present. Please try again.');
            });
        }
    </script>
    @endpush
</x-app-layout>

