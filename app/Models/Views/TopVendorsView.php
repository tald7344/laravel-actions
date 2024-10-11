<?php

namespace App\Models\Views;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Message;
use App\Models\Conversation;
use App\Models\FriendRequest;
use App\Models\ProductsOrdersView;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TopVendorsView extends Model
{
    use HasFactory;
    protected $table = 'top_vendors_view';

}
