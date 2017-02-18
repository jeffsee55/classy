<section class="section preview {{ $post->get_layout() }}">
	<article class="columns is-gapless">
		<div class="image-column column is-5">
			<a href="{{ $post->get_permalink() }}">
				<figure style="background-image: url({{ $post->thumbnail()->src('large') }})">
				</figure>
			</a>
		</div>
		<div class="text-column column is-7">
			<div class="preview-text">
				<div class="text-wrapper">
					@include ('post.partials.box')
				</div>
			</div>
		</div>
	</article>
</section>
