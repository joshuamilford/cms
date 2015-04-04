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
			<td>Tags</td>
			<td></td>
		</tr>
	</thead>
	<tbody>
		@foreach($pages as $page)
		<tr>
			<td>{{ $page->id }}</td>
			<td>{{ $page->title }}</td>
			<td>{{ $page->slug }}</td>
			<td>
				@foreach($page->tags as $count=>$tag)
				{{ $tag->name . ($count + 1 < count($page->tags) ? ', ' : '') }}
				@endforeach
			</td>
			<td>
				<a href="{{ url('/pages/' . $page->id . '/edit') }}" class="btn btn-primary">Edit</a>
				{!! Form::open(['url' => '/pages/' . $page->id, 'method' => 'DELETE', 'style' => 'display:inline;']) !!}
				{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
				{!! Form::close() !!}
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endif
</div>

@stop