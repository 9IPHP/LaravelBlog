@extends('admin.layout')

@section('page-header')
Images Lists
<span class="pull-right page-opt">
    <div class="btn-group" role="group">
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#delAllImages">删除所选</button>
    </div>
</span>
@stop

@section('content')
    <div class="col-lg-12">
    @if(count($images))
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th><span class="fa fa-check-square-o pointer" onclick="checkAll('delImageId')"></span> / <span class="fa fa-square-o  pointer" onclick="unCheckAll('delImageId')"></span></th>
                    <th>ID</th>
                    <th>图片</th>
                    {{-- <th>图片名称</th> --}}
                    <th>原始名称</th>
                    <th>所属用户</th>
                    <th>创建日期</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($images as $image)
                {{-- {{ dd($image->id) }} --}}
                    <tr id="image-{{ $image->id }}" data-id="{{ $image->id }}">
                        <td><input type="checkbox" name="delImageId[]" value="{{ $image->id }}"></td>
                        <td>{{ $image->id }}</td>
                        <td><img class="pointer" src="{{ getThumb($image->url, 'xs') }}" data-toggle="modal" data-target="#showImageAdmin" data-url="{{ $image->url }}"></td>
                        {{-- <td class="name"><a href="javascript:;" data-toggle="modal" data-target="#showImageAdmin" data-url="{{ $image->url }}">{{ $image->name }}</a></td> --}}
                        <td>{{ $image->alt }}</td>
                        <td><a href="/user/{{$image->user->id}}" target="_blank">{{ $image->user->name }}</a></td>
                        <td>{{ $image->created_at }}</td>
                        <td>
                            <div class="btn-group btn-group-xs" role="group">
                                <a href="{{ $image->url }}" target="_blank" class="btn btn-info" title="查看"><i class="fa fa-eye"></i></a>
                                <button type="button" target="_blank" class="btn btn-danger" data-toggle="modal" data-target="#delImageAdmin" data-id="{{ $image->id }}" data-name="{{ $image->name }}" data-url="{{ getThumb($image->url, 'xs') }}"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pull-right" id="page">
            {!! $images->render() !!}
        </div>

        <div class="modal fade" id="delImageAdmin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">删除图片</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="">
                        <p class="text-danger text-center">确定要删除图片“<strong class="image"></strong>”？</p>
                        <p class="text-center"><img id="url"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="delImage()" data-dismiss="modal">Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="delAllImages" tabindex="-1" role="dialog" aria-labelledby="delAllImagesLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="delAllImagesLabel">删除图片</h4>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger text-center delMsg">确认要删除所选图片？</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="delCheckedImages()" data-dismiss="modal">Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="showImageAdmin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <img src="">
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
@stop