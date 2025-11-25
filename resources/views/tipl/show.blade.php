<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('TIPL Entry Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <a href="{{ route('tipl.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">← Back to TIPL Entries</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Name</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ $tipl->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Employee ID</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tipl->employee_id ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Company Name</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tipl->company_name ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Phone Number</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tipl->phone_number ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Pick Up Point</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tipl->pick_up_point ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">In-House Talent</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                @if($tipl->in_house_talent)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $tipl->in_house_talent == 'yes' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' }}">
                                        {{ ucfirst($tipl->in_house_talent) }}
                                    </span>
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Created At</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tipl->created_at->format('Y-m-d H:i:s') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Updated At</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tipl->updated_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700 mt-6">
                        <a 
                            href="{{ route('tipl.index') }}" 
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-150 ease-in-out border-2 border-gray-600 whitespace-nowrap"
                            style="background-color: #6b7280; color: #ffffff; min-width: 100px;"
                        >
                            Back
                        </a>
                        <a 
                            href="{{ route('tipl.edit', $tipl->id) }}" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-150 ease-in-out border-2 border-blue-700 whitespace-nowrap"
                            style="background-color: #2563eb; color: #ffffff; min-width: 100px;"
                        >
                            Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

