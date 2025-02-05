<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use App\WebSocket\Chat;
use Illuminate\Support\Facades\Log;

class WebSocketServer extends Command
{
    protected $signature = 'websocket:serve {--port=8080 : The port to serve the WebSocket server on}';
    protected $description = 'Start the WebSocket server';

    public function handle()
    {
        $port = $this->option('port');
        $this->info("Starting WebSocket server on port {$port}...");
        Log::info("hello");
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat() // Your custom WebSocket handler
                )
            ),
            $port
        );

        $server->run();
    }
}
