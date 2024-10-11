<?php

namespace App\Models\Views;

use App\Models\Photo;
use App\Models\Video;
use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class MessageView extends Model
{
    use SoftDeletes;
    use HasFactory;
    
    protected $casts = [
        'id' => 'integer',
        'conversation_id' => 'integer',
        'sender' => 'integer',
        'receiver' => 'integer',
    ];

    protected $table = 'messages_view';

    public function photos()
    {
        return $this->hasMany(Photo::class, 'type_id', 'id')->where('type', Message::class)->get();
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'type_id', 'id')->where('type', Message::class)->get();
    }

}
