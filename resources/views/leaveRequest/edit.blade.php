@php
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.app')

@section('content')
<div class="pt-2">
    <div class="max-w-7xl mx-auto sm:px-2 lg:px-0">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 flex flex-row">
                <div class="w-4/12 px-2">
                    <form action="{{ route('leave-requests.update', $leaveRequest->id) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-2 pb-1 mb-1">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $leaveRequest->id }}">

                       <!-- LEAVE APPLICATION FORM -->
<div class="max-w-3xl mx-auto p-1 bg-white shadow-md rounded">
    <h2 class="text-2xl font-bold text-center mb-2">Leave Application Form</h2>

    <!-- Submission Date -->
    <div class="mb-1">
        <label class="block text-gray-700 text-sm font-bold mb-2">Submission Date</label>
        <input type="date" name="submissionDate"
            class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>

        <!-- ID No -->
    <div class="mb-1">
        <label class="block text-gray-700 text-sm font-bold mb-2">ID No</label>
        <input required type="text" name="employeeId"
            class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    

    <!-- Leave Type -->
    <div class="mb-1">
    <label class="block text-gray-700 text-sm font-bold mb-2">Leave Type</label>
    <div class="flex gap-6">
        <label class="inline-flex items-center">
            <input type="radio" name="leaveType" value="Annual"
                class="form-radio text-blue-500">
            <span class="ml-2">Annual</span>
        </label>
        <label class="inline-flex items-center">
            <input type="radio" name="leaveType" value="Medical"
                class="form-radio text-blue-500">
            <span class="ml-2">Medical</span>
        </label>
        <label class="inline-flex items-center">
            <input type="radio" name="leaveType" value="Emergency"
                class="form-radio text-blue-500">
            <span class="ml-2">Emergency</span>
        </label>
    </div>
</div>

    <!-- Leave Period -->
    <div class="grid grid-cols-2 gap-4 mb-1">
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Leave Start Date</label>
            <input type="date" name="leaveStartDate"
                class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Leave End Date</label>
            <input type="date" name="leaveEndDate"
                class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <!-- <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Duration (Days)</label>
            <input type="number" name="duration"
                class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div> -->
    </div>

    <!-- Contact Address -->
    <div class="mb-1">
        <label class="block text-gray-700 text-sm font-bold mb-2">Contact Address (Home Country)</label>
        <textarea name="destinationAddress" rows="2"
            class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
    </div>

    <!-- Contact Numbers -->
    <div class="grid grid-cols-2 gap-4 mb-1">
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Contact No.</label>
            <input type="number" name="destinationPhone"
                class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Contact No. (UAE)</label>
            <input type="number" name="contactNumberUAE"
                class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
    </div>

    <!-- Email -->
    <div class="mb-1">
        <label class="block text-gray-700 text-sm font-bold mb-2">E-Mail</label>
        <input type="email" name="employeeEmail"
            class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    
</div>



                        <div class="flex items-center justify-between">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1  px-3 mr-4 my-5 rounded focus:outline-none focus:shadow-outline"
                                type="submit">
                                Update Leave Request
                            </button>
                            <a href="{{ route('dashboard') }}"
                                class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
                <div class="w-8/12 px-20" style="height: calc(100vh - 180px);">
                    <?php
                    $file = $leaveRequest->leaveRequestId . '.pdf';
                    

                    $docUrl = null;
                    
                    if ($file && Storage::disk('idrive_e2')->exists($file)) {
                        $cacheKey = 'leave_request_file_' . $leaveRequest->id;
                        $docUrl = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($file) {
                            return Storage::disk('idrive_e2')->temporaryUrl($file, now()->addMinutes(5));
                        });
                        $docUrl .= '#view=FitV';
                    }
                    ?>

                    <div class="w-full h-full">
                        @if($docUrl)
                            <iframe class="embed-responsive-item w-full h-full" src="{{ $docUrl }}" allowfullscreen></iframe>
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-100 rounded-lg">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No document available</h3>
                                    <p class="mt-1 text-sm text-gray-500">The document file could not be found or is not accessible.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection