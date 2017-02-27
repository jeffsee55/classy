{{-- Side to side layout --}}
{{-- Template Name: About --}}

@extends('layout.default')

@section('content')
	@if ($post)
		<section class="spacer short">
		</section>
		<section class="section preview {{ $post->get_layout() }}">
			<article class="columns is-gapless">
				<div class="image-column column is-5">
					<figure style="background-image: url({{ $post->thumbnail()->src('large') }})">
						<a href="{{ $post->get_permalink() }}">
						</a>
					</figure>
				</div>
				<div class="text-column column is-7">
					<div class="preview-text">
						<div class="text-wrapper">
							<div class="box">
								@if ($post->get_category())
									<label class="category {{ $post->get_category_color() }}">{{ $post->get_category() }}</label>
								@endif
								<h1 class="title is-large">{{ $post->title() }}</h1>
							</div>
							<div class="columns">
								<div class="column is-offset-2 is-8">
									{{ $post->get_content() }}
								</div>
							</div>
						</div>
					</div>
				</div>
			</article>
		</section>
		<section class="columns level contact-info is-multiline">
			@if( have_rows('contact_box') )
			    @while ( have_rows('contact_box') )
					<?php the_row(); ?>
	    			<div class="column is-half">
	            		<div class="columns">
	            			<div class="column is-12">
	                            <h4 class="has-text-centered">{{ the_sub_field('text') }}</h4>
	                            <p class="has-text-centered">
	                                <a href="mailto: {{ the_sub_field('email') }}">{{ the_sub_field('email') }}</a>
	                            </p>
	                            <div class="nav-center">
									@if( have_rows('social_links') )
									    @while ( have_rows('social_links') )
											<?php the_row(); ?>
		                                    <a class="nav-item social" href="{{ the_sub_field('url') }}">
		                                        <span class="icon is-large"><i class="fa fa-{{ the_sub_field('icon') }}"></i></span>
		                                    </a>
		                                @endwhile
	                                @endif
								</div>
							</div>
						</div>
					</div>
			    @endwhile
			@endif
		</section>
	@endif
@stop
