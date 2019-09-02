@extends('layouts.app')

@section('content')
<div class="col-sm-2">

</div>
    @isset($follower)
        <div class="col-md-8" >
            <div class="row">
                <h2>Follower</h2>
                <hr>
                <a href="{{route('back')}}"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> back</a>
            </div>      
            <hr>          
            <small>{{Auth::user()->followers()->get()->count()}} Total followers</small>
            <div class="row">
            @if(count($follower) > 0)
            @foreach($follower as $follower)
                <div class="col-sm-4">
                    <div class="panel">
                        <div class="image">
                            <img src="{{asset('/public/cover_images/' . $follower->profile_image)}}" alt="" width="100%" height="100%" style="border-radius: 50%;">
                        </div>
                        <hr>
                        <div class="profile-userbuttons">
                            <button type="button" id="buton" class="btn {{ auth()->user()->isFollowing($follower) ? 'btn-alert' : 'btn-success' }} btn-sm action-follow" data-id="{{ $follower->id }}"><strong>{{ !auth()->user()->isFollowing($follower) ? 'Follow' : 'Followed' }}</strong></button>

                            <a href="{{route('create', [$name = $follower->username])}}" style="text-decoration:none; color:white;"><button type="button" class="btn btn-danger btn-sm">Message</button></a>
                        </div>
                        <p style="width:100%; margin-bottom: 1px !important; text-align:center"><a href="/profile/{{$follower->id}}" title="Profile" >{{$follower->name}}</a></p>
                    </div>
                </div>      
            @endforeach   
            @else
                <p style='text-align:center'>You don't have follower!</p>  
            @endif   
            </div>
        </div>
    @endisset

    @isset($following)
        <div class="col-md-8" >
            <div class="row">
                <h2>Following</h2>
                <hr>
                <a href="{{route('back')}}"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> back</a>
            </div>
            <hr>
            <small>{{Auth::user()->followings()->get()->count()}} Total following</small>
            <div class="row">
            @if(count($following) > 0)
            @foreach($following as $following)
                <div class="col-sm-4">
                    <div class="panel">
                        <div class="image">
                            <img src="{{asset('/public/cover_images/' . $following->profile_image)}}" alt="" width="100%" height="100%" style="border-radius: 50%;">
                        </div>
                        <hr>
                        <div class="profile-userbuttons">
                            <button type="button" id="buton" class="btn {{ auth()->user()->isFollowing($following) ? 'btn-alert' : 'btn-success' }} btn-sm action-follow" data-id="{{ $following->id }}"><strong>{{ !auth()->user()->isFollowing($following) ? 'Follow' : 'Followed' }}</strong></button>

                            <a href="{{route('create', [$name = $following->username])}}" style="text-decoration:none; color:white;"><button type="button" class="btn btn-danger btn-sm">Message</button></a>
                        </div>
                        <p style="width:100%; margin-bottom: 1px !important; text-align:center"><a href="/profile/{{$following->id}}" title="Profile" >{{$following->name}}</a></p>
                    </div>
                </div>        
            @endforeach   
            @else
                <p style='text-align:center'>You are not following anyone!</p>  
            @endif          
            </div>
        </div>
    @endisset
<div class="col-sm-2">

</div>
@endsection