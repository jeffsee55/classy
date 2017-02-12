@extends('layout.default')

@section('content')

    <section class="hero is-medium category-hero">
    	<div class="hero-body">
    		<div class="container">
    			<div class="column box-wrapper is-offset-3 is-6">
                    <div class="line-reveal">
                        <h1 style="font-size: 84px; font-family: MrsGlows">{{$term->name}}</h1>
                        <svg id="box-line" width="100%" height="8px" viewBox="0 0 100 1">
                            <!-- Generator: Sketch 41.2 (35397) - http://www.bohemiancoding.com/sketch -->
                            <desc>Created with Sketch.</desc>
                            <defs></defs>
                            <path d="m0,0 L100,0" id="Line" stroke="#979797" stroke-width="1" stroke-linecap="square" fill="none"></path>
                        </svg>
                        <p>{{$term->description}}</p>
                    </div>
    			</div>
    		</div>
    	</div>
    </section>

	@if (isset($posts))
		@include ('post.partials.list')
	@endif
@stop
