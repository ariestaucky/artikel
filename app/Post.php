<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFollow\Traits\CanBeLiked;
use App\User;
use App\Followable;
use App\Comment;

class Post extends Model
{
    // Table Name
    protected $table = 'posts';
    // Like Dislike from Overtrue
    use CanBeLiked;

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'post')->whereNull('parent_id');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function like(){
        return $this->hasMany('App\Followable', 'followable_id')->where('relation', 'like');
    } 

    public function delete() {
        $this->comments()->delete();
        parent::delete();
    }

    public static function scopeSearch($query, $searchTerm)
    {
        return $query->join('users', 'users.id', '=', 'posts.user_id')
                     ->Where('posts.title', 'like', '%' .$searchTerm. '%')
                     ->orWhere('posts.kategori', 'like', '%' .$searchTerm. '%')
                     ->orWhere('posts.body', 'like', '%' .$searchTerm. '%')
                     ->orWhere('users.country', 'like', '%' .$searchTerm. '%')
                     ->orWhere('users.name', 'like', '%' .$searchTerm. '%')
                     ->select('users.*', 'posts.*', 'posts.created_at as post_created');
    }
}
