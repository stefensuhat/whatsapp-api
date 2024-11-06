<?php

namespace App\Actions;

use App\Models\ChatRoom;
use App\Models\ChatRoomUser;

class ChatRoomAction
{
    public function create(array $data)
    {
        $chatroom = Chatroom::create($data);

        return $chatroom;
    }

    public function join(Chatroom $chatroom, $userId): ?ChatRoom
    {
        if ($chatroom->users()->where('user_id', $userId)->exists()) {
            return $chatroom;
        }

        if ($chatroom->users()->count() >= $chatroom->max_members) {
            return null;
        }

        if ($checkExisting = ChatRoomUser::where('user_id', $userId)->first()) {
            $checkExisting->users()->detach($userId);
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
