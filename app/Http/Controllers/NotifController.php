<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Comment;
use App\Followable;

class NotifController extends Controller
{
    public function notif_follow()
    {
        $notif_follow = Followables::where('relation', 'follow')
                                ->where('followables.followable_id', '=', auth()->user()->id)
                                ->get();

        return $notif_follow;
    }

    public function notif_like()
    {
        $notif_like = Followable::join('posts', 'posts.id', '=', 'followables.followable_id')
                            ->where('relation', 'like')
                            ->where('posts.user_id', '=', auth()->user()->id)
                            ->get();
        
        return $notif_like;
    }


}
