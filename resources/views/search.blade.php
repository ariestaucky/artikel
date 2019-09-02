@extends('layouts.app')

@section('content')
<div class="col-md-8 blog-main">
    <h3 class="pb-3 mb-4 font-italic border-bottom">
    {{count($posts)}} Result for {{$searchTerm}}
    </h3>
    @if(count($posts) > 0)
        @foreach($posts as $post)
        <div class="blog-post">
            <div class="row">
                <h2 class="blog-post-title">{{$post->title}}</h2>
                <hr>
            </div>
            <small>Category : {{$post->kategori}}</small><br>
            <small class="blog-post-meta">{{$post->created_at}} by <a href="/profile/{{$post->user->id}}">{{$post->user->name}}</a></small>
            <img style="width:50%; height:50%; display:block; margin-left:auto; margin-right: auto;" src="/storage/cover_images/{{$post->cover_image}}">
            <br><br>
            <p>{!! str_limit($post->body, $limit = 150, $end = '...') !!}<a href="/posts/{{$post->id}}"> ->Details</a></p>
            
        </div><!-- /.blog-post -->
        <hr>
        @endforeach
        {{$posts->links()}}
    @else
        <p>No posts found</p>
    @endif
</div><!-- /.blog-main -->

@endsection