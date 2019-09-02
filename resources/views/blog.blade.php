@extends('layouts.app')

@section('content')
<div class="col-md-8 blog-main">
    <h3 class="pb-3 mb-4 font-italic border-bottom">
    <!-- From the Firehose -->
    </h3>
    @if(count($posts) > 0)
        @foreach($posts as $post)
        <div class="blog-post">
            <div class="row">
                <h2 class="blog-post-title">{{$post->title}}</h2>
                <hr>
                <a href="/posts/{{$post->id}}" class="profile-edit"><input class="profile-edit-btn" name="btnAddMore" value="View post"/></a>
            </div>
            <small>Category : {{$post->kategori}}</small><br>
            <small class="blog-post-meta">{{$post->created_at}} by 
                @guest
                <a href="/profile/{{$post->user->id}}">{{$post->user->fname}} {{$post->user->lname}}</a>
                @else
                    @if($post->user->id == auth()->user()->id)
                    <a href="/user/{{auth()->user()->id}}">{{$post->user->name}}</a>
                    @else
                    <a href="/profile/{{$post->user->id}}">{{$post->user->name}}</a>
                    @endif
                @endguest
            </small>
            <img style="width:50%; height:50%; display:block; margin-left:auto; margin-right: auto;" src="/storage/cover_images/{{$post->cover_image}}">
            <br><br>
            <p>{!!$post->body!!}</p>
            <hr>
            <i class="fa fa-comments-o" aria-hidden="true" style="cursor:default"></i> {{$post->comments->count()}} <small style="color:#3490dc">comments</small> &nbsp;&nbsp;
            <i class="fa fa-thumbs-up" aria-hidden="true" style="cursor:default"></i> {{$post->likers()->get()->count()}} <small style="color:#3490dc">likes</small>
        </div><!-- /.blog-post -->
        <hr>
        @endforeach
        {{$posts->links()}}
    @else
        <p>No posts found</p>
    @endif
</div><!-- /.blog-main -->
@endsection