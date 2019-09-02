<?php

namespace App\Http\Controllers;

use Validator;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Notifications\UserFollowed;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Post;
use App\Follow;
use App\Followable;
use App\Comment;
use App\Poster;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index($id)
    // {
    //     $user = User::findOrFail($id);
    //     return view('user.profile')->with('user', $user);
    // } ALready set in the dashboardcontroller

    public function show($id)
    {
        $notify = $this->notify();
        $notif = $this->notif();
        $user = User::findOrFail($id);
        $post = Post::where('user_id', '=', '$id');  

        return view('user.show')->with('user', $user)
                                ->with('post', $post)
                                ->with(compact('notif', 'notify'));
    }

    public function edit($id)
    {
        $notify = $this->notify();
        $notif = $this->notif();
        $user = User::findOrFail($id);
        // Check for correct user
        if(auth()->user()->id !== $user->id){
            return redirect('dashboard')->with('error', 'Unauthorized Page');
        };
        return view('user.edit')->with('user', $user)->with(compact('notif', 'notify'));
        
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'motto' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:255',
            'gender' => 'required',
            'status' => 'required',
            'bday' => 'nullable',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'job' => 'nullable|string|max:255',
            'pic' => 'image|nullable|max:599'
        ]);
        if ($validator->fails()) 
        {
            return redirect()->to(route('user.edit', [$id]))
                        ->withErrors($validator)
                        ->withInput();
        }

        // Handle File Upload
        if($request->hasFile('pic')){
            // Get filename with the extension
            $filenameWithExt = $request->file('pic')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('pic')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$user->username.'.'.$extension;
            // Upload Image
            $path = $request->file('pic')->move('public/cover_images', $fileNameToStore);
        }
        
        // Create Post
        $user->name = concat($request->input('fname'), $request->input('lname'));
        $user->motto = $request->input('motto');
        $user->bio = $request->input('bio');
        $user->gender = $request->input('gender');
        $user->status = $request->input('status');
        $user->bday = $request->input('bday');
        $user->address = $request->input('address');
        $user->city = $request->input('city');
        $user->country = $request->input('country');
        $user->job = $request->input('job');
        if($request->hasFile('pic')){
            if($user->profile_image != 'default.jpg'){
                // Delete Image
                Storage::delete('public/cover_images/'.$user->profile_image);  
            } 
            $user->profile_image = $fileNameToStore;  
        }
        $user->save();
        
        $notif =$this->notif();
        $notify = $this->notify();

        return view('user.show')->with('success', 'Profile Updated')->with('user', $user)->with(compact('notif', 'notify'));
    }

    public function follower()
    {
        session(['link' => url()->previous()]);

        $user = User::find(auth()->user()->id);
        $follower = $user->followers()->get();
        $notify = $this->notify();
        $notif = $this->notif();

        return view('user.follower')->with(compact('follower', 'notif', 'notify'));
    }

    public function following()
    {
        session(['link' => url()->previous()]);

        $user = User::find(auth()->user()->id);
        $following = $user->followings()->get();
        $notify = $this->notify();
        $notif = $this->notif();

        return view('user.follower')->with(compact('following', 'notif', 'notify'));
    }

    public function history()
    {
        $notify = $this->notify();
        $notified = $this->notified();
        $notif = $this->notif();
// dd($notified);
        return view('user.history')->with(compact('notif', 'notify', 'notified'));
    }

    public function complete (Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        
        if ($validator->fails()) 
        {
            return redirect()->route('complete', [$id])
                        ->withErrors($validator);
        }

        // Create Post
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Welcome to Artikel!');
    }

    public function mark($id, $pid = null, $cid = null) 
    {
        if(request()->routeIs('like') && !empty($pid) && empty($cid)) {
            $update = Followable::where('notify', auth()->user()->id)
                                    ->where('user_id', $id)
                                    ->where('followable_id', $pid)
                                    ->where('followable_type', 'App\Post')
                                    ->firstorFail();

            $update->notify_mark = 1;
            $update->save();
            
            return redirect()->route('posts.show', [$pid]);
        } else if(request()->routeIs('follow') && empty($pid) && empty($cid)) {
            $update = Followable::where('notify', auth()->user()->id)
                                ->where('user_id', $id)
                                ->where('followable_type', 'App\User')
                                ->firstorFail();

            $update->notify_mark = 1;
            $update->save();
            
            return redirect()->route('profile', [$id]);
        } else if(request()->routeIs('comment') && !empty($pid) && empty($cid)) {
            $update = Comment::where('post_owner', auth()->user()->id)
                                ->where('post_id', $pid)
                                ->where('user_id', $id)
                                ->where('parent_id', null)
                                ->firstorFail();

            $update->mark = 1;
            $update->save();

            return redirect()->to(route('posts.show', [$pid]) . "#comment/.$id.");
        } else if(request()->routeIs('reply') && !empty($pid) && !empty($cid)) {
           $update = Comment::where('user_id', $id)
                                ->where('post_id', $pid)
                                ->where('parent_id', $cid)
                                ->firstorFail();

            $update->mark = 1;
            $update->save();

            return redirect()->to(route('posts.show', [$pid]) . "#reply/$id");
        } else if(request()->routeIs('new_post') && !empty($pid) && empty($cid)) {
            $update = new Poster;
            $update->post_id = $pid;
            $update->post_owner = $id;
            $update->notifiable_id = auth()->user()->id;

            $update->save();dd($update);
            
            return redirect()->route('posts.show', [$pid]);
        }
        
        return redirect('/dashboard')->with('error', 'Unauthorized action');
    }

    /**
     * Show the application of itsolutionstuff.com.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxRequest(Request $request){
        $user = User::find($request->user_id);
        if($done = auth()->user()->toggleFollow($user)){

            $response = array();
            $response[0] = ['s'=>$done];
            $response[1] = ['id'=>$request->user_id];
        }

        return response()->json(['ok'=>$response],200);
    }

    // public function notifications()
    // {
    //     return auth()->user()->unreadNotifications()->limit(5)->get()->toArray();
    // }

    public function ajaxRequestInsert(Request $request) {
        $uid = $request->id;
        $user = auth()->user()->id;
        $follow = Followable::where(['user_id' => $user, 'followable_id' => $uid, 'followable_type' => 'App\User'])
                                ->update(['notify'=>$uid]);
        // dump($follow);
        // return view('user.public');
        return response()->json(['success'],200);
    }
}
