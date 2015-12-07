@extends('layouts.users')

@section('title'){{$user->nickname}}的最新动态 - @parent @stop

@section('container')
    <ul class="nav nav-tabs nav-justified">
        <li role="presentation" class="active"><a href="/user/{{ $user->id }}">Home</a></li>
        <li role="presentation"><a href="/user/{{ $user->id }}/articles">文章</a></li>
        <li role="presentation"><a href="#">Messages</a></li>
    </ul>
    <div class="panel-body">

    </div>
@stop