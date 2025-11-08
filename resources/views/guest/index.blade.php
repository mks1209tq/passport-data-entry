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

            <!-- Search Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6" style="overflow: visible;">
                <div class="p-6" style="overflow: visible;">
                    <form method="GET" action="{{ route('guests.index') }}" id="searchForm" class="flex items-center gap-3" style="overflow: visible;">
                        <div class="flex-1 relative" style="overflow: visible;">
                            <input 
                                type="text" 
                                name="q" 
                                id="searchInput"
                                value="{{ $searchQuery ?? request('q') ?? '' }}" 
                                placeholder="Search guests by name, designation, company, category, RSVP, etc..." 
                                autocomplete="off"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white px-4 py-2"
                            >
                            <!-- Autocomplete Dropdown -->
                            <div id="autocompleteDropdown" class="hidden absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 rounded-md shadow-xl max-h-60 overflow-auto" style="top: 100%; left: 0; position: absolute;">
                                <ul id="autocompleteList" class="py-1">
                                    <!-- Suggestions will be inserted here -->
                                </ul>
                            </div>
                        </div>
                        <button 
                            type="submit" 
                            id="searchButton"
                            style="background-color: #2563eb; color: #ffffff; min-width: 100px;"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-150 ease-in-out border-2 border-blue-700 whitespace-nowrap"
                        >
                            🔍 Search
                        </button>
                        @if(isset($searchQuery) && $searchQuery)
                            <a 
                                href="{{ route('guests.index') }}" 
                                style="background-color: #6b7280; color: #ffffff; min-width: 80px;"
                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-150 ease-in-out border-2 border-gray-600 whitespace-nowrap text-center"
                            >
                                Clear
                            </a>
                        @endif
                    </form>
                </div>
            </div>

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
                        <h3 class="text-lg font-semibold">
                            @if(isset($searchQuery) && $searchQuery)
                                Search Results ({{ $guests->count() }} found)
                            @else
                                All Guests ({{ $guests->count() }})
                            @endif
                        </h3>
                    </div>

                    @if($guests->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Table Allocation</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Designation</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RSVP</th>
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
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
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
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $guest->tableAllocation ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $guest->company ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $guest->designation ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $guest->category ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $guest->RSVP ?? 'N/A' }}</td>
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
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const autocompleteDropdown = document.getElementById('autocompleteDropdown');
            const autocompleteList = document.getElementById('autocompleteList');
            
            // Check if elements exist
            if (!searchInput || !autocompleteDropdown || !autocompleteList) {
                return;
            }
            
            // Check if axios is available
            if (typeof window.axios === 'undefined') {
                return;
            }
            
            let debounceTimer;
            let selectedIndex = -1;
            let suggestions = [];

            // Fetch autocomplete suggestions
            function fetchSuggestions(query) {
                if (query.length < 2) {
                    hideDropdown();
                    return;
                }

                window.axios.get('{{ route("guests.autocomplete") }}', {
                    params: { q: query }
                })
                .then(function(response) {
                    suggestions = response.data;
                    displaySuggestions(suggestions);
                })
                .catch(function(error) {
                    hideDropdown();
                });
            }

            // Display suggestions in dropdown
            function displaySuggestions(suggestions) {
                if (suggestions.length === 0) {
                    hideDropdown();
                    return;
                }

                autocompleteList.innerHTML = '';
                suggestions.forEach(function(guest, index) {
                    const li = document.createElement('li');
                    li.className = 'px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer';
                    li.setAttribute('data-index', index);
                    li.innerHTML = `
                        <div class="font-medium text-gray-900 dark:text-gray-100">${guest.name}</div>
                        ${guest.designation ? `<div class="text-sm text-gray-500 dark:text-gray-400">${guest.designation}</div>` : ''}
                        ${guest.company ? `<div class="text-xs text-gray-400 dark:text-gray-500">${guest.company}</div>` : ''}
                    `;
                    li.addEventListener('click', function() {
                        selectGuest(guest);
                    });
                    li.addEventListener('mouseenter', function() {
                        selectedIndex = index;
                        updateHighlight();
                    });
                    autocompleteList.appendChild(li);
                });

                showDropdown();
                selectedIndex = -1;
            }

            // Show dropdown
            function showDropdown() {
                autocompleteDropdown.classList.remove('hidden');
            }

            // Hide dropdown
            function hideDropdown() {
                autocompleteDropdown.classList.add('hidden');
                selectedIndex = -1;
            }

            // Select a guest from suggestions
            function selectGuest(guest) {
                searchInput.value = guest.name;
                hideDropdown();
            }

            // Update highlight on keyboard navigation
            function updateHighlight() {
                const items = autocompleteList.querySelectorAll('li');
                items.forEach(function(item, index) {
                    if (index === selectedIndex) {
                        item.classList.add('bg-gray-100', 'dark:bg-gray-700');
                    } else {
                        item.classList.remove('bg-gray-100', 'dark:bg-gray-700');
                    }
                });
            }

            // Input event with debounce
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                const query = this.value.trim();
                
                debounceTimer = setTimeout(function() {
                    fetchSuggestions(query);
                }, 300);
            });

            // Keyboard navigation
            searchInput.addEventListener('keydown', function(e) {
                if (!autocompleteDropdown.classList.contains('hidden') && suggestions.length > 0) {
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        selectedIndex = Math.min(selectedIndex + 1, suggestions.length - 1);
                        updateHighlight();
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        selectedIndex = Math.max(selectedIndex - 1, -1);
                        updateHighlight();
                    } else if (e.key === 'Enter' && selectedIndex >= 0) {
                        e.preventDefault();
                        selectGuest(suggestions[selectedIndex]);
                    } else if (e.key === 'Escape') {
                        hideDropdown();
                    }
                }
            });

            // Hide dropdown when clicking outside
            document.addEventListener('click', function(e) {
                const searchContainer = searchInput.closest('.flex-1');
                if (searchContainer && !searchContainer.contains(e.target)) {
                    hideDropdown();
                }
            });

            // Hide dropdown on form submit
            document.getElementById('searchForm').addEventListener('submit', function() {
                hideDropdown();
            });
        });

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

