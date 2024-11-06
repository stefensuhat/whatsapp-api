<?php

namespace App\Actions;

use App\Events\MessageSent;
use App\Models\Message;

class MessageAction
{
    public function sendMessage($chatroomId, $userId, array $data): Message
    {
        $message = new Message([
            'content' => $data['content'] ?? null,
            'user_id' => $userId,
            'chat_room_id' => $chatroomId
        ]);

        if (isset($data['attachment'])) {
            $path = $this->storeAttachment($data['attachment']);
            $message->attachment_path = $path;
            $message->attachment_type = $data['attachment']->getMimeType();
        }

        $message->save();

        MessageSent::broadcast($message);

        return $message;
    }

    private function storeAttachment($file)
    {
        $type = explode('/', $file->getMimeType())[0];
        $path = $file->store('root', 'public');

        return $path;
    }
}
