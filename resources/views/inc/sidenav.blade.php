<aside class="col-md-4 blog-sidebar">
    @if(!Auth::guest())
    <div class="p-3 text-center" style="padding:0 !important;">
        <div class="col-lg-3 col-sm-6" style="max-width:100%;">
            <div class="card hovercard">
                <div class="cardheader">

                </div>
                
                <div class="avatar">
                    <img alt="" src="{{asset('/public/cover_images/' . Auth::user()->profile_image)}}">
                </div>
                
                <div class="info">
                    <div class="title">
                        <a target="_blank" href="{{route('user.edit', Auth::user()->id)}}" title="Edit">{{Auth::user()->name}}</a>
                    </div>
                    <div class="desc">{{Auth::user()->job}}</div>
                </div>
                <div class="bottom" style="display:flex;">
                    <div class="col-md-6 col-xs-6 follow line" align="center">
                        <a href="/following" style="color:white;text-decoration:none">
                            <small>
                            {{ Auth::user()->followings()->get()->count() }} <br/> <span><b>FOLLOWING</b></span>
                            </small>
                        </a>
                    </div>
                    <div class="col-md-6 col-xs-6 follow line" align="center">
                        <a href="/follower" style="color:white;text-decoration:none">
                            <small>
                            {{ Auth::user()->followers()->get()->count() }}  <br/> <span><b>FOLLOWERS</b></span>
                            </small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>   
    @endif 

    <div class="p-3 mb-3 bg-light rounded">
        <h4 class="font-italic">About</h4>
        <p class="mb-0">Artikel adalah media sosial sekaligus ajang tempat mencurahkan pendapat tentang apa saja secara <em>gratis</em>. Tulis kisah Anda atau Anda ingin berpendapat tentang sesuatu di <b>Artikel</b>!</p>
    </div>

    <div class="p-3">
        <h4 class="font-italic">Archives</h4>
        <ol class="list-unstyled mb-0">
            @foreach($archive as $post)
                <li>      
                    <a href="{{ route('view', ['month' => $post->month_name, 'year'=>$post->year]) }}">
                    {{ $post->month_name }}, {{ $post->year }} <b class="">({{ $post->post_count }})</b>
                    </a>
                </li>
            @endforeach
        </ol>
    </div>

    <div class="p-3">
        <h4 class="font-italic">Category</h4>
        <ol class="list-unstyled">
            <li><a href="{{route('catagory', ['cat' => 'Politic'])}}">Politic</a>&nbsp; ({{$posts->where('kategori', 'Politic')->count()}})</li>
            <li><a href="{{route('catagory', ['cat' => 'Economy'])}}">Economy</a>&nbsp; ({{$posts->where('kategori', 'Economy')->count()}})</li>
            <li><a href="{{route('catagory', ['cat' => 'Social'])}}">Social</a>&nbsp; ({{$posts->where('kategori', 'Social')->count()}})</li>
            <li><a href="{{route('catagory', ['cat' => 'Culture'])}}">Culture</a>&nbsp; ({{$posts->where('kategori', 'Culture')->count()}})</li>
            <li><a href="{{route('catagory', ['cat' => 'Sains&Technology'])}}">Sains & Technology</a>&nbsp; ({{$posts->where('kategori', 'Sains&Technology')->count()}})</li>
            <li><a href="{{route('catagory', ['cat' => 'Religious'])}}">Religious</a>&nbsp; ({{$posts->where('kategori', 'Religious')->count()}})</li>
            <li><a href="{{route('catagory', ['cat' => 'General'])}}">General</a>&nbsp; ({{$posts->where('kategori', 'General')->count()}})</li>
        </ol>
    </div>

    <div class="p-3">
        <h4 class="font-italic">Elsewhere</h4>
        <ol class="list-unstyled">
            <li><a href="#">GitHub</a></li>
            <li><a href="#">Twitter</a></li>
            <li><a href="#">Facebook</a></li>
        </ol>
    </div>
</aside><!-- /.blog-sidebar -->