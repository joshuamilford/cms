@extends('app')

@section('content')

<div class="container">
<h1>Edit a Page</h1>

@if($errors->any())
<div class="alert alert-danger">
	<ul>
		@foreach($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif

{!! Form::model($page, ['action' => ['PagesController@update', $page->id], 'method' => 'PATCH']) !!}
<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
	{!! Form::label('title', 'Title', ['class' => 'control-label']) !!}
	{!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
	{!! Form::label('slug', 'Slug', ['class' => 'control-label']) !!}
	{!! Form::text('slug', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
	{!! Form::label('body', 'Body', ['class' => 'control-label']) !!}
	{!! Form::textarea('body', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
	{!! Form::label('parent_id', 'Parent', ['class' => 'control-label']) !!}
	{!! Form::select('parent_id', $parents, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group {{ $errors->has('tags') ? 'has-error' : '' }}">
	{!! Form::label('tags', 'Tags', ['class' => 'control-label']) !!}
	{!! Form::text('tags', $tags, ['class' => 'form-control']) !!}
</div>

{!! Form::submit('Save', ['class' => 'btn btn-primary btn-block']) !!}

{!! Form::close() !!}

</div>

@stop