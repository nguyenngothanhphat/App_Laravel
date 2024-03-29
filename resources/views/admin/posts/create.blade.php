@extends('layouts.admin')

@section('content')
@include('admin.includes.tinyeditor')
    <h1 class="h3 mb-4 text-gray-800 text-center">Create Posts</h1>
    {!! Form::open(['method' => 'POST', 'action' => 'AdminPostsController@store', 'files' => true]) !!}
        <div class="form-group">
            {!! Form::label('title', 'Title:') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('category_id', 'Category:') !!}
            {!! Form::select('category_id', ['' => 'Choose Options'] + $categories, null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('photo_id', 'Image:') !!}
            {!! Form::file('photo_id',['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('content', 'Description:') !!}
            {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => 3]) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Create Post', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
    @include('admin.includes.form_error')
@endsection