<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Followable;
use DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['profile']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $notify = $this->notify();
        $notif = $this->notif();
        $archive = $this->archive();  

        $user_id = auth()->user()->id;
        $user = User::findorFail($user_id);
        $po = Post::where('user_id', '=', $user->id)->orderBy('created_at','desc')->get();
        $posts = Post::get();

        return view('dashboard')->with('po', $po)->with('messages', $user->messages)->with('archive', $archive)->with('posts', $posts)->with(compact('notif', 'notify'));
    }

    public function profile($id)
    {
        $notify = $this->notify();
        $notif = $this->notif();
        $owner = User::findOrFail($id);
        $p = Post::where('user_id', '=', $owner->id)->orderBy('created_at','desc')->paginate(10);
        return view('user.public')->with('owner', $owner)->with('p', $p)->with(compact('notif', 'notify'));
    }

}
