@extends('articles.main')

@section('title')
    标签页 - @parent
@stop

@section('site-heading')
    <div class="site-heading">
        <h1>标签页</h1>
    </div>
@stop

@section('container')
    <div class="tags-body">
        @foreach($tags as $tag)
            <a href="/tag/{{ $tag->slug }}">{{ $tag->name }}</a>
        @endforeach
    </div>
@stop