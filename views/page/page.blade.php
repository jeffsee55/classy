@extends('layout.default')

@section('content')
	@if ($post)
		<div class="columns is-gapless">
			<figure class="column is-half">
				<img src="{{ $post->thumbnail()->src('large') }}">
			</figure>
			<div class="column is-half">
			<article class="page">
				<div class="box bottom">
					<h1 class="title">{{ $post->title() }}</h1>
				</div>

				<section class="body">
					{{ $post->content() }}
				</section>
			</article>
		</div>
	@endif
@stop
