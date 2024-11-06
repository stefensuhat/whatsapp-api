<?php

namespace App\Http\Controllers;

use App\Actions\MessageAction;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected MessageAction $messageAction;

    public function __construct(MessageAction $messageAction)
    {
        $this->messageAction = $messageAction;
    }

    public function index($chatroomId)
    {
     return Message::where('chat_room_id', $chatroomId)
            ->with('user')
            ->oldest()
            ->get();


    }

    public function store(Request $request, $chatroomId): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'content' => 'required_if:attachment,null',
            'attachment' => 'nullable',
        ]);

        $message = $this->messageAction->sendMessage($chatroomId, auth()->user()->id, $validated);

        return response()->json($message, 201);
    }
}
