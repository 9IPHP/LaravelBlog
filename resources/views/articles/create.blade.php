@extends('layouts.articles')

@section('title')
    发布文章 - @parent
@stop

@section('head')
    <link href="/css/simditor.css" rel="stylesheet">
    <link href="/css/dropzone.css" rel="stylesheet">
    <link href="/css/selectize.bootstrap3.css" rel="stylesheet" />
    <script src="/js/mobilecheck.js"></script>
@stop

@section('site-heading')
    <div class="site-heading">
        <h1>发布文章</h1>
    </div>
@stop

@section('container')
    @include('errors.errlist')

    @include('articles._upload')

    {!! Form::open(['url' => '/article', 'id' => 'create-article']) !!}

        @include('articles._form')

    {!! Form::close() !!}
@stop

@section('footer')
    @include('articles._editor')
@stop