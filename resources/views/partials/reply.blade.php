@foreach($comments as $comment)  
    <div class="container reply">
        <div class="row"> 
            <div class="col-sm-1" style="max-width:100% !important;">
                <div class="thumbnail">
                    <img class="img-responsive user-photo" src="{{asset('/public/cover_images/' . $comment->user->profile_image)}}" alt="profile_image" style="width:100%">
                </div><!-- /thumbnail -->
            </div><!-- /col-sm-1 -->

            <div class="col-sm-5" style="max-width: 100% !important; flex: 1;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    @if($comment->user->id == auth()->user()->id)
                        <a href="/user/{{$comment->user->id}}"><strong>{{ $comment->user->name }}</strong></a> <span class="text-muted">{{ $comment->created_at->diffforHumans()}}</span>
                    @else
                        <a href="/profile/{{$comment->user->id}}"><strong>{{ $comment->user->name }}</strong></a> <span class="text-muted">{{ $comment->created_at->diffforHumans()}}</span>
                    @endif
                    </div>
                        <div class="panel-body">
                            {{ $comment->body }}
                        </div><!-- /panel-body -->
                    </div><!-- /panel panel-default -->
                </div><!-- /col-sm-5 -->
            </div>
        </div><!-- /row -->
    </div>
@endforeach

