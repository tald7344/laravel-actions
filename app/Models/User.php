<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'id' => 'integer',
    ];
   
    public function badge()
    {
        return $this->belongsTo(Badge::class, 'badge_id', 'id');
    }
    
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'user_id', 'id');
    }

    // The users that the user follows
    public function following()
    {
        return $this->belongsToMany(User::class, 'user_followers', 'follower_id', 'user_id');
    }

    public function friendsCount()
    {
        $friendAsUser = $this->hasMany(UserFriend::class, 'user_id', 'id')->count();
        $friendAsFriend = $this->hasMany(UserFriend::class, 'friend_id', 'id')->count();
        return $friendAsUser + $friendAsFriend;
    }
}
