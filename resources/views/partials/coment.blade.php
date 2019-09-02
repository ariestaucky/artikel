@foreach($comments->sortByDesc('created_at') as $comment)   
<div class="container">
    <main role="main" class="container"> 
        <div class="row">
            <div class="blog-comment">
                <div class="container">
                    <div class="row">      
                        <div class="col-sm-1" style="max-width:100% !important;">
                            <div class="thumbnail">
                                <img class="img-responsive user-photo" src="{{asset('/public/cover_images/' . $comment->user->profile_image)}}" alt="profile_image" style="width:100%">
                            </div><!-- /thumbnail -->
                        </div><!-- /col-sm-1 -->

                        <div class="col-sm-5" style="max-width: 100% !important; flex: 1;">
                            <div class="panel panel-default" id="comment/{{$comment->user->id}}">
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
                        @if(auth::user())
                        <a href="" id="reply"></a>
                        <form method="post" action="{{ route('reply.add') }}" id="reply">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="body" class="form-control" required="required" />
                                <input type="hidden" name="post_id" value="{{ $post_id }}" />
                                <input type="hidden" name="comment_id" value="{{ $comment->id }}" />
                                <input type="hidden" name="user_id" value="{{ $comment->user->id }}" />
                                <input type="hidden" name="post_owner" id="post_owner" value="{{ $post_owner }}" />
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-warning comment" value="Reply" />
                            </div>
                        </form>
                        @endif
                        <hr>
                        @include('partials.comment', ['comments' => $comment->replies, 'post_owner' => $post_owner])
                        <hr>   
                    </div>
                </div>
            </div>  
        </div>
    </main>
</div>
@endforeach

   

