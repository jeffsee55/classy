<section class="section preview {{ $post->get_layout() }}">
	<article class="columns is-gapless">
		<figure class="column is-half">
			<a href="{{ $post->get_permalink() }}">
				<img src="{{ $post->thumbnail()->src('large') }}" alt="">
			</a>
		</figure>
		<div class="column is-half">
			<div class="preview-text">
				<div class="text-wrapper">
					@include ('post.partials.box')
				</div>
			</div>
		</div>
	</article>
</section>
