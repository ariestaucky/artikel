<nav class="navbar navbar-default navbar-expand-lg navbar-light">
	<div class="navbar-header d-flex col">
		<a href="/" class="navbar-brand">Arti<b>kel</b></a>  		
		<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navbar-toggler ml-auto">
			<span class="navbar-toggler-icon"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	<!-- Collection of nav links, forms, and other content for toggling -->
	<div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
		<ul class="nav navbar-nav">
        @if(auth::user())
            <li class="nav-item {{Request::is('/') ? 'active' : ''}}"><a href="/dashboard" class="nav-link">Dashboard</a></li>
        @else
			<li class="nav-item {{Request::is('/') ? 'active' : ''}}"><a href="/" class="nav-link">Home</a></li>			
        @endif
            <li class="nav-item {{Request::is('blog') ? 'active' : ''}}"><a href="/blog" class="nav-link" >Blog</a></li>
        @if(auth::user())
            <li class="nav-item {{Request::is('profile') ? 'active' : ''}}"><a href="/user/{{auth()->user()->id}}" class="nav-link">Profile</a></li>
			<li class="nav-item {{Request::is('contact') ? 'active' : ''}}"><a href="/contact" class="nav-link">Contact</a></li>
        @else
            <li class="nav-item {{Request::is('about') ? 'active' : ''}}"><a href="/about" class="nav-link">About</a></li>
        @endif
		</ul>
		<form class="navbar-form form-inline" method="GET" action="/search" role="search">
            {{csrf_field()}}
			<div class="input-group search-box">								
				<input type="text" id="search" name="search" class="form-control" placeholder="Search here...">
				<span class="input-group-addon"><i class="material-icons">&#xE8B6;</i></span>
			</div>
        </form>
        @guest
            @if(Request::is('login'))
            <ul class="nav navbar-nav ml-auto">	
                <a href="{{ url('/register') }}"><li class="btn btn-primary get-started-btn mt-1 mb-1">Register</li></a>
            </ul>
            @elseif(Request::is('register'))
            <ul class="nav navbar-nav ml-auto">	
                <a href="{{ url('/login') }}"><li class="btn btn-primary get-started-btn mt-1 mb-1">Login</li></a>
            </ul>
            @else
            <ul class="nav navbar-nav ml-auto">			
                <li class="nav-item">
                    <a href="{{ route('login'). '?previous=' . Request::fullUrl() }}" data-toggle="dropdown" class="btn btn-primary dropdown-toggle get-started-btn mt-1 mb-1">Login</a>
                    <ul class="dropdown-menu form-wrapper">					
                        <li>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <p class="hint-text">Sign in with your social media account</p>
                                <div class="form-group social-btn clearfix">
                                    <a href="{{ url('/auth/facebook') }}" class="btn btn-primary pull-left"><i class="fa fa-facebook"></i> Facebook</a>
                                    <a href="{{ url('/auth/twitter') }}" class="btn btn-info pull-right"><i class="fa fa-twitter"></i> Twitter</a>
                                </div>
                                <div class="or-seperator"><b>or</b></div>
                                <div class="form-group">
                                    <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>

                                    @if ($errors->has('username'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password"  required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <input type="submit" name="submit" id="submit" class="btn btn-primary btn-block" value="Login">
                                <div class="form-footer">
                                    <a href="#">Forgot Your password?</a>
                                </div>
                                
                            </form>
                                <div class="or-seperator"><b>or</b></div>
                                <!-- <p class="account">Need an account?</p> -->
                                <!-- <a ><input type="submit" name="submit" id="submit" class="btn btn-primary btn-block" value="Sign up"></a> -->
                                <div class="bottom text-center">
								    New here ? <a href="{{route('register')}}"><b>Join Us</b></a>
							    </div>
                        </li>
                    </ul>
                </li>
            </ul>
            @endif
        @else
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a href="#" class="nav-link notifications dropdown-toggle" id="notifications" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i><span class="badge" id="notif-counter"></span>
                </a>

                <ul class="dropdown-menu" aria-labelledby="notificationsMenu" id="notificationsMenu" style="word-break: break-word; max-width:400%; min-width: 0 !important; overflow:hidden; text-overflow:ellipsis;">
                    @if(count($notify) > 0)
                        @foreach(array_slice($notify, 0, 8) as $notify)
                            <li class="dropdown-header" style="padding: 0.5rem 0.5rem !important; word-break: break-word; width:100%; overflow:hidden; text-overflow:ellipsis;">
                                @if(empty($notify->relation))
                                    @if(empty($notify->reply))
                                    <a href="{{route('comment', [$notify->id, $notify->pid])}}" style="padding: 8px 12px !important"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; <b style="color:blue">{{$notify->name}}</b> comment on post <b style="color:blue">"{{$notify->post}}"</b>!</a>
                                    @else
                                    <a href="{{route('reply', [$notify->id, $notify->pid, $notify->reply])}}" style="padding: 8px 12px !important"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; <b style="color:blue">{{$notify->name}}</b> reply on your comment on post <b style="color:blue">"{{$notify->post}}"</b>!</a>
                                    @endif
                                @elseif($notify->relation == 'like')
                                <a href="{{route('like', [$notify->id, $notify->pid])}}" style="padding: 8px 12px !important"><i class="fa fa-thumbs-up" aria-hidden="true"></i>&nbsp; <b style="color:blue">{{$notify->name}}</b> {{$notify->relation}} your post <b style="color:blue">"{{$notify->post}}"</b>!</a>
                                @else
                                    @if(empty($notify->pid))
                                    <a href="{{route('follow', [$notify->id])}}" style="padding: 8px 12px !important"><i class="fa fa-users" aria-hidden="true"></i>&nbsp; <b style="color:blue">{{$notify->name}}</b> {{$notify->relation}} you!</a>
                                    @else
                                    <a href="{{route('new_post', [$notify->id, $notify->pid])}}" style="padding: 8px 12px !important"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; <b style="color:blue">{{$notify->name}}</b> published NEW artikel {{$notify->post}}!</a>
                                    @endif
                                @endif
                            </li>
                        @endforeach
                        <div class="or-seperator" style="margin-top: 0 !important;"></div>
                        <li class="dropdown-header" style="text-align:center"><a href="/history"><b style="color:blue">Show all</b></a></li>
                    @else
                        <li class="dropdown-header">No notifications</li>
                        <div class="or-seperator" style="margin-top: 0 !important;"></div>
                        <li class="dropdown-header" style="text-align:center"><a href="/history"><b style="color:blue">History</b></a></li>
                    @endif
                </ul>
            </li>
			<li class="nav-item">
                <a href="/contact?#inbox" class="nav-link messages">
                    <i class="fa fa-envelope-o"></i><span class="badge" id="msg-counter"></span>
                </a>
            </li>
			<li class="nav-item dropdown">
				<a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle user-action" title="{{Auth::user()->name}}"><img src="{{asset('/public/cover_images/' . Auth::user()->profile_image)}}" class="avatar" alt="Avatar">{{ Auth::user()->name }}<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="/dashboard" class="dropdown-item"><i class="fa fa-user-o"></i> Dashboard</a></li>
					<li><a href="/posts" class="dropdown-item"><i class="fa fa-calendar-o"></i> Post</a></li>
					<li class="divider dropdown-divider"></li>
                    <li><a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="material-icons">&#xE8AC;</i> Logout</a></li>
                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
				</ul>
			</li>
		</ul>
        @endguest
	</div>
</nav>