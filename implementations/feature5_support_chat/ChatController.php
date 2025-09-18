<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    // Fetch chat history between customer and agent
    public function history($customerId, $agentId)
    {
        $messages = ChatMessage::where(function($q) use ($customerId, $agentId) {
                $q->where('sender_id', $customerId)->where('receiver_id', $agentId);
            })->orWhere(function($q) use ($customerId, $agentId) {
                $q->where('sender_id', $agentId)->where('receiver_id', $customerId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    // Store new message (REST fallback, but usually via WebSocket)
    public function send(Request $request)
    {
        $request->validate([
            'sender_id'   => 'required|integer',
            'receiver_id' => 'required|integer',
            'message'     => 'required|string',
        ]);

        $chat = ChatMessage::create([
            'sender_id'   => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'message'     => $request->message,
            'is_read'     => false,
        ]);

        return response()->json($chat, 201);
    }
}
