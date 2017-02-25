@extends('layout.default')

@section('content')
	@if ($post)
		@include ('post.partials.hero')
		@include ('post.partials.social')
		<article class="single">
			<section class="body content">
				{{ $post->content() }}
			</section>

		    <div class="nav-left">
				@foreach($post->get_tags() as $tag)
		            <a href="{{ get_term_link($tag->term_id) }}" class="nav-item label">
		                <span class="tag">{{ $tag->name }}</span>
		            </a>
		        @endforeach
		    </div>
		</article>
	@endif
@stop
