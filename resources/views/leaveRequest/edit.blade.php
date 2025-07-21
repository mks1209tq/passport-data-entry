@php
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.app')

@section('content')
<div class="pt-3">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 flex flex-row">
                <div class="w-4/12 px-3">
                    <form action="{{ route('leave-requests.update', $leaveRequest->id) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $leaveRequest->id }}">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="employee_id">
                                ID
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="id"
                                type="text"
                                name="id"
                                value="{{ old('id', $leaveRequest->id) }}"
                                readonly>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="passport_expiry_date">
                                Passport Expiry Date
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="passport_expiry_date"
                                type="date"
                                name="passport_expiry_date"
                                value="{{ old('passport_expiry_date', $leaveRequest->passport_expiry_date) }}"
                                autofocus>
                        </div>
                   
                        <div class="flex items-center justify-between">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mr-2 rounded focus:outline-none focus:shadow-outline"
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