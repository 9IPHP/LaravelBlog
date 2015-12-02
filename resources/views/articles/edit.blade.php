@extends('articles.main')

@section('title')
    修改文章 - @parent
@stop

@section('head')
    <link href="/css/simditor.css" rel="stylesheet">
    <link href="/css/dropzone.css" rel="stylesheet">
    <link href="/css/selectize.bootstrap3.css" rel="stylesheet" />
    <script src="/js/mobilecheck.js"></script>
@stop

@section('bgimg')
    @if($article->thumb)
        {{ $article->thumb }}
    @else
        @parent
    @endif
@stop

@section('site-heading')
    <div class="site-heading">
        <h1>修改文章</h1>
        <hr class="small">
        <span class="subheading">{{ $article->title }}</span>
    </div>
@stop

@section('container')
    @include('errors.errlist')

    @include('articles._upload')

    {!! Form::model($article, ['method' => 'PATCH', 'action' => ['ArticleController@update', $article->slug]]) !!}

        @include('articles._form')

    {!! Form::close() !!}
@stop

@section('footer')
    @include('articles._editor')
@stop