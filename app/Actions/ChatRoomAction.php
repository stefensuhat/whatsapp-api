<?php

namespace App\Actions;

use App\Models\ChatRoom;

class ChatRoomAction
{
    public function create(array $data)
    {
        $chatroom = Chatroom::create($data);

        return $chatroom;
    }

    public function join(Chatroom $chatroom, $userId): ChatRoom
    {
        if ($chatroom->users()->count() >= $chatroom->max_members) {
            throw new \Exception('Chatroom is full');
        }

        $chatroom->users()->attach($userId);

        return $chatroom;
    }

    public function leave(Chatroom $chatroom, $userId): ChatRoom
    {
        $chatroom->users()->detach($userId);

        return $chatroom;
    }
}
