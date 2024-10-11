<?php

use App\Models\Conversation;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Users private channels
Broadcast::channel('conv-{conversation_id}', function ($user, $conversation_id) {
    $conversation = Conversation::find($conversation_id);
    return ($user->id==$conversation->first_user || $user->id==$conversation->second_user);
});

Broadcast::channel('notification-channel', function ($user) {
    return $user->id;
});

Broadcast::channel('conversation-channel', function ($user) {
    return $user->id;
});