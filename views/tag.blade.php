@extends('layout.default')

@section('content')

    <section class="hero is-medium">
    	<div class="hero-body">
    		<div class="container">
    			<div class="column is-half">
                    <h1>{{$term->name}}</h1>
                    <p>{{$term->description}}</p>
    			</div>
    		</div>
    	</div>
    </section>

	@if (isset($posts))
		@include ('post.partials.list')
	@endif
@stop
