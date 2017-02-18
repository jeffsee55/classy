{{-- Hero page with text overlain. --}}
{{-- Template Name: Hero --}}

@extends('layout.default')

@section('content')

    <section
    class="home-hero hero is-large {{ $post->maybe_overlay() }}"
    style="background-image: url({{ $post->thumbnail()->src('original') }})">
		<div class="container {{ $post->title_position() }}">
			<div class="column is-half">
				{{ $post->content() }}
			</div>
		</div>
    </section>
	<section class="spacer">
	</section>

	@if (isset($posts))
		@include ('post.partials.list')
	@endif

@stop
