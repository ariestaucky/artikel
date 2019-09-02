<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Overtrue\LaravelFollow\Traits\CanFollow;
use Overtrue\LaravelFollow\Traits\CanBeFollowed;
use Overtrue\LaravelFollow\Traits\CanLike;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use App\Message;
use App\Post;
use App\Followable;
use App\Comment;

class User extends Authenticatable
{
    use Notifiable, CanFollow, CanBeFollowed, CanLike;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'motto', 'bio', 'gender', 'status', 'bday', 'address', 'city', 'country', 'profile_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts(){
        return $this->hasMany('App\Post');
    }

    public function sent(){
        return $this->hasMany('App\Message', 'sender_id');
    }    

    public function received(){
        return $this->hasMany(Message::class, 'receiver');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    } 

    public function follows(){
        return $this->hasMany('App\Followable', 'user_id')->where('relation', 'follow');
    } 

    public function notify(){
        return $this->morphMany('App\Followable', 'notify');
    } 

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

}
