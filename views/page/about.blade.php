{{-- Side to side layout --}}
{{-- Template Name: About --}}

@extends('layout.default')

@section('content')
	@if ($post)
		<div class="page-layout columns is-gapless">
			<figure class="column is-half">
				<img src="{{ $post->thumbnail()->src('large') }}">
			</figure>
			<div class="column is-half">
				<article class="page">
					<div class="box bottom">
						<h1 class="title">{{ $post->title() }}</h1>
					</div>

					<section class="body">
						{{ $post->content() }}
					</section>
				</article>
			</div>
		</div>
		<div class="columns level is-gapless contact-info">
            @foreach ($post->meta('_contact') as $contact)
    			<div class="column is-half is-level">
            		<div class="columns">
            			<div class="column is-10 is-offset-1 box">
                            <p class="has-text-centered">
                                {{ $contact['message'] }}</br>
                                <a href="mailto: {{ $contact['email'] }}">{{ $contact['email'] }}</a>
                            </p>
                            <div class="nav-center">
                                @if(! empty($contact['instagram']))
                                    <a class="nav-item social" href="{{ $contact['instagram'] }}">
                                        <span class="icon is-large"><i class="fa fa-instagram"></i></span>
                                    </a>
                                @endif
                                @if(! empty($contact['pinterest']))
                                <a class="nav-item social" href="{{ $contact['pinterest'] }}">
                                    <span class="icon is-large"><i class="fa fa-pinterest"></i></span>
                                </a>
                                @endif
                                @if(! empty($contact['twitter']))
                                <a class="nav-item social" href="{{ $contact['twitter'] }}">
                                    <span class="icon is-large"><i class="fa fa-twitter"></i></span>
                                </a>
                                @endif
                                @if(! empty($contact['facebook']))
                                <a class="nav-item social" href="{{ $contact['facebook'] }}">
                                    <span class="icon is-large"><i class="fa fa-facebook"></i></span>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
	@endif
@stop
