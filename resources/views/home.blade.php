@extends('layouts.app')

@section('content')
    <!-- START THE FEATURETTES -->

    <hr class="featurette-divider">
    
    @foreach($pos as $poster)
        @if (++$count % 2 == 0)
            <div class="row featurette">
                <div class="col-md-7">
                    <h2 class="featurette-heading">{{$poster->followable->title}}</h2>
                        <span class="text-muted">Posted {{$poster->followable->created_at->diffforHumans()}} by
                            <a href="/profile/{{$poster->id}}"> {{$poster->name}}</a>
                        </span>
                        <hr>
                    <small>
                        <span class="give-like" style="font-size:16px">Like <i class="fa fa-thumbs-up" aria-hidden="true" style="cursor:default"></i></span><span class="thumb" style="font-size:16px">{{$poster->count}}</span>
                    </small><br>
                    <p class="lead">{!!str_limit($poster->followable['body'], $limit = 400, $end = '...')!!}</p>
                    <a href="/posts/{{$poster->followable_id}}"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> Continue reading</a>
                </div>
                <div class="col-md-5">
                    <img class="featurette-image img-fluid mx-auto" src="/storage/cover_images/{{$poster->followable->cover_image}}" alt="post image">
                </div>
            </div>

            <hr class="featurette-divider">
        @else
            <div class="row featurette">
                <div class="col-md-7 order-md-2">
                    <h2 class="featurette-heading">{{$poster->followable->title}}</h2> <span class="text-muted">Posted {{$poster->followable->created_at->diffforHumans()}} by <a href="/profile/{{$poster->id}}"> {{$poster->name}}</a></span><hr>
                    <small>
                        <span class="give-like" style="font-size:16px">Like <i class="fa fa-thumbs-up" aria-hidden="true" style="cursor:default"></i></span><span class="thumb" style="font-size:16px">{{$poster->count}}</span>
                    </small><br>
                    <p class="lead">{!!str_limit($poster->followable['body'], $limit = 400, $end = '...')!!}</p>
                    <a href="/posts/{{$poster->followable_id}}"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> Continue reading</a>
                </div>
                <div class="col-md-5 order-md-1">
                    <img class="featurette-image img-fluid mx-auto" src="/storage/cover_images/{{$poster->followable->cover_image}}" alt="post image">
                </div>
            </div>

            <hr class="featurette-divider">
        @endif
    @endforeach
    <!-- /END THE FEATURETTES -->

@endsection