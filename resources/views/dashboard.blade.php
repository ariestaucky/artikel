@extends('layouts.app')

@section('content')
<div class="col-md-8 blog-main">
    <div class="card">
        <div class="card-header">Dashboard</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

           <p style="color: blue;">Welcome back <b style="color:black;">{{ Auth::user()->username}}</b>!</p>
        </div>
        <div class="col-md-4" style="max-width: 100%;">

                <fieldset>
                    <legend>Basic Account Info:
                        <a href="{{route('user.edit', Auth::user()->id)}}" class="profile-edit" style="float:right; font-size:medium;">
                            <button type="button" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button>
                        </a>
                    </legend>
                        <table class="table" >
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td><p>{{ Auth::user()->name }}</p></td>
                            </tr>
                            <tr>
                                <td>Username</td>
                                <td>:</td>
                                <td><p>{{ Auth::user()->username}}</p></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td><p>{{ Auth::user()->email}} </p></td>
                            </tr>
                        </table>
                </fieldset>

        </div>
        <div class="col-md-4" style="max-width: 100%;">

                <fieldset>
                    <legend>Your Post:
                        <a href="{{route('posts.create')}}" class="profile-edit" style="float:right; font-size:medium;">
                            <button type="button" class="btn btn-primary btn-sm" title="Create Post"><i class="fa fa-plus" aria-hidden="true"></i> Create</button>
                        </a>
                    </legend>
                    @if(count($po) > 0)
                        <table class="table table-striped">
                            <tr>
                                <th>Title</th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach($po as $post)
                                <tr>
                                    <td><a href="/posts/{{$post->id}}" title="view {{$post->title}}">{{$post->title}}</a></td>
                                    <td style="text-align:right;">
                                        {{ $post->likers()->count() }} <small style="font-style:italic">Liked</small>/
                                        {{ $post->comments->count() }} <small style="font-style:italic">comments</small>
                                    </td>
                                    <td style="text-align:right;">
                                        <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>
                                        <button type="button" class="btn btn-danger btn-sm" title="Delete" onclick=" document.getElementById('confirmDel').style.display = 'block'"><i class="fa fa-trash-o" aria-hidden="true"></i></button>

                                        <!-- Hidden confirmation modal -->
                                        <div class="modal overlay" id="confirmDel">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Delete Confirmation</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p style="text-align:center;">Do you want to delete this?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                    {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST'])!!}
                                                        {{Form::hidden('_method', 'DELETE')}}
                                                        {{Form::submit('Delete', ['class' => 'btn btn-danger delete'])}}
                                                    {!!Form::close()!!}              
                                                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" onclick="document.getElementById('confirmDel').style.display = 'none'">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End of Hidden modal -->

                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p>You have no posts</p>
                    @endif
                </fieldset>

        </div>
    </div>
</div>
@endsection
