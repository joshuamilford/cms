@extends('app')

@section('content')
<div class="container">
	<h1>{{ $page->title }}</h1>
	{!! $page->body !!}
</div>
@stop