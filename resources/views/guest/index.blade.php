<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Guests') }}
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

            <div class="mb-4 flex justify-between items-center">
                <a href="{{ route('guests.export') }}" 
                   style="background-color: #059669; color: #ffffff; min-width: 140px;"
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out border-2 border-green-700 whitespace-nowrap">
                    📊 Export Excel
                </a>
                <a href="{{ route('guests.create') }}" style="background-color: #1e40af; color: #ffffff; text-decoration: none;" class="inline-block hover:bg-blue-900 text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-150 ease-in-out border-2 border-blue-900 no-underline">
                    <span class="text-lg">+</span> Create New Guest
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">All Guests</h3>
                    </div>

                    @if($guests->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Table Allocation</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Designation</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RSVP</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($guests as $guest)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $guest->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <a href="{{ route('guests.show', $guest->id) }}" class="text-blue-600 hover:text-blue-800">
                                                    {{ $guest->name }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $guest->tableAllocation ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $guest->company ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $guest->designation ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $guest->category ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $guest->RSVP ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('guests.show', $guest->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                                <a href="{{ route('guests.edit', $guest->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                                @if($guest->attendance === 'Present')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 mr-3">
                                                        ✓ Present
                                                    </span>
                                                @else
                                                    <button 
                                                        type="button"
                                                        onclick="markPresent({{ $guest->id }}, this)"
                                                        class="mark-present-btn inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out mr-3"
                                                        style="background-color: #16a34a; color: #ffffff;"
                                                    >
                                                        Mark Present
                                                    </button>
                                                @endif
                                                @if(auth()->user()->isAdmin ?? false)
                                                    <form action="{{ route('guests.destroy', $guest->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this guest?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No guests found. <a href="{{ route('guests.create') }}" class="text-blue-600 hover:text-blue-800">Create your first guest</a></p>
                        </div>
                    @endif
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
                parent.innerHTML = '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 mr-3">✓ Present</span>' + parent.innerHTML;
                
                // Reload page to show updated status
                setTimeout(function() {
                    window.location.reload();
                }, 500);
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

