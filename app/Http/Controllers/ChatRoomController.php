<?php

namespace App\Http\Controllers;

use App\Actions\ChatRoomAction;
use App\Models\ChatRoom;
use Illuminate\Http\Request;

class ChatRoomController extends Controller
{
    protected ChatRoomAction $chatRoomAction;

    public function __construct(ChatRoomAction $chatRoomAction)
    {
        $this->chatRoomAction = $chatRoomAction;
    }

    public function index()
    {
        $chatRooms = Chatroom::all();

        return response()->json($chatRooms);
    }

    public function show(Chatroom $chatroom)
    {
        return response()->json($chatroom);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'max_members' => 'integer',
        ]);

        $chatroom = $this->chatRoomAction->create($validated);

        return response()->json($chatroom, 201);
    }

    public function join($id): \Illuminate\Http\JsonResponse
    {
        $chatroom = $this->chatRoomAction->join(
            Chatroom::findOrFail($id),
            auth()->id()
        );

        return response()->json($chatroom);
    }

    public function leave($id): \Illuminate\Http\JsonResponse
    {
        $chatroom = $this->chatRoomAction->leave(
            Chatroom::findOrFail($id),
            auth()->id()
        );

        return response()->json($chatroom);
    }
}
