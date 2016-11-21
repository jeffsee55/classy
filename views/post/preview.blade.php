<section class="section preview">
	<article class="level columns">
		<div class="column is-half">
			<div class="box box-left">
				<label class="category">{{ $post->get_category() }}</label>
				<h1 class="title is-large"><a href="{{ $post->permalink() }}">{{ $post->title() }}</a></h1>
				<date>{{ $post->get_date() }}</date>
			</div>
			<p>{{ $post->get_preview() }}</p>
		</div>
		<figure class="column is-half">
			<img src="{{ $post->thumbnail()->src('medium') }}" alt="">
		</figure>
	</article>
</section>
