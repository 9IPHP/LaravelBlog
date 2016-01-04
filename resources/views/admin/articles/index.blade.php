@extends('admin.layout')

@section('page-header')
Articles Lists
<span class="pull-right page-opt">
    <form action="" method="get" class="pull-right">
        <div class="form-inline">
            <select name="orderby" class="form-control">
                <option value="created_at" @if($orderby == 'created_at') selected @endif>创建时间</option>
                <option value="view_count" @if($orderby == 'view_count') selected @endif>浏览量</option>
                <option value="like_count" @if($orderby == 'like_count') selected @endif>赞</option>
                <option value="comment_count" @if($orderby == 'comment_count') selected @endif>评论</option>
                <option value="collect_count" @if($orderby == 'collect_count') selected @endif>收藏</option>
            </select>
            <input type="text" name="title" id="title" class="form-control" placeholder="标题" value="{{ $title }}">
            <button class="btn btn-danger" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>
</span>
@stop

@section('content')
    <div class="col-lg-12">
    @if(count($articles))
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>标题</th>
                    <th>作者</th>
                    <th>发布日期</th>
                    <th>浏览量</th>
                    <th>赞数</th>
                    <th>评论数</th>
                    <th>收藏数</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                    <tr id="article-{{$article->id}}">
                        <td>{{ $article->id }}</td>
                        <td><a href="/article/{{$article->id}}" target="_blank">{{ $article->title }}</a></td>
                        <td><a href="/user/{{$article->user->id}}" target="_blank">{{ $article->user->name }}</a></td>
                        <td>{{ $article->created_at }}</td>
                        <td>{{ $article->view_count }}</td>
                        <td>{{ $article->like_count }}</td>
                        <td>{{ $article->comment_count }}</td>
                        <td>{{ $article->collect_count }}</td>
                        <td>
                            <div class="btn-group btn-group-xs" role="group">
                                <a href="/article/{{$article->id}}" target="_blank" class="btn btn-info" title="查看"><i class="fa fa-eye"></i></a>
                                <a href="/article/{{$article->id}}/edit" target="_blank" class="btn btn-primary" title="编辑"><i class="fa fa-edit"></i></a>
                                <button type="button" target="_blank" class="btn btn-danger" data-toggle="modal" data-target="#delArticleAdmin" data-title="{{ $article->title }}" data-id="{{ $article->id }}"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pull-right" id="page">
            {!! $articles->render() !!}
        </div>
        <div class="modal fade" id="delArticleAdmin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="">
                        {{-- <p>若只想在前台列表不显示，可以在“是否显示”处点击取消勾选，非选中状态下的文章将不会出现在前台列表中</p> --}}
                        <p class="text-danger text-center">确定要删除文章《<span class="deleteTitle"></span>》？</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="trashArticle()" data-dismiss="modal">Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger text-center">
            暂无文章
        </div>
    @endif
    </div>
@stop