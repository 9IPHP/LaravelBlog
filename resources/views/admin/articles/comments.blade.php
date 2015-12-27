@extends('admin.layout')

@section('page-header')
Comments Lists
<span class="pull-right page-opt">
    <div class="btn-group" role="group">
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#delAllComments">删除所选</button>
    </div>
</span>
@stop

@section('content')
    <div class="col-lg-12">
    @if(count($comments))
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th><span class="fa fa-check-square-o pointer" onclick="checkAll('delCommentId')"></span> / <span class="fa fa-square-o  pointer" onclick="unCheckAll('delCommentId')"></span></th>
                    <th>ID</th>
                    <th>内容</th>
                    <th>所属文章</th>
                    <th>用户名</th>
                    <th>发布日期</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($comments as $comment)
                    <tr id="comment-{{$comment->id}}">
                        <td><input type="checkbox" name="delCommentId[]" value="{{ $comment->id }}"></td>
                        <td>{{ $comment->id }}</td>
                        <td class="body text-left">{!! $comment->body !!}</td>
                        <td>@if($comment->article)<a href="/article/{{$comment->article_id}}" target="_blank">{{ $comment->article->title }}</a> @else <a href="/articles/view/{{$comment->article_id}}" target="_blank">文章已被删除</a> @endif</td>
                        <td><a href="/user/{{$comment->user->id}}" target="_blank">{{ $comment->user->name }}</a></td>
                        <td>{{ $comment->created_at }}</td>
                        <td>
                            <div class="btn-group btn-group-xs" role="group">
                                <a href="/article/{{$comment->article_id}}#comment-{{ $comment->id }}" target="_blank" class="btn btn-info" title="查看"><i class="fa fa-eye"></i></a>
                                <a href="/comment/{{$comment->id}}/edit" target="_blank" class="btn btn-primary" title="编辑"><i class="fa fa-edit"></i></a>
                                <button type="button" target="_blank" class="btn btn-danger" data-toggle="modal" data-target="#delCommentAdmin" data-id="{{ $comment->id }}"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pull-right" id="page">
            {!! $comments->render() !!}
        </div>
        <div class="modal fade" id="delCommentAdmin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">删除评论</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="">
                        <p class="text-danger text-center">确定要删除该评论？</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="delComment()" data-dismiss="modal">Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="delAllComments" tabindex="-1" role="dialog" aria-labelledby="ddelAllCommentsLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="ddelAllCommentsLabel">删除标签</h4>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger text-center delMsg">确认要所选标签删除？</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="delCheckedComments()" data-dismiss="modal">Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
@stop

@section('footer')
@stop