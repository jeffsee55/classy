<?php $layout = null; ?>
@forelse ($posts as $index => $post)
	@include ($post->get_preview_template($layout))
	<?php $layout = $post->get_layout(); ?>
	@if($index != (count($posts) - 1))
		<section class="spacer">
		</section>
	@endif
@empty
    <section class="hero is-large">
    	<div class="hero-body">
    		<div class="container">
    			<div class="column is-half">
					<h1>Sorry, no posts found</h1>
    			</div>
    		</div>
    	</div>
    </section>
@endforelse

@include ('layout.pagination')
