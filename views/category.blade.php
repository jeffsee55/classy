@extends('layout.default')

@section('content')

    <section class="hero is-medium category-hero">
    	<div class="hero-body">
            <div class="box bottom">
                <h1>{{$term->name}}</h1>
            </div>
            <div class="category-description">
                <div class="category-description-wrapper">
                    {{$term->description()}}
                <div>
            </div>
		</div>
    </section>

	@if (isset($posts))
		@include ('post.partials.list')
	@endif
@stop
