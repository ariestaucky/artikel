<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Overtrue\LaravelFollow\FollowRelation;
use App\Post;
use App\User;
use App\Followable;
use App\Contact;
use Session;
use Redirect;
use URL;

class PagesController extends Controller
{

    public function home()
    {
        $notify = $this->notify();
        $notif = $this->notif();
        $popular = FollowRelation::popular('user')->limit(1)->get();
        $pos = Followable::popular('post')->limit(3)->get();
        $popu = DB::select("select users.name, users.profile_image, users.id, users.job, users.bio, count(*) as post from posts join users on users.id = posts.user_id GROUP BY name ORDER BY post DESC limit 1");
        $count = 0;

        return view('home')->with(compact('pos'))
                            ->with(compact('popular'))
                            ->with(compact('count', 'notif', 'notify', 'popu'));
    }

    public function about()
    {
        $notify = $this->notify();
        $notif = $this->notif();

        return view('about')->with(compact('notif', 'notify'));;
    }

    public function back()
    {
        $last_page = url()->previous();
        if(Session()->has('link')){
            if(Session('link') != $last_page){
                session('link');
            } else {
                session(['link' => $last_page]);
            }
        }
        if(session('link')==url()->previous()){
            return redirect('blog');
        }
        return redirect(session('link'));
    }

    public function blog()
    {
        $notify = $this->notify();
        $notif = $this->notif();
        $archives = $this->archive();
        $posts = Post::orderBy('created_at','desc')->paginate(10);

        return view('blog')->with('posts', $posts)->with(array('archive'=>$archives))->with(compact('notif', 'notify'));
    }

    public function contact()
    {
        $notify = $this->notify();
        $notif = $this->notif();
        return view('contact', compact('notif', 'notify'));
    }

    public function view(Request $request)
    {  
        $archives = $this->archive();
        $notify = $this->notify();
        $notif = $this->notif();

        $month = $request->month;
        $year = $request->year;
        
        $articles = Post::latest();
        $articles->whereMonth('created_at', Carbon::parse($month)->month);
        $articles->whereYear('created_at', $year);
        
        $data = $articles->paginate(10);
        $posts = Post::orderBy('created_at','desc')->paginate(10);
        return view('posts.view')->with('data',$data)
                                ->with('posts', $posts)
                                ->with(array('archive'=>$archives))
                                ->with('month', $month)
                                ->with('year', $year)
                                ->with(compact('notif', 'notify'));
    }

    public function catagory(Request $request)
    {
        $archives = $this->archive();
        $notify = $this->notify();
        $notif = $this->notif();

        $cat = $request->cat;

        $pos = Post::where('kategori', '=', $cat)->orderBy('created_at','desc')->paginate(10);
        $posts = Post::all();
        return view('posts.category')->with('pos', $pos)->with(array('archive'=>$archives))->with('cat', $cat)->with('posts', $posts)->with(compact('notif', 'notify'));
    }

    public function search(Request $request) 
    {   
        $archives = $this->archive();
        $notify = $this->notify();
        $notif = $this->notif();
        
        $searchTerm = $request->input('search');
        $posts = Post::search($searchTerm)->orderBy('posts.created_at','desc')->paginate(10);
        return view('search', compact('posts', 'searchTerm', 'notif', 'notify'))
                    ->with(array('archive'=>$archives));
    }

    public function ToS()
    {
        $notify = $this->notify();
        $notif = $this->notif();

        return view('inc.ToS', compact('notif', 'notify'));
    }

    public function policies()
    {
        $notify = $this->notify();
        $notif = $this->notif();

        return view('inc.Privacy', compact('notif', 'notify'));
    }

    public function contact_us()
    {
        $notify = $this->notify();
        $notif = $this->notif();

        return view('contact_us', compact('notif', 'notify'));
    }

    public function send_us(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'subject' => 'required|string',
            'body' => 'required|string'
        ]);
        
        // Create Message
        $msg = new Contact;
        $msg->subject = $request->input('subject');
        $msg->body = $request->input('body');
        $msg->email = $request->input('email');
        if(Auth()->check()) {
            $msg->user_id = auth()->user()->id;
        }

        $msg->save();

        return redirect('contact-us')->with('success', 'Thank you! Message has been sent');
    }

    public function social()
    {
        return view('auth.social');
    }

    public function open(Request $request, $id)
    {  
        $notify = $this->notify();
        $notif = $this->notif();
        
        $owner = User::findOrFail($id);
        $p = Post::where('user_id', '=', $owner->id)->orderBy('created_at','desc')->paginate(10);

        return view('posts.public')->with('data',$p)
                                ->with(compact('notif', 'notify', 'owner'));
    }

    public function follower(Request $request, $id)
    {  
        $notify = $this->notify();
        $notif = $this->notif();
        
        $owner = User::findOrFail($id);
        $follower = $owner->followers()->get();

        return view('user.follow')->with('follower',$follower)
                                ->with(compact('notif', 'notify', 'owner'));
    }

}
