<?php

namespace App\Models;

use App\Models\User;
use App\Models\Conversation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;
    protected $appends = array('sender_name', 'sender_username');
    protected $fillable = [
        'sender',
        'receiver',
        'message',
        '.....'
    ];
    public function getSenderNameAttribute()
    {
        return $this->userSender->name;
    }
    public function getSenderUsernameAttribute()
    {
        return $this->userSender->username;
    }
    public function userReceiver()
    {
        return $this->belongsTo(User::class,'receiver');
    }
    public function userSender()
    {
        return $this->belongsTo(User::class,'sender');
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id', 'id');
    }
    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'type', 'type');
    }
    public function videos(): MorphMany
    {
        return $this->morphMany(Video::class, 'type', 'type');
    }
}
