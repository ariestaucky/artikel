@extends('layouts.app')

@section('content')
<div style="width: 65%;">
    <h1 style="padding: 0 20px; margin-right: 5px;">Create Post</h1>
    {!! Form::open(['action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>
        <div class="form-group">
            {{Form::select('kategori', ['Politic' => 'Politic', 'Economy' => 'Economy', 'Sport' => 'Sport', 'Social'=> 'Social', 'Culture' => 'Culture', 'Sains&Technology' => 'Sains&Technology', 'Religious' => 'Religious', 'General' => 'General'], 'General')}}
        </div>
        <div class="form-group">
            {{Form::label('body', 'Posts')}}
            {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Your posts'])}}
        </div>
        <div class="form-group">
            {{Form::file('cover_image')}}
        </div>
        <div>
            {{Form::submit('Submit', ['class' => 'btn btn-primary', 'style' => 'width: 100px; border-radius: inherit;'])}}
        </div>
    {!! Form::close() !!}
</div>
@endsection