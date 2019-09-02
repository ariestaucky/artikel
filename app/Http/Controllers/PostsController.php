<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\Comment;
use App\Followable;
use Session;
use URL;

class PostsController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
   public function __construct()
   {
       $this->middleware('auth', ['except' => ['show']]);
   }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notify = $this->notify();
        $notif = $this->notif();
        $posts = Post::where('user_id', '=', auth()->user()->id)->orderBy('created_at','desc')->paginate(10);
        return view('posts.index')->with('posts', $posts)->with(compact('notif', 'notify'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $notify = $this->notify();
        $notif =$this->notif();
        return view('posts.create')->with(compact('notif', 'notify'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999',
            'kategori' => 'required'
        ]);
        // Handle File Upload
        if($request->hasFile('cover_image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('cover_image')->move('public/cover_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }
        // Create Post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->kategori = $request->input('kategori');
        $post->save();
        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        session(['link' => url()->previous()]);

        $notif = $this->notif();
        $notify = $this->notify();
        $archive = $this->notif(); 
        $post = Post::findOrFail($id);$com = $post->comments;

        return view('posts.show')->with('post', $post)->with('archive', $archive)->with(compact('notif', 'notify'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notify = $this->notify();
        $notif = $this->notif();
        $post = Post::findOrFail($id);
        // Check for correct user
        if(auth()->user()->id !==$post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }
        return view('posts.edit')->with('post', $post)->with(compact('notif', 'notify'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'kategori' => 'required'
        ]);
         // Handle File Upload
        if($request->hasFile('cover_image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('cover_image')->move('public/cover_images', $fileNameToStore);
        }
        // Create Post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->kategori = $request->input('kategori');
        if($request->hasFile('cover_image')){
            if($post->cover_image != 'noimage.jpg'){
                // Delete Image
                Storage::delete('public/cover_images/'.$post->cover_image);   
            }  
            $post->cover_image = $fileNameToStore; 
        }
        $post->save();
        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findorFail($id);
        // Check for correct user
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }
        if($post->cover_image != 'noimage.jpg'){
            // Delete Image
            Storage::delete('public/cover_images/'.$post->cover_image);
        }
        if($post->comments()->delete()){
            Comment::where('commentable_id',$id)->delete();
        }
        $post->delete();
        return redirect('/posts')->with('success', 'Post Removed');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxRequestLike(Request $request){

        $post = Post::find($request->id);
        if($done = auth()->user()->toggleLike($post)){

            $response = array();
            $response[0] = ['s'=>$done];
            $response[1] = ['id'=>$request->id];
        }
        
        return response()->json(['sukses'=>$response],200);
    }

    public function ajaxRequestIns(Request $request){

        $pos = $request->id;
        $post = Post::find($request->id);
        $post_owner = $post->user->id;
        $user = auth()->user()->id;
        $follow = Followable::where(['user_id' => $user, 'followable_id' => $pos, 'followable_type' => 'App\Post'])
                                ->update(['notify'=>$post_owner]);

        // return view('posts.show');
        return response()->json(['success'],200);
    }
}
