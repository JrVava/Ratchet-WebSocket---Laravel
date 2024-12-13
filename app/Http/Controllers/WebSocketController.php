<?php

namespace App\Http\Controllers;

use App\Events\WebSocketMessageSent;
use Illuminate\Http\Request;

class WebSocketController extends Controller
{
    public function sendBroadcast(Request $request)
    {
        $type = $request->input('type', 'broadcast');
        $message = $request->input('message');
        $targetId = $request->input('targetId');

        event(new WebSocketMessageSent($type, $message, $targetId));

        return response()->json(['status' => 'Message sent successfully']);
    }
}
