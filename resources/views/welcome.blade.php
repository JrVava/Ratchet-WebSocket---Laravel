@extends('layout.layout')
  
@section('content')
    <div class="container mt-4">
        <div id="messages" style="border: 1px solid #ccc; height: 200px; overflow-y: auto; padding: 10px;">
            <!-- Messages will appear here -->
        </div>
        <input type="text" id="messageInput" class="form-control mt-2 mb-2" placeholder="Type your message..." />
        <button onclick="sendBroadcastMessage()" class="btn btn-success">Broadcast</button>
        <button onclick="sendPrivateMessage(2)" class="btn btn-primary">Private to 2</button>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
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
                displayMessage(`Broadcast: ${data.message}`);
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

        // Send broadcast message
        function sendBroadcastMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value;
            if (message) {
                socket.send(JSON.stringify({
                    type: 'broadcast',
                    message
                }));
                input.value = '';
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
            $('#messages').append(`<div>${message}</div>`);
        }
    </script>
@endsection
