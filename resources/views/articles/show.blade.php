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
    <div class="post-heading">
        <h1>{{ $article->title }}</h1>
        <span class="meta">Posted by <a href="/articles/user/{{ $article->user->id }}">{{ $article->user->name }}</a> on {{ $article->created_at->format('Y-m-d') }}</span>
    </div>
@stop

@section('container')
    @unless($article->tags->isEmpty())
        <div class="article-meta-tags">
            Tags:
            @foreach($article->tags as $tag)
                <a href="/tag/{{ $tag->slug }}">{{ $tag->name }}</a>
            @endforeach
        </div>
    @endunless
    <div class="article-body">
        {!! $article->body !!}
    </div>

@stop