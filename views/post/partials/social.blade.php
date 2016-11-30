<nav class="social nav">
    <div class="nav-left">
        <a class="nav-item social">
			<date>{{ $post->get_date() }}</date>
        </a>
		@foreach($post->get_tags() as $tag)
            <a class="nav-item label">
                <span class="tag">{{ $tag }}</span>
            </a>
        @endforeach
    </div>
    <div class="nav-right">
        <a class="nav-item social">
            <span class="icon"><i class="fa fa-google-plus"></i></span>
        </a>
        <a class="nav-item social">
            <span class="icon"><i class="fa fa-twitter"></i></span>
        </a>
        <a class="nav-item social">
            <span class="icon"><i class="fa fa-facebook"></i></span>
        </a>
    </div>
</nav>
