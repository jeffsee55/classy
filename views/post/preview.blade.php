<section class="section preview {{ $post->get_layout() }}">
	<article class="level columns is-gapless">
		<figure class="column is-half">
			<img src="{{ $post->thumbnail()->src('large') }}" alt="">
		</figure>
		<div class="preview-text column is-half">
			<div class="text-wrapper">
				@include ('post.partials.box')
			</div>
		</div>
	</article>
</section>
