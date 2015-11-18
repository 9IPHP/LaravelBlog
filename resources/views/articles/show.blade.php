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