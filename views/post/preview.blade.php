<section class="section preview {{ $post->get_layout() }}">
	<article class="columns is-gapless">
		<div class="image-column column is-5">
			<a href="{{ $post->get_permalink() }}">
				<figure class="rellax" data-rellax-speed="-0.75" data-rellax-percentage="0.5" style="background-image: url({{ $post->thumbnail()->src('large') }})">
				</figure>
			</a>
		</div>
		<div class="text-column column is-7">
			<div class="preview-text rellax" data-rellax-speed="0.75" data-rellax-percentage="0.5">
				<div class="text-wrapper">
					@include ('post.partials.box')
				</div>
			</div>
		</div>
	</article>
</section>
