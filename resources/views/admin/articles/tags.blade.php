@extends('admin.layout')

@section('page-header')
Tags Lists
<span class="pull-right page-opt">
    <form action="" method="get" class="pull-right">
        <div class="form-inline">
            <select name="orderby" class="form-control">
                <option value="created_at" @if($orderby == 'created_at') selected @endif>创建时间</option>
                <option value="count" @if($orderby == 'count') selected @endif>文章个数</option>
            </select>
            <input type="text" name="s" id="s" class="form-control" placeholder="标签" value="">
            <button class="btn btn-danger" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>

    <div class="btn-group mr10" role="group">
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#delAllTags">删除所选</button>
    </div>
</span>
@stop

@section('content')
    <div class="col-lg-12">
    @if(count($tags))
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th><span class="fa fa-check-square-o pointer" onclick="checkAll('delTagId')"></span> / <span class="fa fa-square-o  pointer" onclick="unCheckAll('delTagId')"></span></th>
                    <th>ID</th>
                    <th>名称</th>
                    <th>Slug</th>
                    <th>首字母</th>
                    <th>文章个数</th>
                    <th>创建日期</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tags as $tag)
                    <tr id="tag-{{$tag->id}}">
                        <td><input type="checkbox" name="delTagId[]" value="{{ $tag->id }}"></td>
                        <td>{{ $tag->id }}</td>
                        <td><a href="/tag/{{$tag->slug}}" target="_blank" title="查看">{!! $tag->name !!}</a></td>
                        <td><a href="/tag/{{$tag->slug}}" target="_blank" title="查看">{!! $tag->slug !!}</a></td>
                        <td>{{ $tag->letter }}</td>
                        <td>{{ $tag->count }}</td>
                        <td>{{ $tag->created_at }}</td>
                        <td>
                            <div class="btn-group btn-group-xs" role="group">
                                <a href="/tag/{{$tag->slug}}" target="_blank" class="btn btn-info" title="查看"><i class="fa fa-eye"></i></a>
                                <button type="button" target="_blank" class="btn btn-danger" data-toggle="modal" data-target="#delTagAdmin" data-name="{{ $tag->name }}" data-id="{{ $tag->id }}"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pull-right" id="page">
            {!! $tags->render() !!}
        </div>
        <div class="modal fade" id="delTagAdmin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">删除标签</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="">
                        <p class="text-danger text-center">确定要删除标签《<span class="name"></span>》？</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="delTag()" data-dismiss="modal">Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="delAllTags" tabindex="-1" role="dialog" aria-labelledby="delAllTagsLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="delAllTagsLabel">删除标签</h4>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger text-center delMsg">确认要删除所选标签？</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="delCheckedTags()" data-dismiss="modal">Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
@stop
