<section class="hero is-medium single-hero {{ $post->maybe_overlay() }}" style="background-position: {{ $post->background_position() }}; background-image: url({{ $post->thumbnail()->src('wide') }})">
	<div class="hero-body">
		<div class="container {{ $post->title_position() }}">
			<div class="column is-half box">
				<h1 class="title">
					{{ $post->title() }}
				</h1>
			</div>
		</div>
	</div>
</section>
