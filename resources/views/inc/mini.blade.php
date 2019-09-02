<div class="row mb-2" >
    @foreach($popular as $u)
    <div class="col-md-6" >    
        <div class="card flex-md-row mb-4 shadow-sm h-md-250" style="height:100%">
        <div class="card-body d-flex flex-column align-items-start">
            <strong class="d-inline-block mb-2 text-primary">Most Popular Author</strong>
            <h3 class="mb-0">
            <a class="text-dark">{!! $u->followable->name !!}</a>
            </h3>
            <div class="mb-1 text-muted">{{$u->followable->job}}</div>
            <div>
                <p class="card-text mb-auto lead">{!!str_limit($u->followable->bio, $limit = 60, $end = '...')!!}</p>      
                <br>    
                <a href="/profile/{{$u->followable_id}}"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> Profile</a>
                <hr>    
                <small>
                    <span class="give-like" style="font-size:16px">
                    <a href="{{route('follower', $u->followable_id)}}" style="color: black; text-decoration: none;">Follower <i class="fa fa-users" style="cursor:default;" aria-hidden="true"></i></span><span class="thumb" style="font-size:16px">{{$u->count}}</a> 
                    </span>
                </small>
            </div>

        </div>
            <img style="width:30%; height:100%" class="card-img-right flex-auto d-none d-lg-block" src="{{asset('/public/cover_images/' . $u->followable->profile_image)}}" alt="Card image cap">
        </div>
    </div>
    @endforeach

    @foreach($popu as $author)
    <div class="col-md-6" >    
        <div class="card flex-md-row mb-4 shadow-sm h-md-250" style="height:100%">
        <div class="card-body d-flex flex-column align-items-start">
            <strong class="d-inline-block mb-2 text-primary">Most Productive Author</strong>
            <h3 class="mb-0">
            <a class="text-dark">{!! $author->name !!}</a>
            </h3>
            <div class="mb-1 text-muted">{{$author->job}}</div>
            <div>
                <p class="card-text mb-auto lead">{!!str_limit($author->bio, $limit = 60, $end = '...')!!}</p>      
                <br>    
                <a href="/profile/{{$author->id}}"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> Profile</a>
                <hr>    
                <small>
                    <span class="give-like" style="font-size:16px">
                    <a href="{{route('open', $author->id)}}" style="color: black; text-decoration: none;">Artikel <i class="fa fa-clipboard" style="cursor:default;" aria-hidden="true"></i></span><span class="thumb" style="font-size:16px">{{$author->post}}</a>
                    </span>
                </small>
            </div>

        </div>
            <img style="width:30%; height:100%" class="card-img-right flex-auto d-none d-lg-block" src="{{asset('/public/cover_images/' . $author->profile_image)}}" alt="Card image cap">
        </div>
    </div>
    @endforeach
</div>
<div class="or-seperator" style="margin-top:5em"></div>