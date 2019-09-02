@extends('layouts.app')

@section('show')
<div class="row">   
    <h1>{{$post->title}}</h1>
    <hr>
    <a href="{{route('back')}}" class="btn btn-default">Go Back</a>
    <br>  
</div>
<div class="row">
     
    <hr>
    <small>Category : {{$post->kategori}}</small> 
    <br>
    <br>
</div>
<div class="row">
    <img style="width:50%; height:50%; display:block; margin-left:auto; margin-right: auto;" src="/storage/cover_images/{{$post->cover_image}}">
    <br>
    <br>
    <div style="width:100%">
        {!!$post->body!!}
    </div>
    <br>
    <br>
    <small>Written on {{$post->created_at}} by
        @guest
        <a href="/profile/{{$post->user->id}}">{{$post->user->name}}</a>
        @else
            @if($post->user->id == auth()->user()->id)
            <a href="/user/{{auth()->user()->id}}">{{$post->user->fname}} {{$post->user->lname}}</a>
            @else
            <a href="/profile/{{$post->user->id}}">{{$post->user->fname}} {{$post->user->lname}}</a>
            @endif
        @endguest
    </small>
    <hr>
    @if(!Auth::guest())
        @if(Auth::user()->id == $post->user_id)
            <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>

            {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger', 'onclick' => 'return confirm("Are you sure?")'])}}
            {!!Form::close()!!}
        @else
        <div class="panel-info" data-id="{{ $post->id }}" data-user="{{ $post->user->id }}">
            <div class="panel-footer">
                <span class="pull-right">
                    <h4><a href="#" title="Nature Portfolio" class="hidden"></a></h4>
                    <span class="like-btn" style="display: flex;">
                        <span class="give-like">Like 
                        <i id="like{{$post->id}}" class="fa fa-thumbs-o-up {{ auth()->user()->hasLiked($post) ? 'like-post' : '' }}"></i></span> <div id="like{{$post->id}}-bs3" class="thumb">{{ $post->likers()->get()->count() }}</div>
                    </span>
                </span>
            </div>
        </div>
        @endif
    @endif
</div>
<hr>
<div class="row">
    <h4 style="width:100%">Add comment</h4>
    @guest
    <div style="text-align: left; width: 100%">
        <p><a href="{{route('login')}}">Login</a>or <a href="{{route('register')}}">create an account</a> to participate in this conversation.</p>
    </div>
    @else
    <div class="blog-comment">    
        <form method="post" action="{{ route('comment.add') }}" style="width:100%">
            @csrf
            <div class="form-group">
                <input type="text" name="body" id="comment_body" class="form-control" style="width:100%" required="required" />
                <input type="hidden" name="post_id" id="post_id" value="{{ $post->id }}" />
                <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}" />
                <input type="hidden" name="post_owner" id="post_owner" value="{{ $post->user->id }}" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-warning" value="Add Comment" />
            </div>
        </form>
    </div>
    @endguest
    <hr>
@include('partials.coment', ['comments' => $post->comments, 'post_id' => $post->id, 'post_owner' => $post->user->id])
</div> 

@endsection