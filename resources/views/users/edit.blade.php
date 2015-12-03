@extends('layouts.users')

@section('title')编辑个人资料 - @parent @stop

@section('container')
    @include('errors.errlist')
    <div class="alert alert-warning">本站头像使用 <a href="http://en.gravatar.com/" target="_blank">Gravatar 头像</a></div>

    {!! Form::model($user, ['method' => 'PATCH', 'action' => ['UserController@update', $user->id]]) !!}

        <div class="form-group">
            {!! Form::text('website', $user->website, ['class' => 'form-control', 'placeholder' => '网站']) !!}
        </div>
        <div class="form-group">
            {!! Form::text('weibo', $user->weibo, ['class' => 'form-control', 'placeholder' => '微博']) !!}
        </div>
        <div class="form-group">
            {!! Form::text('github', $user->github, ['class' => 'form-control', 'placeholder' => 'Github']) !!}
        </div>
        <div class="form-group">
            {!! Form::text('qq', $user->qq, ['class' => 'form-control', 'placeholder' => 'QQ']) !!}
        </div>
        <div class="form-group">
            {!! Form::textarea('description', $user->description, ['class' => 'form-control', 'rows' => 3, 'placeholder' => '个人简介']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('保存', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    {!! Form::close() !!}
@stop