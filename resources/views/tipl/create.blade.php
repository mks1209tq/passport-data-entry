<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sports Event - TIPL Data Entry') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">← Back to Dashboard</a>
                        @else
                            <a href="{{ url('/') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">← Back to Home</a>
                        @endauth
                    </div>

                    @if(session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if(isset($isRegistrationClosed) && $isRegistrationClosed)
                        <div class="mb-6 bg-red-100 border-2 border-red-400 text-red-700 px-6 py-4 rounded-lg text-center" role="alert">
                            <h3 class="text-lg font-bold mb-2">Registration is Closed</h3>
                            <p class="text-sm">We have reached the maximum limit of 255 entries. Thank you for your interest!</p>
                            <p class="text-xs mt-2 text-gray-600">Total entries: {{ $totalEntries ?? 255 }}</p>
                        </div>
                    @else
                        <!-- ID Verification Section -->
                        <div id="id-verification-section" class="mb-6 p-4 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-900">
                            <label for="tq_user_id_input" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Enter ID <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-3">
                                <input 
                                    type="text" 
                                    id="tq_user_id_input" 
                                    placeholder="Enter ID"
                                    class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                <button 
                                    type="button" 
                                    id="verify-id-btn"
                                    class="px-6 py-2 bg-indigo-600 text-white rounded-md font-medium hover:bg-indigo-700 transition-colors border-2 border-indigo-700 whitespace-nowrap"
                                    style="background-color: #2563eb; color: #ffffff; min-width: 120px;"
                                >
                                    Verify ID
                                </button>
                            </div>
                            <div id="id-verification-message" class="mt-2 text-sm hidden"></div>
                        </div>

                        <form method="POST" action="{{ route('tipl.store') }}" class="space-y-6" id="tipl-form" style="display: none;">
                            @csrf
                            <input type="hidden" name="tq_user_id" id="tq_user_id" value="">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Name <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name" 
                                    value="{{ old('name') }}" 
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('name') border-red-500 @enderror"
                                >
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Employee ID -->
                            <div>
                                <label for="employee_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Employee ID <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="employee_id" 
                                    id="employee_id" 
                                    value="{{ old('employee_id') }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('employee_id') border-red-500 @enderror"
                                >
                                @error('employee_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Company Name -->
                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Company Name <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="company_name" 
                                    id="company_name" 
                                    value="{{ old('company_name') }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('company_name') border-red-500 @enderror"
                                >
                                @error('company_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="tel" 
                                    name="phone_number" 
                                    id="phone_number" 
                                    value="{{ old('phone_number') }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('phone_number') border-red-500 @enderror"
                                >
                                @error('phone_number')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Expected Guests -->
                            <div>
                                <label for="expected_guests" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Expected Guests <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    name="expected_guests" 
                                    id="expected_guests" 
                                    value="{{ old('expected_guests') }}"
                                    required
                                    min="0"
                                    max="9999"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('expected_guests') border-red-500 @enderror"
                                >
                                @error('expected_guests')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Pick Up Point (Radio Buttons) -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    Pick Up Point
                                </label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="flex items-center">
                                        <input 
                                            type="radio" 
                                            name="pick_up_point" 
                                            id="pick_up_point_1" 
                                            value="Point 1"
                                            {{ old('pick_up_point') == 'Point 1' ? 'checked' : '' }}
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                        >
                                        <label for="pick_up_point_1" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                            Point 1
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input 
                                            type="radio" 
                                            name="pick_up_point" 
                                            id="pick_up_point_2" 
                                            value="Point 2"
                                            {{ old('pick_up_point') == 'Point 2' ? 'checked' : '' }}
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                        >
                                        <label for="pick_up_point_2" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                            Point 2
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input 
                                            type="radio" 
                                            name="pick_up_point" 
                                            id="pick_up_point_3" 
                                            value="Point 3"
                                            {{ old('pick_up_point') == 'Point 3' ? 'checked' : '' }}
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                        >
                                        <label for="pick_up_point_3" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                            Point 3
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input 
                                            type="radio" 
                                            name="pick_up_point" 
                                            id="pick_up_point_4" 
                                            value="Point 4"
                                            {{ old('pick_up_point') == 'Point 4' ? 'checked' : '' }}
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                        >
                                        <label for="pick_up_point_4" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                            Point 4
                                        </label>
                                    </div>
                                </div>
                                @error('pick_up_point')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- In-House Talent (Yes/No Radio Buttons) -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    In-House Talent
                                </label>
                                <div class="flex gap-6">
                                    <div class="flex items-center">
                                        <input 
                                            type="radio" 
                                            name="in_house_talent" 
                                            id="in_house_talent_yes" 
                                            value="yes"
                                            {{ old('in_house_talent') == 'yes' ? 'checked' : '' }}
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                        >
                                        <label for="in_house_talent_yes" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input 
                                            type="radio" 
                                            name="in_house_talent" 
                                            id="in_house_talent_no" 
                                            value="no"
                                            {{ old('in_house_talent') == 'no' ? 'checked' : '' }}
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                        >
                                        <label for="in_house_talent_no" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                            No
                                        </label>
                                    </div>
                                </div>
                                @error('in_house_talent')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                @auth
                                    <a 
                                        href="{{ route('dashboard') }}" 
                                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-150 ease-in-out border-2 border-gray-600 whitespace-nowrap"
                                        style="background-color: #6b7280; color: #ffffff; min-width: 100px;"
                                    >
                                        Cancel
                                    </a>
                                @endauth
                                <button 
                                    type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-150 ease-in-out border-2 border-blue-700 whitespace-nowrap"
                                    style="background-color: #2563eb; color: #ffffff; min-width: 120px;"
                                >
                                    Submit Entry
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const verifyBtn = document.getElementById('verify-id-btn');
            const idInput = document.getElementById('tq_user_id_input');
            const messageDiv = document.getElementById('id-verification-message');
            const form = document.getElementById('tipl-form');
            const hiddenIdInput = document.getElementById('tq_user_id');

            verifyBtn.addEventListener('click', function() {
                const idCode = idInput.value.trim();
                
                if (!idCode) {
                    showMessage('Please enter an ID.', 'error');
                    return;
                }

                verifyBtn.disabled = true;
                verifyBtn.textContent = 'Verifying...';

                fetch('{{ route("tipl.verify-id") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ id_code: idCode })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.valid) {
                        showMessage('✓ ID verified! Welcome, ' + data.name + '. You can now fill in the form.', 'success');
                        hiddenIdInput.value = idCode;
                        form.style.display = 'block';
                        idInput.disabled = true;
                        verifyBtn.style.display = 'none';
                    } else {
                        showMessage('✗ ' + data.message, 'error');
                        form.style.display = 'none';
                        hiddenIdInput.value = '';
                    }
                })
                .catch(error => {
                    showMessage('✗ An error occurred. Please try again.', 'error');
                    console.error('Error:', error);
                })
                .finally(() => {
                    verifyBtn.disabled = false;
                    verifyBtn.textContent = 'Verify ID';
                });
            });

            function showMessage(message, type) {
                messageDiv.textContent = message;
                messageDiv.classList.remove('hidden');
                if (type === 'success') {
                    messageDiv.className = 'mt-2 text-sm text-green-600 dark:text-green-400';
                } else {
                    messageDiv.className = 'mt-2 text-sm text-red-600 dark:text-red-400';
                }
            }

            // Allow Enter key to trigger verification
            idInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    verifyBtn.click();
                }
            });
        });
    </script>
</x-app-layout>

