@extends('admin.layout')

@section('page-header')
Users Lists
<span class="pull-right page-opt">
    <form action="" method="get" class="pull-right">
        <div class="form-inline">
            <input type="text" name="s" id="s" class="form-control" placeholder="用户ID/昵称/标签" value="">
            <button class="btn btn-danger" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>
</span>
@stop

@section('content')
    <div class="col-lg-12">
    @if(count($users))
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>用户名</th>
                    <th>邮箱</th>
                    <th>微博</th>
                    <th>QQ</th>
                    <th>网站</th>
                    <th>Github</th>
                    <th>用户组</th>
                    <th>创建日期</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr id="user-{{ $user->id }}" data-id="{{ $user->id }}">
                        <td>{{ $user->id }}</td>
                        <td class="name"><a href="/user/{{$user->id}}" target="_blank">{{ $user->name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->weibo }}</td>
                        <td>{{ $user->qq }}</td>
                        <td>{{ $user->website }}</td>
                        <td>{{ $user->github }}</td>
                        <td class="role">
                            @if($user->id == 1)
                                {{ $user->roles[0]->name }}
                            @else
                                <form>
                                    <select class="userRole" data-id="{{ $user->roles[0]->id }}" name="userRole" class="form-control">
                                        @foreach($roles as $role)
                                            <option id="role-{{ $role->id }}" value="{{ $role->id }}" @if($user->roles[0]->id == $role->id) selected @endif>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="reset" class="hidden">
                                    <i class="fa fa-spin fa-refresh hidden"></i>
                                </form>
                            @endif
                        </td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            <div class="btn-group btn-group-xs" role="group">
                                <a href="/user/{{$user->id}}" target="_blank" class="btn btn-info" title="查看"><i class="fa fa-eye"></i></a>
                                <a href="/user/{{$user->id}}/edit" target="_blank" class="btn btn-primary" title="编辑"><i class="fa fa-edit"></i></a>
                                @if($user->id != 1)
                                    <button type="button" target="_blank" class="btn btn-danger" data-toggle="modal" data-target="#delUserAdmin" data-title="{{ $user->title }}" data-id="{{ $user->id }}" data-name="{{ $user->name }}"><i class="fa fa-trash"></i></button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pull-right" id="page">
            {!! $users->render() !!}
        </div>
        <div class="modal fade" id="updateRole" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">权限修改</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="user_id" value="">
                        <input type="hidden" name="role_id" value="">
                        <p class="text-danger text-center">确定要把用户“<strong class="name"></strong>”的角色修改为【<span class="role"></span>】？</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="updateRole()" data-dismiss="modal">Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="delUserAdmin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">删除用户</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="">
                        <p class="text-danger text-center">确定要删除用户“<strong class="deleteUser"></strong>”？</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="delUser()" data-dismiss="modal">Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
@stop