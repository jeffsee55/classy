<section class="section preview">
	<article class="">
		<figure class="wide">
			<img src="{{ $post->thumbnail()->src('wide') }}" alt="">
		</figure>
		<div class="column is-half is-offset-3 wide-layout preview-text">
			<div class="box">
				<label class="category">{{ $post->get_category() }}</label>
				<h1 class="title is-large"><a href="{{ $post->permalink() }}">{{ $post->title() }}</a></h1>
				<date>{{ $post->get_date() }}</date>
			</div>
			<p>{{ $post->get_preview() }}</p>
		</div>
	</article>
</section>
