@extends('layout.layout')

@section('content')
    <div class="container mx-auto">
        <div class="mt-10 flex h-[calc(100vh-4rem)]">
            <!-- Left Side: User List -->
            <div class="w-1/4 bg-white shadow-lg overflow-y-auto">
                <div class="p-4 bg-gradient-to-r from-green-400 to-blue-500 text-white text-xl font-bold">
                    Users
                </div>
                <ul class="space-y-4 p-4">
                    @foreach ($conversationLists as $conversationList)
                        <li class="p-2 bg-gray-100 hover:bg-gray-200 rounded cursor-pointer">
                            <button type="button" data-conversation-id="{{ $conversationList->id }}" class="conversation-chat">
                                <div class="text-gray-800 font-semibold">
                                    {{ $conversationList->userOne->id == auth()->id() ? $conversationList->userTwo->name . ' ' . $conversationList->userOne->id : $conversationList->userOne->name }}
                                </div>
                                <div class="text-sm text-gray-600">
                                    {{ $conversationList->userOne->id == auth()->id() ? $conversationList->userTwo->email : $conversationList->userOne->email }}
                                </div>
                            </button>
                        </li>
                    @endforeach
                    @foreach ($usersNotInConversation as $user)
                        <li class="p-2 bg-gray-100 hover:bg-gray-200 rounded cursor-pointer">
                            <a href="{{ route('conversations.create', ['user_id' => $user->id]) }}">
                                <div class="text-gray-800 font-semibold">
                                    {{ $user->name }}
                                </div>
                                <div class="text-sm text-gray-600">
                                    {{ $user->email }}
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="chat w-full">
            </div>
        </div>
    </div>
@endsection
