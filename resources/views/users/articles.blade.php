@extends('layouts.users')

@section('title'){{$user->name}}的全部文章 - @parent @stop

@section('container')
    <ul class="nav nav-tabs nav-justified">
        <li role="presentation"><a href="/user/{{ $user->id }}">Home</a></li>
        <li role="presentation" class="active"><a href="/user/{{ $user->id }}/articles">文章</a></li>
        <li role="presentation"><a href="/user/{{ $user->id }}/collects">收藏</a></li>
        <li role="presentation"><a href="#">Messages</a></li>
    </ul>
    <div class="panel-body remove-pd-h">
        <div class="alert alert-info  clearfix">
            可以点击“是否显示”更改文章是否显示在前台列表中
        </div>
        <ul class="list-group">
            @foreach($articles as $article)
                @if($article->is_active) {{-- */$isActive='check-square-o';/* --}}
                @else {{-- */$isActive='square-o';/* --}}
                @endif
                @if($article->comment_status) {{-- */$commentStatus='check-square-o';/* --}}
                @else {{-- */$commentStatus='square-o';/* --}}
                @endif
                <li class="list-group-item clearfix article" data-id="{{ $article->id }}">
                    <a href="/article/{{ $article->id }}">{{ $article->title }}</a>
                    <span class="user-articles-meta">
                        <span class="pull-right">
                            <i class="fa fa-calendar"></i> {{ $article->created_at->diffForHumans() }}
                            <i class="fa fa-eye"></i> {{ $article->view_count }}
                            <i class="fa fa-comments"></i> {{ $article->comment_count }}
                            <i class="fa fa-bookmark"></i> {{ $article->collect_count }}
                            <i class="fa fa-heart"></i> {{ $article->like_count }}
                            @can('active', $article)
                                <label class="opt article-opt publish"><i class="fa fa-{{$isActive}}"></i> 显示</label>
                                <label class="opt article-opt comment"><i class="fa fa-{{$commentStatus}}"></i> 评论</label>
                            @endcan
                            @can('update', $article)
                                <i class="fa fa-edit"></i> <a href="/article/{{ $article->id }}/edit" target="_blank">Edit</a>
                            @endcan
                            @can('destroy', $article)
                                <label class="opt article-del" data-toggle="modal" data-target="#delArticleUserCenter" data-title="{{ $article->title }}" data-id="{{ $article->id }}"><i class="fa fa-trash-o"></i> Delete</label>
                            @endcan
                        </span>
                    </span>
                </li>
            @endforeach
            {!! $articles->render() !!}
        </ul>
        <div class="modal fade" id="delArticleUserCenter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="">
                        {{-- <p>若只想在前台列表不显示，可以在“是否显示”处点击取消勾选，非选中状态下的文章将不会出现在前台列表中</p> --}}
                        <p class="text-danger text-center">删除后不可恢复，确认删除？</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="delArticle()">Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    <script type="text/javascript">

    </script>
@stop