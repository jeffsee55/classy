@extends('layout.default')

@section('content')

    <section class="section preview text-center">
    	<article class="">
    		<figure class="wide">
				<img src="{{ $post->thumbnail()->src('wide') }}" alt="">
    		</figure>
    		<div class="column is-half is-offset-3 wide-layout">
                <div class="preview-excerpt">{{ $post->get_preview() }}</div>
    		</div>
    	</article>
    </section>

	@if (isset($posts))
		@include ('post.partials.list')
	@endif

@stop
