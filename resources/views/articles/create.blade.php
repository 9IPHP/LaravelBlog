@extends('articles.main')

@section('title')
    发布文章 - @parent
@stop

@section('head')
    <link href="/css/simditor.css" rel="stylesheet">
    <link href="/css/dropzone.css" rel="stylesheet">
    <link href="/css/selectize.bootstrap3.css" rel="stylesheet" />
    <script src="/js/mobilecheck.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
    <script src="/js/module.js"></script>
    <script src="/js/hotkeys.js"></script>
    <script src="/js/uploader.js"></script>
    <script src="/js/simditor.js"></script>
    <script src="/js/marked.js"></script>
    <script src="/js/to-markdown.js"></script>
    <script src="/js/simditor-markdown.js"></script>
    <script src="/js/dropzone.js"></script>
    <script src="/js/selectize.min.js"></script>
@stop