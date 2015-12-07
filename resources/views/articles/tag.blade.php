@extends('layouts.articles')

@section('title')
    文章列表 - @parent
@stop

@section('site-heading')
    <div class="site-heading">
        <h1>标签 [{{ $tag->name }}] 下的所有文章</h1>
    </div>
@stop

@section('container')

    @include('articles._preview')

@stop