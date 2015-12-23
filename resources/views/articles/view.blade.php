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
        <span class="meta">
            <i class="fa fa-user"></i> <a href="/user/{{ $article->user->id }}">{{ $article->user->name }}</a>
            <i class="fa fa-eye"></i> {{ $article->view_count }} views
            <i class="fa fa-calendar"></i> {{ $article->created_at->diffForHumans() }}
        </span>
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
        <div class="article-footer-meta clearfix">
            <label class="text-heart" data-toggle="tooltip" title="点赞"><i class="fa fa-{{$currentUser && $article->likes()->byUser($currentUser->id)->count() ? 'thumbs-up' : 'thumbs-o-up'}}"></i> <span>{{$article->like_count}}</span></label>
            <a href="#commentsLists" data-toggle="tooltip" title="评论"><i class="fa fa-comment-o"></i> <span class="commentNum">{{$article->comment_count}}</span></a>
            <div class="pull-right">
                <label data-toggle="tooltip" title="收藏"><i class="fa fa-bookmark{{$currentUser && App\Collect::isCollect($currentUser, $article) ? '' : '-o'}}"></i> <span>{{$article->collect_count}}</span></label>
                <img title="{{ $article->user->name }}" data-toggle="tooltip" src="{{ getAvarar($article->user->email, 25) }}" class="avatar avatar-25 mt--4">
            </div>
        </div>
        <hr>
        @unless($article->comment_status)
            <div class="alert alert-warning">
                文章已禁用评论
            </div>
        @endunless
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
    <script src="/js/zoom.js"></script>
    <script src="/js/highlight.pack.js"></script>
    <script src="/js/marked.js"></script>
    <script>
        $('pre code').each(function(i, block) {
            hljs.highlightBlock(block);
        });

    </script>
@stop