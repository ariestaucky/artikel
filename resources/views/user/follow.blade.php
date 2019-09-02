@extends('layouts.app')

@section('content')
<div class="col-md-8 blog-main mx-auto">
    <h2>{{$owner->fname}} {{$owner->lname}}'s Followers</h2>   
    <div class="col-md-4">        
        <p>{{$owner->followers()->get()->count()}} Total followers</p>
        <hr>
    </div>   

    <div class="row">
    @if(count($follower) > 0)
    @foreach($follower as $follower)
        <div class="col-sm-4">
            <div class="panel">
                <div class="image">
                    <img src="{{asset('/public/cover_images/' . $follower->profile_image)}}" alt="" width="100%" height="100%" style="border-radius: 50%;">
                </div>
                <hr>
                @if(Auth()->user())
                <div class="profile-userbuttons">
                    <button type="button" id="buton" class="btn {{ auth()->user()->isFollowing($follower) ? 'btn-alert' : 'btn-success' }} btn-sm action-follow" data-id="{{ $owner->id }}"><strong>{{ !auth()->user()->isFollowing($follower) ? 'Follow' : 'Followed' }}</strong></button>

                    <a href="{{route('create', [$name = $follower->username])}}" style="text-decoration:none; color:white;"><button type="button" class="btn btn-danger btn-sm">Message</button></a>
				</div>
                <p style="width:100%; margin-bottom: 1px !important; text-align:center"><a href="/profile/{{$follower->id}}" title="Profile" >{{$follower->name}}</a></p>
                @else
                <p style="width:100%; margin-bottom: 1px !important; text-align:center"><a href="/profile/{{$follower->id}}" title="Profile" >{{$follower->name}}</a></p>
                @endif
            </div>
        </div>      
    @endforeach   
    @else
        <p style='text-align:center'>You don't have follower!</p>  
    @endif   
    </div>
</div>
@endsection