<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f8fa;
            font-family: 'Raleway', sans-serif;
        }

        .scrollable {
            overflow-y: auto;
        }

        textarea {
            resize: none;
        }
    </style>
</head>

<body>
    <nav class="bg-white shadow-md">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <!-- Logo -->
            <a href="#" class="text-2xl font-bold text-blue-600 hover:text-blue-700">Laravel Chat</a>
    
            <!-- Navigation Links -->
            <ul class="flex space-x-6">
                @guest
                    <li>
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-500 hover:underline font-medium">
                            Login
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" class="text-gray-600 hover:text-blue-500 hover:underline font-medium">
                            Register
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('conversations.index') }}" class="text-gray-600 hover:text-blue-500 hover:underline font-medium">
                            Message
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="get" class="inline">
                            <button type="submit" class="text-gray-600 hover:text-red-500 hover:underline font-medium">
                                Logout
                            </button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>
    
    {{-- <div>
        <div id="messages" style="border: 1px solid #ccc; height: 200px; overflow-y: auto; padding: 10px;">
            <!-- Messages will appear here -->
        </div>
        <input type="text" id="messageInput" placeholder="Type your message..." />
        <button onclick="sendBroadcastMessage()">Broadcast</button>
        <button onclick="sendPrivateMessage(2)">Private to 2</button>
    </div> --}}

    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        const socket = new WebSocket('ws://127.0.0.1:8082');

        // WebSocket event handlers
        socket.onopen = () => {
            console.log('WebSocket connection established.');
        };

        socket.onmessage = (event) => {
            const data = JSON.parse(event.data);

            if (data.type === 'system') {
                console.log('System Message:', data.message);
            } else if (data.type === 'broadcast') {
                getChatMessages(data.message)
                // displayMessage(`Broadcast: ${data.message}`);
            } else if (data.type === 'private') {
                displayMessage(`Private: ${data.message}`);
            }
        };

        socket.onerror = (error) => {
            console.error('WebSocket error:', error);
        };

        socket.onclose = () => {
            console.log('WebSocket connection closed.');
        };

        
        function getChatMessages(conversationId) {
           
            $.ajax({
                url: "{{ url('getConversation') }}"+"/"+conversationId,
                type: "GET",
                success: function(res) {
                    $('.chat').html(res.html);
                }
            })
        }
        $(document).ready(function() {
            getUserList()
            
           
        })
        function newChat(){
            $(".new-chat-start").on('click', function() {
                let userId = $(this).attr("data-conversation-id")
                $.ajax({
                    url: "{{ url('conversations/create') }}" + "/" + userId,
                    type: "GET",
                    success: function(res) {
                        $('.chat').html(res.html);
                    }
                })
            })
        }
        function conversationChat(){
            $('.conversation-chat').on('click',function(){
                getChatMessages($(this).attr("data-conversation-id"))
            })
        }

        function getUserList(){
            $.ajax({
                url:"{{ route('user.list') }}",
                type:"GET",
                success:function(res){
                    // console.log(res);
                    $('.user-list').html(res.html);
                    newChat()
                    conversationChat()
                }
            })
        }
        // Send broadcast message
        function sendBroadcastMessage(newChat = null) {
            const message = $('#receiver_id').val()
        
            if (message) {
                $.ajax({
                    url: "{{ route('conversations.store') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "receiver_id": $('#receiver_id').val(),
                        "message": $("#message").val()
                    },
                    success: function(res) {
                        if(newChat !== null){
                            getUserList()
                        }
                        let message = res[0]
                        socket.send(JSON.stringify({
                            type: 'broadcast',
                            message
                        }));
                    }
                })
                
            }
        }

        // Send private message
        function sendPrivateMessage(targetId) {
            const input = document.getElementById('messageInput');
            const message = input.value;
            if (message) {
                socket.send(JSON.stringify({
                    type: 'private',
                    targetId,
                    message
                }));
                input.value = '';
            }
        }

        // Display message in UI
        function displayMessage(message) {
            const messageContainer = document.getElementById('messages');
            const newMessage = document.createElement('div');
            newMessage.textContent = message;
            messageContainer.appendChild(newMessage);
        }
    </script>
    @yield('content')
</body>

</html>
