@extends('layouts.app')

@section('content')
    <div class="container emp-profile">
        <form method="post" action="{{route('user.update', $user->id)}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src="{{asset('/public/cover_images/' . Auth::user()->profile_image)}}" alt="profile_image"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-head">
                                <h5>
                                    {{ strtoupper($user->name) }}
                                </h5>
                                <h6>
                                    {{ $user->email }}
                                </h6>
                                <p class="proile-rating"><q>{{ $user->motto }}</q> -<span class="author">{{ $user->username }}</span></p>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Basic</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Personal</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    {{Form::hidden('_method','PUT')}}
                    {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-work">
                        <div id="image-preview">
                            <label for="image-upload" id="image-label">Change avatar</label>
                            <input type="file" name="pic" id="image-upload" />
                        </div>
                        <small>Max 500kb, jpg, jpeg and png only</small>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <table class="table" >
                                <tr>
                                    <td>First Name</td>
                                    <td>:</td>
                                    <td><input type="text" name="fname" value="{{ old('fname', $user->fname) }}" /></td>
                                </tr>
                                <tr>
                                    <td>Last Name </td>
                                    <td>:</td>
                                    <td><input type="text" name="lname" value="{{  old('lname', $user->lname) }}" /></td>
                                </tr>	
                                <tr>
                                    <td>Username</td>
                                    <td>:</td>
                                    <td><input type="text" name="username"  disabled="disabled" value="{{  old('username', $user->username) }}" /></td>
                                </tr>
                                <tr>
                                    <td>Email </td>
                                    <td>:</td>
                                    <td><input type="text" name="email"  disabled="disabled" value="{{  old('email', $user->email) }}" /></td>
                                </tr>
                                <tr>
                                    <td>Password </td>
                                    <td>:</td>
                                    <td><button><a href="#">Change password</a></button></td>
                                </tr>
                            </table>	
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">    
                            <table class="table" >
                                <tr>
                                    <td>Short bio</td>
                                    <td>:</td>
                                    <td><textarea rows="10" cols="50" name="bio" placeholder="Who are you?">{{  old('bio', $user->bio) }}</textarea></td>
                                </tr>
                                <tr>
                                    <td>Birthday </td>
                                    <td>:</td>
                                    <td><input type="date" min="1945-01-01" name="bday" value="{{  old('bday', $user->bday) }}"></td>
                                </tr>				    
                                <tr>
                                    <td>Gender </td>
                                    <td>:</td>
                                    <td>
                                        <select name="gender">
                                            <option value="">Select...</option>
                                            <option value="l" name="gender" {{$user->gender == 'l' ? 'selected' : ''}}>Male</option>
                                            <option value="f" name="gender" {{$user->gender == 'f' ? 'selected' : ''}}>Female</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Motto </td>
                                    <td>:</td>
                                    <td><textarea rows="4" cols="50" name="motto" placeholder="Your favorite quote">{{  old('motto', $user->motto) }}</textarea></td>
                                </tr>
                                <tr>
                                    <td>Profession </td>
                                    <td>:</td>
                                    <td><input type="text" name="job" value="{{  old('job', $user->job) }}"></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>:</td>
                                    <td>
                                        <select name="status">
                                            <option value="">Select...</option>
                                            <option value="single" name="status" {{$user->status == 'Single' ? 'selected' : ''}} >Single</option>
                                            <option value="in relationship" name="status" {{$user->status == 'In relationship' ? 'selected' : ''}} >In Relationship</option>
                                            <option value="married" name="status" {{$user->status == 'Married' ? 'selected' : ''}} >Married</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>City </td>
                                    <td>:</td>
                                    <td><input type="text" name="city" placeholder="City" value="{{  old('city', $user->city) }}"></td>
                                </tr>
                                <tr>
                                    <td>Country </td> 
                                    <td>:</td>
                                    <td><input type="country" name="country" placeholder="Country" value="{{  old('country', $user->country) }}"></td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>:</td>
                                    <td><textarea rows="10" cols="30" name="address" placeholder="Address">{{  old('address', $user->address) }}</textarea></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection