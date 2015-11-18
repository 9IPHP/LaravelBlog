@extends('articles.main')

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
                <a href="/article/{{ $article->slug }}">
                    <h2 class="post-title">
                        {{ $article->title }}
                    </h2>
                </a>
                <p class="post-excerpt">
                    {{ $article->excerpt }}
                </p>
                <p class="post-meta">Posted by <a href="/articles/user/{{ $article->user->id }}">{{ $article->user->name }}</a> on {{ $article->created_at->diffForHumans() }}</p>
            </div>
            <hr>
        @endforeach
    @endif

    {!! $articles->render() !!}
@stop