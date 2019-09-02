@extends('layouts.app')

@section('content')
<div class="col-sm-2">

</div>

<div class="col-md-8" >
    <div class="row">
        <h2>ACTIVITY</h2>
        <hr>
        <a href="{{route('back')}}"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> back</a>
    </div>      
    <hr>          
    <div class="row">
    @if(count($notified) > 0)
        <div class="col">
            <ul class="list-group-striped">
                @foreach($notified as $notification)
                    <li class="dropdown-header" style="padding: 0.5rem 0.5rem !important; word-break: break-word; width:100%; overflow:hidden; text-overflow:ellipsis;">
                        @if(empty($notification->relation))
                            @if(empty($notification->reply))
                            <a href="{{route('comment', [$notification->id, $notification->pid])}}" style="padding: 8px 12px !important"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; {{\Carbon\Carbon::parse($notification->tgl)->diffforHumans()}} : <b style="color:blue">{{$notification->name}}</b> comment on post <b style="color:blue">"{{$notification->post}}"</b>!</a>
                            @else
                            <a href="{{route('reply', [$notification->id, $notification->pid, $notification->reply])}}" style="padding: 8px 12px !important"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; {{\Carbon\Carbon::parse($notification->tgl)->diffforHumans()}} : <b style="color:blue">{{$notification->name}}</b> reply on your comment on post <b style="color:blue">"{{$notification->post}}"</b>!</a>
                            @endif
                        @elseif($notification->relation == 'like')
                        <a href="/posts/{{$notification->pid}}" style="padding: 8px 12px !important"><i class="fa fa-thumbs-up" aria-hidden="true"></i>&nbsp; {{\Carbon\Carbon::parse($notification->tgl)->diffforHumans()}} : <b style="color:blue">{{$notification->name}}</b> {{$notification->relation}} your post <b style="color:blue">"{{$notification->post}}"</b>!</a>
                        @else
                            @if(empty($notification->pid))
                            <a href="{{route('follow', [$notification->id])}}" style="padding: 8px 12px !important"><i class="fa fa-users" aria-hidden="true"></i>&nbsp; {{\Carbon\Carbon::parse($notification->tgl)->diffforHumans()}} : <b style="color:blue">{{$notification->name}}</b> {{$notification->relation}} you!</a>
                            @else
                            <a href="{{route('new_post', [$notification->id, $notification->pid])}}" style="padding: 8px 12px !important"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; {{\Carbon\Carbon::parse($notification->tgl)->diffforHumans()}} : <b style="color:blue">{{$notification->name}}</b> published NEW artikel <b style="color:blue">"{{$notification->post}}"</b>!</a>
                            @endif
                        @endif
                    </li>  
                @endforeach   
            </ul>

        </div> 
    @else
        <p style='text-align:center'>You aren't doing anything yet!</p>  
    @endif   
    </div>
</div>

<div class="col-sm-2">

</div>
@endsection