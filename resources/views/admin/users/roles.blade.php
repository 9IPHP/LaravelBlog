@extends('admin.layout')

@section('page-header')
Roles Lists
@stop

@section('content')
    <div class="col-lg-12">
    @if(count($roles))
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>用户组名</th>
                    <th>Slug</th>
                    <th>描述</th>
                    <th>权限</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr id="role-{{ $role->id }}">
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->slug }}</td>
                        <td>{{ $role->description }}</td>
                        <td>
                            @if(count($role->permissions))
                                @foreach($role->permissions as $p)
                                    {{ $p->name  }}<br/>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-xs" role="group">
                                <a href="/admin/users/roles/{{$role->id}}/edit" class="btn btn-primary" title="修改权限"><i class="fa fa-edit"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    </div>
@stop