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

        @if($article->comment_status)
            @if($currentUser)
                {!! Form::open(['url' => '/comment/store', 'id' => 'commentForm']) !!}
                    {!! Form::hidden('article_id', $article->id) !!}
                    <div class="form-group">
                        {!! Form::textarea('body', null, ['id' => 'commentBody','class' => 'form-control', 'placeholder' => '评论内容，支持Markdown语法', 'rows' => 3]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('发布', ['id' => 'commentBtn', 'class' => 'btn btn-primary form-control']) !!}
                    </div>
                {!! Form::close() !!}
                <div class="box markdown-reply" id="commentPreview"></div>
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
        <div class="comments">
            <h2 class="commentsTitle">
            @if($article->comment_count)
                本文共<span class="commentNum">{{ $article->comment_count }}</span>条回复
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
        $(document).on('submit', '#commentForm', function(event) {
            event.preventDefault();
            var article_id = $('#commentForm [name="article_id"]').val(),
                body = $('#commentForm [name="body"]').val(),
                $commentNum = $('.commentNum'),
                commentNumber = parseInt($commentNum.eq(0).text()),
                $submit = $('#commentBtn');
            if(body == '') {
                AlertMsg('评论内容不能为空', 'Alert--Danger');
                return;
            }
            $submit.attr('disabled', true).fadeTo('slow', 0.5);
            $.ajax({
                url: '/comment/store',
                type: 'POST',
                dataType: 'json',
                data: {
                    article_id: article_id,
                    body: body
                },
                success: function(response){
                    if (response.status == 200) {
                        $('#commentForm [name="body"]').val('');
                        $("#commentPreview").html('');
                        $('#commentsList').prepend(marked(response.html))
                        $commentNum.text(commentNumber + 1);
                        $('#commentsList pre code').each(function(i, block) {
                            hljs.highlightBlock(block);
                        });
                        $body.animate( { scrollTop: $('#commentsList').offset().top - 10}, 900);
                        AlertMsg(response.msg);
                    }else{
                        AlertMsg(response.msg, 'Alert--Danger');
                    }
                    $submit.attr('disabled', false).fadeTo('slow', 1);
                },
                error: function(response){
                    if (response.status == 401)
                        AlertMsg('请先登录', 'Alert--Danger');
                    $submit.attr('disabled', false).fadeTo('slow', 1);
                }
            });
        });
        $(document).on('click', '#commentsList .pager a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1],
                article_id = $('.article').data('id');
            getArticleComment(article_id, page);
        });

        function getArticleComment (article_id, page) {
            $.ajax({
                url: '/comment/get',
                type: 'GET',
                dataType: 'json',
                data: {
                    article_id: article_id,
                    page: page
                },
                success: function(response){
                    if (response.status == 200) {
                        $('#commentsList').html(response.html);
                        $('#commentsList pre code').each(function(i, block) {
                            hljs.highlightBlock(block);
                        });
                        $body.animate( { scrollTop: $('#commentsList').offset().top - 70}, 900);
                    }else{
                        AlertMsg(response.msg, 'Alert--Danger');
                    }
                },
                error: function(response){
                }
            });
        }

        $("#commentBody").bind('blur keyup',  function(event) {
            var source = $(this).val();
            var mark = marked(source);
            $("#commentPreview").html(mark);
            $('#commentPreview pre code').each(function(i, block) {
                hljs.highlightBlock(block);
            });
        });
        $(document).on('propertychange', function(e){
            var source = $(this).val();
            var mark = marked(source);
            $("#commentPreview").html(mark);
            $('#commentPreview pre code').each(function(i, block) {
                hljs.highlightBlock(block);
            });
        })
    </script>
@stop