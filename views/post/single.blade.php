@extends('layout.default')

@section('content')
	@if ($post)
		<section class="hero is-medium {{ $post->maybe_overlay() }}" style="background-image: url({{ $post->thumbnail()->src('wide') }})">
			<div class="hero-body">
				<div class="container {{ $post->title_position() }}">
					<div class="column is-half box half">
						<date>{{ $post->get_date() }}</date>
						<h1 class="title">
							{{ $post->title() }}
						</h1>
					</div>
				</div>
			</div>
		</section>
		<article class="single">
			<section class="body content">
				@include ('post.partials.social')
				{{ $post->content() }}
			</section>

			{{ comments_template() }}
		</article>
	@endif
@stop
