<a href="{{ $post->get_permalink() }}">


	<div class="box">
		@if ($post->get_category())
			<label class="category {{ $post->get_category_color() }}">{{ $post->get_category() }}</label>
		@endif
		<h1 class="title is-large">{{ $post->title() }}</h1>
		<date>{{ $post->get_date() }}</date>
	</div>
</a>
<div class="preview-excerpt">{{ $post->get_preview() }}</div>
