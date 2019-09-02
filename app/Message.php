<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Post;
use App\Followable;
use App\Comment;

class Message extends Model
{
    protected $fillable = ['message', 'subject', 'receiver', 'sender_id', 'receiver_mark', 'receiver_delete', 'sender_delete'];
    protected $dates = [
        'receiver_delete', 'sender_delete'
    ];
    public function sender(){
        return $this->belongsTo('App\User', 'sender_id');
    }
    public function receiver(){
        return $this->belongsTo(User::class, 'receiver');
    }
    public static function scopeNotif($query, $auth_id)
    {
        return $query->where('messages.receiver', $auth_id)
                    ->whereNull('messages.receiver_delete')
                    ->where('messages.receiver_mark', 0)
                    ->join('users', 'users.id', '=', 'messages.sender_id')
                    ->select('users.*', 'messages.*', 'messages.created_at as message_created', 'users.id as user_id');
    }
}
