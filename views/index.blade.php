@extends('layout.default')

@section('content')

	@if (isset($posts))
		@forelse ($posts as $post)
			@include ($post->get_preview_template())
		@empty
			<p>No posts</p>
		@endforelse
	@endif

	@include ('layout.pagination')

@stop
