@if($post->has_featured_image())
	<section class="hero is-medium single-hero {{ $post->maybe_overlay() }}" style="background-position: {{ $post->background_position() }}; background-image: url({{ $post->thumbnail()->src('wide') }})">
		<div class="hero-body">
			<div class="rellax container {{ $post->title_position() }}" data-rellax-speed="10">
				<div class="column is-half">
					<h1 class="hero-title title">
						{{ $post->title() }}
					</h1>
				</div>
			</div>
		</div>
	</section>
	@include ('post.partials.social')
@else
    <section class="hero is-medium category-hero">
    	<div class="hero-body">
            <div class="box bottom">
                <h1 class="rellax" data-rellax-speed="-2">{{$post->title() }}</h1>
            </div>
            <div class="category-description">
                <div class="category-description-wrapper">
                <div>
            </div>
		</div>
    </section>

@endif
