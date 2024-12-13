<?php

namespace App\WebSocket;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "New connection: ({$conn->resourceId})\n";
        $conn->send(json_encode(['type' => 'system', 'message' => 'Welcome to the WebSocket server!']));
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        echo "Message received from {$from->resourceId}: {$msg}\n";
        $data = json_decode($msg, true);

        if (isset($data['type']) && $data['type'] === 'broadcast') {
            // Broadcast the message to all connected clients
            foreach ($this->clients as $client) {
                $client->send(json_encode(['type' => 'broadcast', 'message' => $data['message']]));
            }
        } elseif (isset($data['type']) && $data['type'] === 'private') {
            // Handle private messages (if IDs or targets are implemented)
            $targetId = $data['targetId'] ?? null;
            foreach ($this->clients as $client) {
                // if ($client->resourceId == $targetId) {
                $client->send(json_encode(['type' => 'private', 'message' => $data['message']]));
                // }
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error: {$e->getMessage()}\n";
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
