<?php

namespace App\Actions;

use App\Events\ChatroomUpdated;
use App\Models\ChatRoom;

class ChatRoomAction
{
    public function create(array $data)
    {
        $chatroom = Chatroom::create($data);

        broadcast(new ChatroomUpdated($chatroom))->toOthers();

        return $chatroom;
    }

    public function join(Chatroom $chatroom, $userId): ChatRoom
    {
        if ($chatroom->users()->count() >= $chatroom->max_members) {
            throw new \Exception('Chatroom is full');
        }

        $chatroom->users()->attach($userId);

        broadcast(new ChatroomUpdated($chatroom))->toOthers();

        return $chatroom;
    }

    public function leave(Chatroom $chatroom, $userId): ChatRoom
    {
        $chatroom->users()->detach($userId);

        broadcast(new ChatroomUpdated($chatroom))->toOthers();

        return $chatroom;
    }
}
