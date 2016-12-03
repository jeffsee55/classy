@extends('layout.default')

@section('content')
	@if (isset($posts))
		@include ('post.partials.list')
	@endif
@stop
