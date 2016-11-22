<section class="section preview {{ $post->get_layout() }}">
	<article class="level columns is-gapless">
		<figure class="column is-half">
			<img src="{{ $post->thumbnail()->src('large') }}" alt="">
		</figure>
		<div class="preview-text column is-half">
			<div class="text-wrapper">
				<div class="box">
					<label class="category">{{ $post->get_category() }}</label>
					<h1 class="title is-large"><a href="{{ $post->permalink() }}">{{ $post->title() }}</a></h1>
					<date>{{ $post->get_date() }}</date>
				</div>
				<p>{{ $post->get_preview() }}</p>
			</div>
		</div>
	</article>
</section>
