@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row profile">
		<div class="col-md-3">
			<div class="profile-sidebar">
				<!-- SIDEBAR USERPIC -->
				<div class="profile-userpic">
					<img style="width:50%; height:50%; display:block; margin-left:auto; margin-right: auto;" src="{{asset('/public/cover_images/' . $owner->profile_image)}}" class="img-responsive" alt="">
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						{{$owner->name}}
					</div>
					<div class="profile-usertitle-job">
						{{$owner->job}}
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
                @guest
                <div style="text-align: center">
                    <p><a href="{{route('login')}}">Login</a> to follow this author.</p>
                </div>
                @else
				<!-- SIDEBAR BUTTONS -->
				<div class="profile-userbuttons">
                    <button type="button" id="buton" class="btn {{ auth()->user()->isFollowing($owner) ? 'btn-alert' : 'btn-success' }} btn-sm action-follow" data-id="{{ $owner->id }}"><strong>{{ !auth()->user()->isFollowing($owner) ? 'Follow' : 'Followed' }}</strong></button>
                    <a href="{{route('create', [$name = $owner->username])}}" style="text-decoration:none; color:white;"><button type="button" class="btn btn-danger btn-sm">Message</button></a>
				</div>
				<!-- END SIDEBAR BUTTONS -->
                @endif
				<!-- SIDEBAR MENU -->
				<div class="profile-usermenu">
                    <div class="profile-work">
                        <ul class="list-group">
                            <li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i></li>
                            <li class="list-group-item text-right"><span class="pull-left"><strong>Posts</strong></span>{{count($p)}}</li>
                            <li class="list-group-item text-right"><span class="pull-left">Following :</span><strong>{{ $owner->followings()->get()->count() }}</strong></li>
                            <li class="list-group-item text-right"><span class="pull-left">Followers :</span><strong class="tl-follower">{{ $owner->followers()->get()->count() }}</strong></li>
                        </ul> 
                    </div>
				</div>
				<!-- END MENU -->
			</div>
		</div>
		<div class="col-md-9">
            <div class="profile-content">
                <div class="col-md-6">
                    <div class="profile-head">
                                <h5>
                                    <b>{{ strtoupper($owner->name) }}</b>
                                </h5>
                                <h6>
                                    @<a href="{{route('create', [$name = $owner->username])}}">{{ $owner->username }}</a> 
                                </h6>
                                @guest
                                @else
                                <h6>
                                    {{ $owner->email }}
                                </h6>
                                @endif
                                <p class="proile-rating"><q>{{ $owner->motto }}</q> 
                                -<span class="author">{{ $owner->name }}</span></p>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Personal</a>
                            </li>
                            <li>
                                <a href="#post" class="nav-link" id="post-tab" data-toggle="tab" role="tab" aria-controls="post" aria-selected="false">
                                <i class="glyphicon glyphicon-user"></i>
                                Post </a>
                            </li>
                            <li>
                                <a href="#overview" class="nav-link" id="overview-tab" data-toggle="tab" role="tab" aria-controls="overview" aria-selected="false">
                                <i class="glyphicon glyphicon-ok"></i>
                                Overview </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-8" style="max-width: 100%;">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Status</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ $owner->status }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Gender</label>
                                    </div>
                                    <div class="col-md-6">
                                        <select name="formGender" disabled="disabled">
                                            <option value="">Select...</option>
                                            <option value="l" name="gender" {{$owner->gender == 'l' ? 'selected' : ''}}>Male</option>
                                            <option value="f" name="gender" {{$owner->gender == 'f' ? 'selected' : ''}}>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Birthtday</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ $owner->bday }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Live in</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ $owner->address }},</p>
                                        <p>{{ $owner->city }} City, {{ $owner->country }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Join</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ $owner->created_at }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Last login</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ $owner->updated_at }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>My Bio</label><br/>
                                        <p>{{ $owner->bio }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="post" role="tabpanel" aria-labelledby="post-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>{{$owner->name}}'s post</label><br/>
                                    </div>
                                </div>  
                                <div class="row">                                      
                                    @if(count($p) > 0)
                                        @foreach($p as $post)
                                            <div class="col-md-4 col-sm-4">
                                                <img style="width:100%" src="/storage/cover_images/{{$post->cover_image}}">
                                            </div>
                                            <div class="col-md-8 col-sm-8">
                                                <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                                                <small>Written on {{$post->created_at}} by <b style="color: #3490dc;">{{$post->user->name}}</b></small>
                                            </div>
                                        @endforeach
                                        {{$p->links()}}
                                    @else
                                        <p>No posts found</p>
                                    @endif
                                </div>
                            </div>

                            <div class="tab-pane fade" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                                <div class="row">
                                @guest
                                    <div class="col-md-12">
                                        <p><a href="{{route('login')}}">Login</a> to comment about this author</p>
                                    </div>
                                @else
                                    <div class="col-md-12">
                                    
                                    </div>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
@endsection