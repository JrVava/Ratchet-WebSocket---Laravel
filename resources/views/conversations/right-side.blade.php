<div class="flex flex-col h-screen bg-gray-50">
    <!-- Chat Header -->
    <div class="bg-blue-600 text-white text-lg font-semibold py-4 px-6 shadow-md flex items-center">
        <!-- Avatar -->
        <div class="flex items-center justify-center w-10 h-10 bg-blue-500 rounded-full text-white mr-4 text-lg font-bold">
            {{ strtoupper(substr(($conversation->userOne->id == auth()->user()->id ? $conversation->userTwo->name : $conversation->userOne->name), 0, 1)) }}
        </div>
        <!-- Name -->
        <div>
            {{ $conversation->userOne->id == auth()->user()->id ? $conversation->userTwo->name : $conversation->userOne->name }}
        </div>
    </div>
    
    <div class="flex-grow flex flex-col bg-gray-100">
        <!-- Messages Section -->
        <div class="mt-16 mb-20 p-4 space-y-4 overflow-y-auto flex-grow max-h-full">
            @foreach ($messages as $message)
                @if ($message->sender_id != auth()->user()->id)
                    <div class="flex flex-col items-start">
                        <div class="bg-gray-300 p-4 rounded-lg shadow-md w-9/12 relative message-left">
                            <div class="text-sm font-semibold text-gray-700 mb-2">{{ $message->sender->name }}</div>
                            <div class="text-gray-800">{{ $message->message }}</div>
                            <div class="text-right text-xs text-gray-600 mt-2">
                                <span>{{ $message->created_at->diffForHumans() }}</span>
                                @include('partials.message-tick', ['isRead' => $message->is_read])
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex flex-col items-end">
                        <div class="bg-blue-500 text-white p-4 rounded-lg shadow-md w-9/12 relative message-right">
                            <div class="text-sm font-semibold mb-2">You</div>
                            <div>{{ $message->message }}</div>
                            <div class="text-right text-xs mt-2">
                                <span>{{ $message->created_at->diffForHumans() }}</span>
                                @include('partials.message-tick', ['isRead' => $message->is_read])
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Message Input Section -->
        <div class="fixed bottom-0 w-4/5 bg-gray-100 flex items-center px-4 py-2">
            <input type="hidden" name="receiver_id" id="receiver_id"
                value="{{ $conversation->user_one == auth()->id() ? $conversation->user_two : $conversation->user_one }}">
            <textarea name="message" id="message" rows="1" placeholder="Type your message..."
                class="flex-grow px-4 py-2 mr-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
            <button type="button" onclick="sendBroadcastMessage()"
                class="bg-white-500 text-white p-3 rounded-full shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <svg class="svg-inline--fa text-blue-400 fa-paper-plane fa-w-16 w-12 h-12 py-2 mr-2" aria-hidden="true"
                    focusable="false" data-prefix="fas" data-icon="paper-plane" role="img"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor"
                        d="M476 3.2L12.5 270.6c-18.1 10.4-15.8 35.6 2.2 43.2L121 358.4l287.3-253.2c5.5-4.9 13.3 2.6 8.6 8.3L176 407v80.5c0 23.6 28.5 32.9 42.5 15.8L282 426l124.6 52.2c14.2 6 30.4-2.9 33-18.2l72-432C515 7.8 493.3-6.8 476 3.2z">
                    </path>
                </svg>
            </button>
        </div>
    </div>
</div>
<style>
    .message-left::before {
    content: '';
    position: absolute;
    top: 15px; /* Adjust to align with the bubble */
    left: -8px; /* Position the triangle */
    width: 0;
    height: 0;
    border-top: 8px solid transparent;
    border-bottom: 8px solid transparent;
    border-right: 8px solid #d1d5db; /* Match the background color of the left bubble */
}

.message-right::after {
    content: '';
    position: absolute;
    top: 15px; /* Adjust to align with the bubble */
    right: -8px; /* Position the triangle */
    width: 0;
    height: 0;
    border-top: 8px solid transparent;
    border-bottom: 8px solid transparent;
    border-left: 8px solid #3b82f6; /* Match the background color of the right bubble */
}

    </style>