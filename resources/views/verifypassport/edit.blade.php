@extends('layouts.app')

@section('content')

<div class="pt-3">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 flex flex-row">
                <div class="w-4/12 px-3">
                    <form action="{{ route('verify-passports.update', $passport->id) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" value="{{ $passport->id }}">
                        <input type="hidden" name="data_correct_value" value="1">

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="employee_id">
                                ID
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="id"
                                type="text"
                                name="id"
                                value="{{ old('id', $passport->id) }}"
                                disabled>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="passport_expiry_date">
                                Passport Expiry Date
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="passport_expiry_date"
                                type="date"
                                name="passport_expiry_date"
                                value="{{ old('passport_expiry_date', $passport->passport_expiry_date) }}"
                                autofocus disabled>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="visa_expiry_date">
                                Visa Expiry Date
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="visa_expiry_date"
                                type="date"
                                name="visa_expiry_date"
                                value="{{ old('visa_expiry_date', $passport->visa_expiry_date) }}"
                                disabled>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="file_type">
                                File Type
                            </label>
                            <fieldset>
                                <input class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="is_passport"
                                    type="checkbox"
                                    name="is_passport"
                                    value="1"
                                    {{ old('is_passport', $passport->is_passport) ? 'checked' : '' }}
                                    disabled> is_passport
                                <br>
                                <input class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="is_visa"
                                    type="checkbox"
                                    name="is_visa"
                                    value="1"
                                        {{ old('is_visa', $passport->is_visa) ? 'checked' : '' }}
                                    > is_visa
                                <br>
                                <input class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="is_photo"
                                    type="checkbox"
                                    name="is_photo"
                                    value="1"
                                    {{ old('is_photo', $passport->is_photo) ? 'checked' : '' }}
                                    disabled> is_photo

                                <br>
                                <input class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="is_no_file_uploaded"
                                    type="checkbox"
                                    name="is_no_file_uploaded"
                                    value="1"
                                    {{ old('is_no_file_uploaded', $passport->is_no_file_uploaded) ? 'checked' : '' }}
                                    disabled>
                                    No File Uploaded
                            </fieldset>
                            <br>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="issue">Issue<br>
                                <input class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="issue"
                                    type="text"
                                    name="issue"
                                    value="{{ old('issue', $passport->issue) }}"
                                    placeholder="Please enter any issues here"
                                    disabled>
                                    
                        </div>

                        <div class="flex items-center justify-between">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mr-2 rounded focus:outline-none focus:shadow-outline"
                                type="submit">
                                Mark as Verified
                            </button>
                            <a href="{{ route('verify-passports.index') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mr-2 rounded focus:outline-none focus:shadow-outline">
                                Cancel
                            </a>
                        </div>
                    </form>
                    
                </div>
                <div class="w-8/12 px-20" style="height: calc(100vh - 180px);">
                    <?php
                    $file = $passport->file_name;
                    $docUrl = Storage::disk('idrive_e2')->temporaryUrl($file, now()->addMinutes(5));
                    $docUrl .= '#view=FitV';
                    ?>

                    <div class="w-full h-full">
                        <iframe class="embed-responsive-item w-full h-full" src="{{ $docUrl }}" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection