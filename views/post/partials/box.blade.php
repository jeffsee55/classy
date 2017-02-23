<a href="{{ $post->get_permalink() }}">
	<div class="box">
		@if ($post->get_category())
			<label class="category" style="background-color: {{ $post->get_category_color() }}">{{ $post->get_category()->name }}</label>
		@endif
		<h1 class="title is-large">{{ $post->title() }}</h1>
		@if(! $post->should_hide_date())
			<date>{{ $post->get_date() }}</date>
		@endif
	</div>
</a>
<div class="preview-excerpt">{{ $post->get_preview() }}</div>
