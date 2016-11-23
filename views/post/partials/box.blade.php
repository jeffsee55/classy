<a href="{{ $post->get_permalink() }}">
	<div class="box">
		<label class="category {{ $post->get_category_color() }}">{{ $post->get_category() }}</label>
		<h1 class="title is-large">{{ $post->title() }}</h1>
		<date>{{ $post->get_date() }}</date>
	</div>
</a>
<p>{{ $post->get_preview() }}</p>
