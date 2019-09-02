<div id="myCarousel" class="carousel jumbotron p-3 p-md-5 text-white rounded bg-dark text-center slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="col-md-6 px-0 carousel-inner">
        <div class="carousel-item active">
            <img class="first-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="First slide">
            <div class="container">
                <h1 class="display-4 font-italic">WELCOME TO ARTIKEL</h1>
                <p class="lead my-3">A place where you can write your opinion for free!</p>
                @guest
                <p class="lead mb-0"><a href="{{ url('/register') }}" class="btn btn-lg btn-primary" role="button">Get started</a></p>
                @else
                <p class="lead mb-0"><a href="/dashboard" class="btn btn-lg btn-primary" role="button">Dashboard</a></p>
                @endguest
            </div>
        </div>
        <div class="carousel-item">
            <img class="second-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Second slide">
            <div class="container">
                <h1 class="display-4 font-italic">Small but MIGHTY!</h1>
                <p>Share what in your thought and change the world.</p>
                <p><a class="btn btn-lg btn-primary" href="/about" role="button">Learn more</a></p>
            </div>
        </div>
        <div class="carousel-item">
            <img class="third-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Third slide">
            <div class="container">
                <h1 class="display-4 font-italic">For YOU, by YOU!</h1>
                <p>Start writing and share it.</p>
                <p><a class="btn btn-lg btn-primary" href="/blog" role="button">Browse artikel</a></p>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>