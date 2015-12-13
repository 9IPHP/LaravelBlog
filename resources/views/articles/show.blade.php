@extends('layouts.articles')

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
        <span class="meta">@include('articles._meta')</span>
    </div>
@stop

@section('container')
    <article class="article" data-id="{{ $article->id }}">
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
        @include('articles._footer_meta')

        {!! Form::open(['url' => '/comment/'.$article->id.'/store']) !!}
            <div class="form-group">
                {!! Form::textarea('body', null, ['class' => 'form-control', 'placeholder' => '评论内容', 'rows' => 3]) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('发布', ['class' => 'btn btn-primary form-control']) !!}
            </div>
        {!! Form::close() !!}
    </article>
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