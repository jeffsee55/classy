@extends('layout.default')

@section('content')

    <section class="hero is-medium category-hero">
    	<div class="hero-body">
    		<div class="container">
    			<div class="column box-wrapper is-offset-3 is-6">
                    <div class="box bottom">
                        <h1 style="font-size: 84px; font-family: MrsGlows">{{$term->name}}</h1>
                    </div>
                    <p>{{$term->description}}</p>
    			</div>
    		</div>
    	</div>
    </section>

	@if (isset($posts))
		@include ('post.partials.list')
	@endif
@stop
