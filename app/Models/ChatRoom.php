<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasUlids;

    protected $fillable = ['name', 'description', 'max_members'];

    public function messages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_room_users')
            ->withTimestamps()
            ->withPivot('last_read_at');
    }

}
