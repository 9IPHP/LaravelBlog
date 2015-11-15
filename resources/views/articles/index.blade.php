@extends('articles.main')

@section('title')
    文章列表 - @parent
@stop

@section('site-heading')
    <div class="site-heading">
        <h1>Clean Blog</h1>
        <hr class="small">
        <span class="subheading">A Clean Blog Theme by Start Bootstrap</span>
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
                <p class="post-meta">Posted on {{ $article->created_at->format('Y-m-d') }}</p>
            </div>
            <hr>
        @endforeach
    @endif

    {!! $articles->render() !!}
@stop