@extends('layouts.users')

@section('title')修改密码 - @parent @stop

@section('container')
    {{-- <div class="panel panel-default"> --}}
        <div class="panel-body ">
            @include('flash::message')
            @include('errors.errlist')
            @if(isset($notmatch) && $notmatch)
                <div class="alert alert-danger">
                    <ul>
                        <li>{{ $notmatch }}</li>
                    </ul>
                </div>
            @endif
            <div class="alert alert-warning text-center">密码长度至少为6位数</a></div>

            {!! Form::open(['method' => 'PATCH', 'action' => ['UserController@updatepwd', $user->id], 'id' => 'resetPwdForm']) !!}

                <div class="form-group">
                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => '原始密码', 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::password('password_new', ['class' => 'form-control', 'placeholder' => '新密码', 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::password('password_new_confirmation', ['class' => 'form-control', 'placeholder' => '确认密码', 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::submit('保存', ['id' => 'resetPwdBtn', 'class' => 'btn btn-primary form-control']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    {{-- </div> --}}
@stop