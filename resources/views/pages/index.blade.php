@extends('app')

@section('content')

<div class="container">
<h1>All Pages</h1>
<p><a href="{{ url('/pages/create') }}" class="btn btn-primary">Add a Page</a></p>
@if(!empty($pages))
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<td>ID</td>
			<td>Title</td>
			<td>Slug</td>
			<td></td>
		</tr>
	</thead>
	<tbody>
		@foreach($pages as $page)
		<tr>
			<td>{{ $page->id }}</td>
			<td>{{ $page->title }}</td>
			<td>{{ $page->slug }}</td>
			<td><a href="{{ url('/pages/' . $page->id . '/edit') }}" class="btn btn-primary">Edit</a></td>
		</tr>
		@endforeach
	</tbody>
</table>
@endif
</div>

@stop