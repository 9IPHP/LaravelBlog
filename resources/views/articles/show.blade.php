@extends('articles.main')

@section('title')
    {{ $article->title }} - @parent
@stop

@section('head')
    <link href="/css/monokai_sublime.css" rel="stylesheet">
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
        <h1>{{ $article->title }}</h1>
        <hr class="small">
        <span class="meta"><i class="fa fa-user"></i> <a href="/articles/user/{{ $article->user->id }}">{{ $article->user->name }}</a> <i class="fa fa-calendar"></i> {{ $article->created_at->diffForHumans() }}@can('update', $article) <i class="fa fa-edit"></i> <a href="/article/{{ $article->slug }}/edit">Update</a> @endcan</span>
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

@section('footer')
    <script src="/js/zoom.js"></script>
    <script src="/js/highlight.pack.js"></script>
    <script>
        $('pre code').each(function(i, block) {
            hljs.highlightBlock(block);
        });
    </script>
@stop