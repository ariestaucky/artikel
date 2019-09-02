@extends('layouts.app')

@section('content')
    <div class="container emp-profile">
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src="{{asset('/public/cover_images/' . Auth::user()->profile_image)}}" alt=""/>
                        <!-- <div class="file btn btn-lg btn-primary">
                            Change Photo
                            <input type="file" name="file"/>
                        </div> -->
                    </div>
                    <div class="col-md-4" style="max-width: 100%; margin-top: 25px;">
                        <div class="profile-work">
                            <ul class="list-group">
                                <li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i></li>
                                <!-- <li class="list-group-item text-right"><span class="pull-left"><strong>Posts</strong></span> </li> -->
                                <li class="list-group-item text-right"><span class="pull-left"><strong>Following</strong></span> {{ $user->followings()->get()->count() }}</li>
                                <li class="list-group-item text-right"><span class="pull-left"><strong>Followers</strong></span> {{ $user->followers()->get()->count() }}</li>
                            </ul> 
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-head">
                                <h5>
                                    <b>{{ strtoupper($user->name) }}</b>
                                </h5>
                                <h6>
                                    @<a href="#">{{ $user->username }}</a> 
                                </h6>
                                <h6>
                                    {{ $user->email }}
                                </h6>
                                <p class="proile-rating"><q>{{ $user->motto }}</q> 
                                -<span class="author">{{ $user->username }}</span></p>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Basic</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Personal</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-8" style="max-width: 100%;">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Username</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ $user->username }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Name</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ $user->name }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Email</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ $user->email }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Profession</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ $user->job }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Status</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ $user->status }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Gender</label>
                                    </div>
                                    <div class="col-md-6">
                                        <select name="formGender" disabled="disabled">
                                            <option value="">Select...</option>
                                            <option value="l" name="gender" {{$user->gender == 'l' ? 'selected' : ''}}>Male</option>
                                            <option value="f" name="gender" {{$user->gender == 'f' ? 'selected' : ''}}>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Birthtday</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ $user->bday }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Live in</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ $user->address }},</p>
                                        <p>{{ $user->city }} City, {{ $user->country }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Join</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ $user->created_at }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Last login</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ $user->updated_at }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>My Bio</label><br/>
                                        <p>{{ $user->bio }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <a href="{{route('user.edit', $user->id)}}" class="profile-edit"><input class="profile-edit-btn" name="btnAddMore" value="Edit Profile"/></a>
                </div>
            </div>
        </form>           
    </div>
@endsection