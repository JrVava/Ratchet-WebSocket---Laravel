@extends('layout.layout')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-lg bg-white rounded-lg shadow-md">
        <!-- Card Header -->
        <div class="bg-blue-600 text-white text-lg font-bold p-4 rounded-t-lg">
            {{ __('Dashboard') }}
        </div>

        <!-- Card Body -->
        <div class="p-6">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <p class="text-gray-700 text-center text-lg">You are Logged In</p>
        </div>
    </div>
</div>
@endsection
