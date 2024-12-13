<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;

class ConversationController extends Controller
{
    public function index()
    {
        $conversations = Conversation::where('user_one', auth()->id())
            ->orWhere('user_two', auth()->id())
            ->with(['userOne', 'userTwo', 'messages'])
            ->get();
        $users = User::where('id', '!=', auth()->id())->get();

        $excludedUserIds = $conversations->flatMap(function ($conversation) {
            return [$conversation->userOne->id, $conversation->userTwo->id];
        })->unique();

        $usersNotInConversation = $users->whereNotIn('id', $excludedUserIds);
        return view('conversations.index', compact('conversations', 'usersNotInConversation'));
    }

    public function getUserList()
    {
        $conversations = Conversation::where('user_one', auth()->id())
            ->orWhere('user_two', auth()->id())
            ->with(['userOne', 'userTwo', 'messages'])
            ->get();
        $users = User::where('id', '!=', auth()->id())->get();

        $excludedUserIds = $conversations->flatMap(function ($conversation) {
            return [$conversation->userOne->id, $conversation->userTwo->id];
        })->unique();

        $usersNotInConversation = $users->whereNotIn('id', $excludedUserIds);
        $html = view('conversations.user-list', compact('conversations', 'usersNotInConversation'))->render();

        // Return the rendered HTML as a JSON response
        return response()->json(['html' => $html]);
    }

    public function show(Conversation $conversation)
    {
        exit;
        if ($conversation->user_one != auth()->id() && $conversation->user_two != auth()->id()) {
            abort(403);
        }

        $messages = $conversation->messages()->with('sender')->get();
        $conversationLists = Conversation::where('user_one', auth()->id())
            ->orWhere('user_two', auth()->id())
            ->with(['userOne', 'userTwo', 'messages'])
            ->get();
        $users = User::where('id', '!=', auth()->id())->get();

        $excludedUserIds = $conversationLists->flatMap(function ($conversation) {
            return [$conversation->userOne->id, $conversation->userTwo->id];
        })->unique();

        $usersNotInConversation = $users->whereNotIn('id', $excludedUserIds);
        return view('conversations.show', compact('conversation', 'usersNotInConversation', 'conversationLists', 'messages'));
    }

    public function getConversation($conversationId)
    {

        $conversation = Conversation::where('id', '=', $conversationId)->first();
        $messages = $conversation->messages()->with('sender')->get();
        // dd($messages);
        $html = view('conversations.right-side', compact('messages', 'conversation'))->render();

        // Return the rendered HTML as a JSON response
        return response()->json(['html' => $html]);
    }

    public function create($user_id)
    {
        $users = User::where('id', '!=', auth()->id())->get();
        $conversationLists = Conversation::where('user_one', auth()->id())
            ->orWhere('user_two', auth()->id())
            ->with(['userOne', 'userTwo', 'messages'])
            ->get();

        $excludedUserIds = $conversationLists->flatMap(function ($conversation) {
            return [$conversation->userOne->id, $conversation->userTwo->id];
        })->unique();

        $usersNotInConversation = $users->whereNotIn('id', $excludedUserIds);
        $userName = User::where('id', '=', $user_id)->first();
        $html = view('conversations.create', compact('usersNotInConversation', 'userName', 'user_id', 'conversationLists'))->render();

        // Return the rendered HTML as a JSON response
        return response()->json(['html' => $html]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        // Check if conversation exists
        $conversation = Conversation::where(function ($query) use ($request) {
            $query->where('user_one', auth()->id())
                ->where('user_two', $request->receiver_id);
        })->orWhere(function ($query) use ($request) {
            $query->where('user_one', $request->receiver_id)
                ->where('user_two', auth()->id());
        })->first();

        // Create a new conversation if it doesn't exist
        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one' => auth()->id(),
                'user_two' => $request->receiver_id,
            ]);
        }

        // Store the message
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);
        return response()->json([$conversation->id]);
    }
}
