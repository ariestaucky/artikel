@extends('layouts.app')

@section('content')
<div class="col-md-8 blog-main">
    <h2>{{$month}}, {{$year}}</h2>
    <hr>
    @foreach($data as $data)
    <div class="blog-post">
        <div class="row">
            <h3 style="width:100%"><a href="/posts/{{$data->id}}">{{$data->title}}</a></h3><hr>
            <div class="col-md-4 col-sm-4">
                <img style="width:100%" src="/storage/cover_images/{{$data->cover_image}}">
            </div>
            <div class="col-md-8 col-sm-8">
                <small>Category : {{$data->kategori}}</small><hr>
                <small>Written on {{$data->created_at}} by 
                    <b style="color: #3490dc;">
                    @guest
                    <a href="/profile/{{$data->user->id}}">{{$data->user->name}}</a>
                    @else
                        @if($data->user->id == auth()->user()->id)
                        <a href="/user/{{auth()->user()->id}}">{{$data->user->name}}</a>
                        @else
                        <a href="/profile/{{$data->user->id}}">{{$data->user->name}}</a>
                        @endif
                    @endguest
                    </b>
                </small>
            </div>
        </div>
    </div>
    <hr>
    @endforeach
</div>
@endsection