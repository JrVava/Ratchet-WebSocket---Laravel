<ul class="space-y-4 p-4">
    @foreach ($conversations as $conversation)
        <li class="p-2 bg-gray-100 hover:bg-gray-200 rounded cursor-pointer">
            <button type="button" data-conversation-id="{{ $conversation->id }}"
                class="conversation-chat">
                <div class="text-gray-800 font-semibold">
                    {{ $conversation->userOne->id == auth()->id() ? $conversation->userTwo->name : $conversation->userOne->name }}
                </div>
                <div class="text-sm text-gray-600">
                    {{ $conversation->userOne->id == auth()->id() ? $conversation->userTwo->email : $conversation->userOne->email }}
                </div>
            </button>
        </li>
    @endforeach
    @foreach ($usersNotInConversation as $user)
        <li class="p-2 bg-gray-100 hover:bg-gray-200 rounded cursor-pointer">
            <button type="button" class="new-chat-start" data-conversation-id="{{ $user->id }}">
                {{-- <a href="{{ route('conversations.create', ['user_id' => $user->id]) }}"> --}}
                <div class="text-gray-800 font-semibold">
                    {{ $user->id == auth()->id() ? $user->name . ' ' . $user->id : $user->name }}
                </div>
                <div class="text-sm text-gray-600">
                    {{ $user->id == auth()->id() ? $user->email : $user->email }}
                </div>
            </button>
        </li>
    @endforeach
</ul>