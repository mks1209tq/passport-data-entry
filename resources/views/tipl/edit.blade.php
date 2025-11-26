<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit TIPL Entry') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <a href="{{ route('tipl.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">← Back to TIPL Entries</a>
                    </div>

                    <form method="POST" action="{{ route('tipl.update', $tipl->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

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
                                    value="{{ old('name', $tipl->name) }}" 
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
                                    value="{{ old('employee_id', $tipl->employee_id) }}"
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
                                    value="{{ old('company_name', $tipl->company_name) }}"
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
                                    value="{{ old('phone_number', $tipl->phone_number) }}"
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
                                    value="{{ old('expected_guests', $tipl->expected_guests) }}"
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
                                    Pick Up Point <span class="text-red-500">*</span>
                                </label>
                                @php
                                    $pickUpPoint = old('pick_up_point', $tipl->pick_up_point);
                                    // Map old values to new values for backward compatibility
                                    $pickUpPointMap = [
                                        'Point 1' => 'Al Quoz',
                                        'Point 2' => 'International City',
                                        'Point 3' => 'ADCB',
                                        'Point 4' => 'Head Office',
                                    ];
                                    if (isset($pickUpPointMap[$pickUpPoint])) {
                                        $pickUpPoint = $pickUpPointMap[$pickUpPoint];
                                    }
                                @endphp
                                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                                    <div class="flex items-center">
                                        <input 
                                            type="radio" 
                                            name="pick_up_point" 
                                            id="pick_up_point_self" 
                                            value="Self"
                                            {{ $pickUpPoint == 'Self' ? 'checked' : '' }}
                                            required
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                        >
                                        <label for="pick_up_point_self" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                            Self
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input 
                                            type="radio" 
                                            name="pick_up_point" 
                                            id="pick_up_point_1" 
                                            value="Al Quoz"
                                            {{ $pickUpPoint == 'Al Quoz' ? 'checked' : '' }}
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                        >
                                        <label for="pick_up_point_1" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                            Al Quoz
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input 
                                            type="radio" 
                                            name="pick_up_point" 
                                            id="pick_up_point_2" 
                                            value="International City"
                                            {{ $pickUpPoint == 'International City' ? 'checked' : '' }}
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                        >
                                        <label for="pick_up_point_2" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                            International City
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input 
                                            type="radio" 
                                            name="pick_up_point" 
                                            id="pick_up_point_3" 
                                            value="ADCB"
                                            {{ $pickUpPoint == 'ADCB' ? 'checked' : '' }}
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                        >
                                        <label for="pick_up_point_3" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                            ADCB
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input 
                                            type="radio" 
                                            name="pick_up_point" 
                                            id="pick_up_point_4" 
                                            value="Head Office"
                                            {{ $pickUpPoint == 'Head Office' ? 'checked' : '' }}
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                        >
                                        <label for="pick_up_point_4" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                            Head Office
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
                                            {{ old('in_house_talent', $tipl->in_house_talent) == 'yes' ? 'checked' : '' }}
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
                                            {{ old('in_house_talent', $tipl->in_house_talent) == 'no' ? 'checked' : '' }}
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
                            <a 
                                href="{{ route('tipl.index') }}" 
                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-150 ease-in-out border-2 border-gray-600 whitespace-nowrap"
                                style="background-color: #6b7280; color: #ffffff; min-width: 100px;"
                            >
                                Cancel
                            </a>
                            <button 
                                type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-150 ease-in-out border-2 border-blue-700 whitespace-nowrap"
                                style="background-color: #2563eb; color: #ffffff; min-width: 120px;"
                            >
                                Update Entry
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

