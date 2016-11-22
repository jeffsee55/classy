@extends('layout.default')

@section('content')
	@if (isset($posts))
		<?php $layout = 'text-left'; ?>
		@forelse ($posts as $post)
			@include ($post->get_preview_template($layout))
			<?php $layout = $post->get_layout(); ?>
		@empty
			<p>No posts</p>
		@endforelse
	@endif

	@include ('layout.pagination')

@stop
