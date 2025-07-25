<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Design;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ChatController extends Controller
{
    public function show(Design $design)
    {
        // Check if user has access to this design
        if (Auth::user()->role === 'admin' || $design->user_id === Auth::id()) {
            // Find or create conversation
            $conversation = Conversation::firstOrCreate([
                'design_id' => $design->id,
                'user_id' => $design->user_id,
                'admin_id' => User::where('role', 'admin')->first()->id ?? 1,
            ]);

            $messages = $conversation->messages()->with('sender')->orderBy('created_at', 'asc')->get();

            return view('chat.show', compact('conversation', 'messages', 'design'));
        }

        abort(403);
    }

    public function store(Request $request, Conversation $conversation)
    {
        // Check if user has access to this conversation
        if (Auth::user()->role === 'admin' || $conversation->user_id === Auth::id()) {
            $request->validate([
                'body' => 'required|string|max:1000',
            ]);

            $message = $conversation->messages()->create([
                'sender_id' => Auth::id(),
                'body' => $request->body,
            ]);

            // Broadcast the message to update the chat window
            broadcast(new MessageSent($message))->toOthers();

            // Broadcast the notification to the recipient
            $senderName = Auth::user()->name;
            broadcast(new \App\Events\NewMessageNotification($message, $senderName));

            return response()->json($message->load('sender'));
        }

        abort(403);
    }
}
