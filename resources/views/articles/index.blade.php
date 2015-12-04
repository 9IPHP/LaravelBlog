@extends('layouts.articles')

@section('title')
    文章列表 - @parent
@stop

@section('site-heading')
    <div class="site-heading">
        <h1>Laravel博客</h1>
        <hr class="small">
        <span class="subheading">A Blog Created with Laravel</span>
    </div>
@stop

@section('container')
    @if(count($articles) > 0)
        @foreach($articles as $article)
            <div class="post-preview">
                <a href="/article/{{ $article->id }}">
                    <h2 class="post-title">
                        {{ $article->title }}
                    </h2>
                </a>
                <p class="post-excerpt">
                    {{ $article->excerpt }}
                </p>
                <p class="post-meta">@include('articles._meta')</p>
            </div>
            <hr>
        @endforeach
    @endif

    {!! $articles->render() !!}
@stop