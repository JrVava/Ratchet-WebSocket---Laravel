@extends('layout.layout')

@section('content')
    <div class="container mx-auto">
        <div class="mt-10 flex h-[calc(100vh-4rem)]">
            <!-- Left Side: User List -->
            <div class="w-1/4 bg-white shadow-lg overflow-y-auto">
                <div class="p-4 bg-gradient-to-r from-green-400 to-blue-500 text-white text-xl font-bold">
                    Users
                </div>
                <div class="user-list"></div>
            </div>
            <div class="chat w-full">
            </div>
        </div>
    </div>

@endsection
