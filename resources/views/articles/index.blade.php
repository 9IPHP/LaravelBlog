@extends('layouts.articles')

@section('title')
    文章列表 - @parent
@stop

@section('site-heading')
    <div class="site-heading">
        <h1>{{ get_option('sitename') }}</h1>
        <hr class="small">
        <span class="subheading">{{ get_option('sitedesc') }}</span>
    </div>
@stop

@section('container')

    @include('articles._preview')

@stop