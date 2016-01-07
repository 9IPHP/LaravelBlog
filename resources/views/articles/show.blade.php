@extends('layouts.articles')

@section('title')
    {{ $article->title }} - @parent
@stop

@section('keywords')@if($article->tags){!! implode(',', $article->tags->lists('name')->toArray()) !!} @else @parent @endif @stop

@section('description'){{ $article->excerpt }} @stop

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
        <hr>
        @if($article->comment_status)
            @if($currentUser)
                {!! Form::open(['url' => '/comment/store', 'id' => 'commentForm']) !!}
                    {!! Form::hidden('article_id', $article->id) !!}
                    <div class="form-group">
                        {!! Form::textarea('body', null, ['id' => 'commentBody','class' => 'form-control', 'placeholder' => '评论内容，支持Markdown语法', 'rows' => 3, 'data-autoresize']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('发布', ['id' => 'commentBtn', 'class' => 'btn btn-primary ']) !!}
                        <a href="javascript:;" class="showEmoji" tabindex="0" role="button"><i class="fa fa-smile-o pointer ml-5 pd-5"></i></a>
                    </div>
                {!! Form::close() !!}
                <div class="box markdown-reply" id="commentPreview">
                    <p class="text-center">评论预览区</p>
                </div>
            @else
                <div class="commentNoLogin">
                    <a href="/auth/login">登录</a>后才能进行评论
                </div>
            @endif
        @else
            <div class="alert alert-warning">
                文章已禁用评论
            </div>
        @endif
        <div class="comments" id="commentsLists">
            <h2 class="commentsTitle">
            @if($article->comment_count)
                本文共<span class="commentNum">{{ $article->comment_count }}</span>条评论
            @else
                暂无评论
            @endif
            </h2>
            <div id="commentsList">
                @foreach($comments as $comment)
                    @include('articles._comment')
                @endforeach
                {!! $comments->render() !!}
            </div>
        </div>
    </article>
@stop

@section('footer')
    @include('layouts.emoji')
    <script src="/js/zoom.js"></script>
    <script src="/js/highlight.pack.js"></script>
    <script src="/js/marked.js"></script>
    <script>
        $('pre code').each(function(i, block) {
            hljs.highlightBlock(block);
        });

    </script>
@stop