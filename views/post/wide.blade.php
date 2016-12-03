<section class="section preview text-center">
	<article class="">
		<figure class="wide">
			<a href="{{ $post->get_permalink() }}">
				<img src="{{ $post->thumbnail()->src('wide') }}" alt="">
			</a>
		</figure>
		<div class="column is-half is-offset-3 wide-layout preview-text">
			@include ('post.partials.box')
		</div>
	</article>
</section>
