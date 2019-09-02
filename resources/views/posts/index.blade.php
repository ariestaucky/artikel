@extends('layouts.app')

@section('content')
    @if(count($posts) > 0)
        @foreach($posts as $post)
            <div class="col-md-4 col-sm-4">
                <img style="width:100%" src="{{asset('/public/cover_images/' . $post->cover_image)}}">
            </div>
            <div class="col-md-8 col-sm-8">
                <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                <small>Category : {{$post->kategori}}</small><hr>
                <small>Written on {{$post->created_at}} by 
                    <b style="color: #3490dc;">
                        {{$post->user->name}}
                    </b>
                </small>
            </div>
        @endforeach
        {{$posts->links()}}
    @else
        <p>No posts found</p>
    @endif
@endsection