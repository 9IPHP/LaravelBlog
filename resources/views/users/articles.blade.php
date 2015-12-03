@extends('layouts.users')

@section('title'){{$user->name}}的全部文章 - @parent @stop

@section('container')
    <ul class="nav nav-tabs nav-justified">
        <li role="presentation"><a href="/user/{{ $user->id }}">Home</a></li>
        <li role="presentation" class="active"><a href="/user/{{ $user->id }}/articles">文章</a></li>
        <li role="presentation"><a href="#">Messages</a></li>
    </ul>
    <div class="panel-body remove-pd-v remove-pd-h">
        <ul class="list-group">
            @foreach($articles as $article)
                <li class="list-group-item clearfix">
                    <a href="/article/{{ $article->slug }}">{{ $article->title }}</a>
                    <span class="user-articles-meta">
                        <i class="fa fa-calendar"></i> {{ $article->created_at->diffForHumans() }}
                        <span class="pull-right">
                            <i class="fa fa-eye"></i> {{ $article->view_count }}
                            <i class="fa fa-comments"></i> {{ $article->comment_count }}
                            <i class="fa fa-bookmark"></i> {{ $article->collect_count }}
                            <i class="fa fa-heart"></i> {{ $article->like_count }}

                        </span>
                    </span>
                </li>
            @endforeach
            {!! $articles->render() !!}
        </ul>
    </div>
@stop