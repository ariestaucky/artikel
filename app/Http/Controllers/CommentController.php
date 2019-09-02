<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;
use App\Follow;
use Session;
use URL;

class CommentController extends Controller
{
    public function store(Request $request)
    {    
        $this->validate($request, [
            'body'    => 'required',
            'user_id'   => 'required'
        ]);


        $comment = new Comment;
        $comment->body = $request->input('body');
        $comment->user_id = $request->input('user_id');
        $comment->post_owner = $request->input('post_owner');

        $check = Follow::firstorCreate(['post_id' => $request->input('post_id'), 'user_id' => auth()->user()->id]);

        $post = Post::find($request->input('post_id'));
        $post->comments()->save($comment);

        return back()->with('success', 'Comment added!');
    }
    public function replyStore(Request $request)
    {
        $this->validate($request, [
            'body'    => 'required',
            'user_id'   => 'required'
        ]);

        $check = Follow::firstorCreate(['comment_id' => $request->input('comment_id'), 'user_id' => auth()->user()->id]);

        $reply = new Comment();
        $reply->body = $request->get('body');
        $reply->user()->associate($request->user());
        $reply->parent_id = $request->get('comment_id');
        $reply->post_owner = $request->input('post_owner');
        $post = Post::find($request->get('post_id'));
        $post->comments()->save($reply);

        return back()->with('success', 'Reply added!');
    }
}
