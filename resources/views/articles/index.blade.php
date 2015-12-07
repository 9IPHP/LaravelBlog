@extends('layouts.articles')

@section('title')
    文章列表 - @parent
@stop

@section('site-heading')
    <div class="site-heading">
        <h1>Laravel博客</h1>
        <hr class="small">
        <span class="subheading">A Blog Created with Laravel</span>
    </div>
@stop

@section('container')

    @include('articles._preview')

@stop