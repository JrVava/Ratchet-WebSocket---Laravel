<div class="flex flex-col h-screen bg-gray-50">
    <!-- Chat Header -->

    <div class="bg-blue-600 text-white text-lg font-semibold py-4 px-6 shadow-md flex items-center">
        <!-- Avatar -->
        <div class="flex items-center justify-center w-10 h-10 bg-blue-500 rounded-full text-white mr-4 text-lg font-bold">
            {{ strtoupper(substr(($userName->name), 0, 1)) }}
        </div>
        <!-- Name -->
        <div>
            {{ $userName->name }}
        </div>
    </div>
    <!-- Chat Messages Section -->
    <div class="flex-grow p-4 space-y-4 overflow-y-auto">
        <!-- Replace this section with dynamic messages -->
        <div class="text-center text-gray-500">No messages yet...</div>
    </div>

    <!-- Chat Input Section -->
    <div class="fixed bottom-0 w-4/5 bg-gray-100 shadow-lg flex items-center px-4 py-3">
        <!-- Hidden Input for Receiver ID -->
        <input type="hidden" name="receiver_id" id="receiver_id" value="{{ $user_id }}">

        <!-- Message Input -->
        <textarea 
            name="message" 
            id="message" 
            rows="1" 
            placeholder="Type your message..." 
            class="flex-grow px-4 py-2 mr-4 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
        ></textarea>

        <!-- Send Button -->
        <button 
            type="button" 
            onclick="sendBroadcastMessage()" 
            class="bg-blue-500 text-white p-3 rounded-full shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
            aria-label="Send Message"
        >
            <svg 
                class="w-6 h-6 text-white" 
                aria-hidden="true" 
                focusable="false" 
                data-prefix="fas" 
                data-icon="paper-plane" 
                role="img" 
                xmlns="http://www.w3.org/2000/svg" 
                viewBox="0 0 512 512"
            >
                <path 
                    fill="currentColor" 
                    d="M476 3.2L12.5 270.6c-18.1 10.4-15.8 35.6 2.2 43.2L121 358.4l287.3-253.2c5.5-4.9 13.3 2.6 8.6 8.3L176 407v80.5c0 23.6 28.5 32.9 42.5 15.8L282 426l124.6 52.2c14.2 6 30.4-2.9 33-18.2l72-432C515 7.8 493.3-6.8 476 3.2z"
                ></path>
            </svg>
        </button>
    </div>
</div>
