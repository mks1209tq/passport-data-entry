<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12" style="overflow: visible;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="overflow: visible;">
            <!-- Search Form -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mb-6 display: none;" style="overflow: visible;">
                <div class="p-6" style="overflow: visible;">
                    <form method="GET" action="{{ route('dashboard') }}" id="searchForm" class="flex items-center gap-3" style="overflow: visible;">
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
                                href="{{ route('dashboard') }}" 
                                style="background-color: #6b7280; color: #ffffff; min-width: 80px;"
                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-150 ease-in-out border-2 border-gray-600 whitespace-nowrap text-center"
                            >
                                Clear
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- TIPL Data Entry Section -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                Sports Event - TIPL Data Entry
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Enter participant details for the sports event including name, employee ID, company, phone number, pick up point, and in-house talent status.
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <a 
                                href="{{ route('tipl.create') }}" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-150 ease-in-out border-2 border-blue-700 whitespace-nowrap"
                                style="background-color: #2563eb; color: #ffffff; min-width: 140px;"
                            >
                                + New TIPL Entry
                            </a>
                            <a 
                                href="{{ route('tipl.index') }}" 
                                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-150 ease-in-out border-2 border-green-700 whitespace-nowrap"
                                style="background-color: #059669; color: #ffffff; min-width: 120px;"
                            >
                                View All Entries
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Results -->
            @if(isset($guests) && $guests->isNotEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                Search Results ({{ $guests->count() }} found)
                            </h3>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('guests.export') }}" 
                                   style="background-color: #059669; color: #ffffff; min-width: 140px;"
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out border-2 border-green-700 whitespace-nowrap">
                                    📊 Export Excel
                                </a>
                                <a href="{{ route('guests.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                    View All Guests →
                                </a>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Table Allocation</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Company</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Designation</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">RSVP</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($guests as $guest)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $guest->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                <a href="{{ route('guests.show', $guest->id) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                                    {{ $guest->name }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $guest->tableAllocation ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if($guest->attendance === 'Present')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
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
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $guest->company ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $guest->designation ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $guest->category ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $guest->RSVP ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @elseif(isset($searchQuery) && $searchQuery)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-gray-500 dark:text-gray-400">No guests found matching "{{ $searchQuery }}".</p>
                        <a href="{{ route('guests.create') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 mt-2 inline-block">Create a new guest</a>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    
                </div>
            @endif
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
                console.error('Autocomplete elements not found:', {
                    searchInput: !!searchInput,
                    autocompleteDropdown: !!autocompleteDropdown,
                    autocompleteList: !!autocompleteList
                });
                return;
            }
            
            // Check if axios is available
            if (typeof window.axios === 'undefined') {
                console.error('Axios is not available');
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

                console.log('Fetching suggestions for:', query);
                
                window.axios.get('{{ route("guests.autocomplete") }}', {
                    params: { q: query }
                })
                .then(function(response) {
                    console.log('Autocomplete response:', response.data);
                    suggestions = response.data;
                    displaySuggestions(suggestions);
                })
                .catch(function(error) {
                    console.error('Autocomplete error:', error);
                    if (error.response) {
                        console.error('Response error:', error.response.status, error.response.data);
                    }
                    hideDropdown();
                });
            }

            // Display suggestions in dropdown
            function displaySuggestions(suggestions) {
                console.log('Displaying suggestions:', suggestions);
                if (suggestions.length === 0) {
                    console.log('No suggestions to display');
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

                console.log('Showing dropdown');
                showDropdown();
                selectedIndex = -1;
            }

            // Show dropdown
            function showDropdown() {
                console.log('showDropdown called, removing hidden class');
                console.log('Before - has hidden:', autocompleteDropdown.classList.contains('hidden'));
                autocompleteDropdown.classList.remove('hidden');
                console.log('After - has hidden:', autocompleteDropdown.classList.contains('hidden'));
                console.log('Dropdown classes:', autocompleteDropdown.className);
                console.log('Dropdown computed style display:', window.getComputedStyle(autocompleteDropdown).display);
                console.log('Dropdown offsetHeight:', autocompleteDropdown.offsetHeight);
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
                // Optionally submit the form or navigate to guest page
                // window.location.href = '{{ url("/guests") }}/' + guest.id;
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
                console.log('Input event, query:', query);
                
                debounceTimer = setTimeout(function() {
                    fetchSuggestions(query);
                }, 300);
            });
            
            console.log('Autocomplete initialized');

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
                const td = buttonElement.parentElement;
                td.innerHTML = '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">✓ Present</span>';
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
