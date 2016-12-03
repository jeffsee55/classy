<?php $layout = null; ?>
@forelse ($posts as $post)
	@include ($post->get_preview_template($layout))
	<?php $layout = $post->get_layout(); ?>
@empty
	<p>No posts</p>
@endforelse

@include ('layout.pagination')
