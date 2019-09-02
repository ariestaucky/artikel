<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
use Carbon\Carbon;
use DB;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sent()
    {
        $auth_id = Auth()->user()->id;
        $sent = Message::where('messages.sender_id', $auth_id)
                    ->whereNull('messages.sender_delete')
                    ->join('users', 'users.id', '=', 'messages.receiver')
                    ->select('users.*', 'messages.*', 'messages.created_at as message_created', 'users.id as user_id')
                    ->get();

        return $sent;
    }

    public function got()
    {
        $auth_id = Auth()->user()->id;
        $got = Message::where('messages.receiver', $auth_id)
                    ->whereNull('messages.receiver_delete')
                    ->join('users', 'users.id', '=', 'messages.sender_id')
                    ->select('users.*', 'messages.*', 'messages.created_at as message_created', 'users.id as user_id')
                    ->get();
        return $got;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $msg_sent = $this->sent();
        $msg_got = $this->got();
        $notif = $this->notif();
        $notify = $this->notify();

        return view('contact', compact('msg_sent', 'msg_got', 'notif', 'notify'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($name)
    {
        // $users = User::select('id', DB::raw("concat(fname, ' ', lname) as full_name"))                      ->where('id', '!=', Auth()->user()->id)->pluck('full_name', 'id');
        $msg_sent = $this->sent();
        $msg_got = $this->got();
        $notif = $this->notif();
        $notify = $this->notify();

        return view('contact', compact('msg_sent', 'msg_got', 'name', 'notif', 'notify'));
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
            'receiver' => 'required',
            'subject' => 'required|string',
            'message' => 'required|string'
        ]);
        
        if (User::where('username', '=', $request->input('receiver'))->count() > 0) {
            $receiver = User::where('username', '=', $request->input('receiver'))->first();
            $receiver_id = $receiver->id; 
        
            if($receiver_id != auth()->user()->id) {
                Auth()->user()->sent()->create([
                    'receiver' => $receiver_id,
                    'subject' => $request->input('subject'),
                    'message' => $request->input('message')
                ]);
            } else {
                return redirect()->back()->with('error', "You can't send message to yourself!")
                                    ->withInput($request->except('receiver'));
            }            
        } else {
            return redirect()->back()->with('error', "Username doesn't exist!")
                                    ->withInput($request->except('receiver'));
        }


        // if($request->has)
        // $message = new Message;
        // $message->sender_id = auth()->user()->id;
        // $message->receiver_id = 
        // $message->receiver_name = $request->input('receiver');
        // $message->subject = ;
        // $message->message = ;

        // $message->save();

        return redirect('/dashboard')->with('success', 'Message sent');
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

        $msg = Message::find($id);
        if($msg->sender_id == Auth()->user()->id) {
            $msg_out = Message::where('messages.id', $id)->join('users', 'users.id', '=', 'messages.receiver')->select('users.*', 'messages.*', 'messages.created_at as message_created', 'users.id as user_id')->get();

            $notify = $this->notify();
            $notif = $this->notif();

            return view('partials.message')->with(compact('msg_out', 'notif', 'notify'));
        } else if($msg->receiver == Auth()->user()->id) {
            $msg_in = Message::where('messages.id', $id)->join('users', 'users.id', '=', 'messages.sender_id')->select('users.*', 'messages.*', 'messages.created_at as message_created', 'users.id as user_id')->get();

            $msg->receiver_mark = 1;
            $msg->save();

            $notify = $this->notify();
            $notif = $this->notif();

            return view('partials.message')->with(compact('msg_in', 'notif', 'notify'));
        }    
        return redirect('/dashboard')->with('error', 'Unauthorized action');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $message = Message::find($id);
        if($message->receiver == auth()->user()->id) {
            $message->receiver_mark = 1;
            $message->save();
        }
        
        return redirect('/contact')->with('success', 'Message marked as read');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = Message::find($id);
        if($message->sender_id == auth()->user()->id) {
            $message->sender_delete = \Carbon\Carbon::now();
            $message->save();
        } elseif($message->receiver == auth()->user()->id) {
            $message->receiver_delete = \Carbon\Carbon::now();
            $message->save();
        } elseif((!empty($message->sender_deleete)) && (!empty($message->receiver_delete))) {
            $message->delete();
        }

        return redirect('/contact')->with('success', 'Message deleted');
    }
}
