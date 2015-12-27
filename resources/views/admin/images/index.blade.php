@extends('admin.layout')

@section('page-header')
Images Lists
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
    @if(count($images))
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>图片名称</th>
                    <th>所属用户</th>
                    <th>创建日期</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($images as $image)
                {{-- {{ dd($image->id) }} --}}
                    <tr id="image-{{ $image->id }}" data-id="{{ $image->id }}">
                        <td>{{ $image->id }}</td>
                        <td class="name"><a href="/uploads/{{ $image->user_id }}/{{ $image->created_at->format('Ym') }}/{{$image->name}}" target="_blank">{{ $image->name }}</a></td>
                        <td><a href="/user/{{$image->user->id}}" target="_blank">{{ $image->user->name }}</a></td>
                        <td>{{ $image->created_at }}</td>
                        <td>
                            <div class="btn-group btn-group-xs" role="group">
                                <a href="/uploads/{{ $image->user_id }}/{{ $image->created_at->format('Ym') }}/{{$image->name}}" target="_blank" class="btn btn-info" title="查看"><i class="fa fa-eye"></i></a>
                                <button type="button" target="_blank" class="btn btn-danger" data-toggle="modal" data-target="#delimageAdmin" data-title="{{ $image->title }}" data-id="{{ $image->id }}" data-name="{{ $image->name }}"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pull-right" id="page">
            {!! $images->render() !!}
        </div>
        <div class="modal fade" id="updateRole" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">权限修改</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="image_id" value="">
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
        <div class="modal fade" id="delimageAdmin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">删除用户</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="">
                        <p class="text-danger text-center">确定要删除用户”<strong class="deleteimage"></strong>“？</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="delimage()" data-dismiss="modal">Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
@stop