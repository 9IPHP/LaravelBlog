@extends('layouts.articles')

@section('title')
    用户列表 - @parent
@stop

@section('bgimg')img/about-bg.jpg @stop

@section('site-heading')
    <div class="site-heading">
        <h1>用户列表</h1>
    </div>
@stop

@section('container')
    <div class="row user-body">
        @foreach($users as $user)
            <div class="col-md-2 col-xs-3 avatar-area">
                <a href="/user/{{ $user->id }}" data-toggle="tooltip" title="{{ $user->name }}">
                    <img class="img-circle img-thumbnail" src="{{ getAvarar($user->email, 60) }}">
                </a>
            </div>
        @endforeach
    </div>
@stop