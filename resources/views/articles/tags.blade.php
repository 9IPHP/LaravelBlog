@extends('layouts.articles')

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
        @foreach($tagLists as $key => $tags)
            <h2>{{ $key }}</h2>
            <hr/>
            @foreach($tags as $tag)
                <a href="/tag/{{ $tag->slug }}">{{ $tag->name }} <sup>({{ $tag->count }})</sup></a>
            @endforeach
        @endforeach
    </div>
@stop