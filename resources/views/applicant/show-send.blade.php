<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Send Applicants Data') }}
        </h2>
    </x-slot>

    @section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error Message --}}
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('applicants.send') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Send Data to UI System
                        </button>
                    </form>

                    {{-- Queue Status --}}
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-4">Queue Status:</h3>
                        <div class="bg-gray-100 p-4 rounded">
                            <p>Pending Jobs: {{ \DB::table('jobs')->count() }}</p>
                            <p>Failed Jobs: {{ \DB::table('failed_jobs')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
