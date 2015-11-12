@extends('articles.main')

@section('title')
    {{ $article->title }} - @parent
@stop

@section('bgimg')
    @if($article->thumb)
        {{ $article->thumb }}
    @else
        @parent
    @endif
@stop

@section('site-heading')
    <h1>{{ $article->title }}</h1>
    <span class="meta">Posted on {{ $article->created_at->format('Y-m-d') }}</span>
@stop

@section('container')
    {!! $article->body !!}
@stop