{{-- Side to side layout --}}
{{-- Template Name: About --}}

@extends('layout.default')

@section('content')
	@if ($post)
		<div class="page-layout about-page">
			<div class="container">
				<div class="columns is-gapless">
					<figure class="column is-half">
						<div style="background-position: {{ $post->background_position() }}; background-image: url({{ $post->thumbnail()->src('large') }})"></div>
					</figure>
					<div class="column is-half">
						<article class="page">
							<div class="box">
								<h1 class="title">{{ $post->title() }}</h1>
								<hr>
								<section class="body">
									{{ $post->content() }}
								</section>
							</div>
						</article>
					</div>
				</div>
			</div>
		</div>
		<div class="columns level is-gapless contact-info">
			@if( have_rows('contact_box') )
			    @while ( have_rows('contact_box') )
					<?php the_row(); ?>
	    			<div class="column is-half is-level">
	            		<div class="columns">
	            			<div class="column is-10 is-offset-1">
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
		</div>
	@endif
	@include ('instagram')
@stop
