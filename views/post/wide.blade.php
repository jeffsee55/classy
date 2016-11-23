<section class="section preview text-center">
	<article class="">
		<figure class="wide">
			<img src="{{ $post->thumbnail()->src('wide') }}" alt="">
		</figure>
		<div class="column is-half is-offset-3 wide-layout preview-text">
			@include ('post.partials.box')
		</div>
	</article>
</section>
