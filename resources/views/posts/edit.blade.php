@extends('layouts.app')

@section('content')
    <h1 style="padding: 0 20px; margin-right: 5px;">Edit Post</h1>
    {!! Form::open(['action' => ['PostsController@update', $post->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>
        <div class="form-group">
            {{Form::label('kategori', 'Category :')}}
            {{Form::select('kategori', ['Politic' => 'Politic', 'Economy' => 'Economy', 'Sport' => 'Sport', 'Social'=> 'Social', 'Culture' => 'Culture', 'Sains&Technology' => 'Sains&Technology', 'Religious' => 'Religious', 'General' => 'General'], 'General')}}
        </div>
        <div class="form-group">
            {{Form::label('body', 'Body')}}
            {{Form::textarea('body', $post->body, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body Text'])}}
        </div>
        <div class="form-group">
            {{Form::file('cover_image')}}
        </div>
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection