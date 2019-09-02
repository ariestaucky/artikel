@extends('layouts.app')

@section('content')
<div class="col-sm-2">

</div>
    @isset($msg_in)
        @foreach($msg_in as $inc)
            <div class="col-md-8" >
                <div class="row">
                    <h2>Message</h2>
                    <hr>
                    <a href="{{route('back')}}"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> back</a>
                </div>
                <div class="row">
                    <table class="msg" style="width:100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="width:100%"><p>From : <a href="/profile/{{$inc->user_id}}">{{$inc->name}}</a></p></td>
                        </tr>
                        <tr>
                            <td style="width:100%"><p>Subject : {{$inc->subject}}</p><hr></td>
                        </tr>
                        <tr>
                            <td style="width:100%"><p>{{$inc->message}}</p></td>
                        </tr>
                        <tr>
                            <td style="padding-right:15px">
                                <a href="{{route('create', [$name = $inc->username])}}">
                                    <span class="pull-right">
                                        <button class="btn btn-success btn-sm">Reply</button>
                                    </span>
                                </a>
                            </td>
                        </tr>
                    </table>                    
                </div>
            </div>
        @endforeach
    @endisset

    @isset($msg_out)
        @foreach($msg_out as $sent)
        <div class="col-md-8" >
                <div class="row">
                    <h2>Message</h2>
                    <hr>
                    <a href="{{route('back')}}"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> back</a>
                </div>
                <div class="row">
                    <table class="msg" style="width:100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="width:100%"><p>To : <a href="/profile/{{$sent->user_id}}">{{$sent->name}}</a></p></td>
                        </tr>
                        <tr>
                            <td style="width:100%"><p>Subject : {{$sent->subject}}</p><hr></td>
                        </tr>
                        <tr>
                            <td style="width:100%"><p>{{$sent->message}}</p></td>
                        </tr>
                    </table>                    
                </div>
            </div>
        @endforeach
    @endisset
<div class="col-sm-2">

</div>
@endsection