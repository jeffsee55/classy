<?php $layout = null; ?>
@forelse ($posts as $index => $post)
	@include ($post->get_preview_template($layout))
	<?php $layout = $post->get_layout(); ?>
	@if($index == 1)
		<section class="spacer callout">
			<div>
				<div class="callout-text">
					{{ the_field('subscribe_text', 'option') }}
				</div>
				<div class="control has-addons has-addons-fullwidth">
					<input class="input" type="text" placeholder="Email">
					<input class="button is-primary" type="submit" value="submit">
				</div>
			</div>
		</section>
	@else
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
