@extends('layouts.articles')

@section('title')
    文章列表 - @parent
@stop

@section('site-heading')
    <div class="site-heading">
        <h1>由 {{ $user->name }} 发布的文章</h1>
    </div>
@stop

@section('container')

    @include('articles._preview')

@stop