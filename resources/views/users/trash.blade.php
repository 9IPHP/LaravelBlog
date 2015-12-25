@extends('layouts.users')

@section('title'){{$user->name}}的回收站 - @parent @stop

@section('container')
    @include('users._rightnav')
    <div class="panel-body remove-pd-h">
        @if(count($articles))
            @if($currentUser && $currentUser->id == $user->id)
                <div class="alert alert-info text-center clearfix">
                    可以点击“是否显示”更改文章是否显示在前台列表中
                </div>
            @endif
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
                                <i class="fa fa-calendar"></i> {{ $article->deleted_at->diffForHumans() }}
                                @can('destroy', $article)
                                    <label class="opt" data-toggle="modal" data-target="#trashArticleUserCenter" data-title="{{ $article->title }}" data-id="{{ $article->id }}" data-action="restore"><i class="fa fa-recycle"></i> 恢复</label>
                                @endcan
                                @can('destroy', $article)
                                    <label class="opt text-danger" data-toggle="modal" data-target="#trashArticleUserCenter" data-title="{{ $article->title }}" data-id="{{ $article->id }}" data-action="forceDelete"><i class="fa fa-trash-o"></i> 彻底删除</label>
                                @endcan
                            </span>
                        </span>
                    </li>
                @endforeach
                {!! $articles->render() !!}
            </ul>
            <div class="modal fade" id="trashArticleUserCenter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" value="">
                            <input type="hidden" name="action" value="">
                            <p class="text-danger text-center noticeMsg"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger articleOptBtn" onclick="articleRestoreOrDelete()" data-dismiss="modal">Yes</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning text-center">
                @can('article.create')
                    暂无文章
                @else
                    该用户暂无权限发布文章
                @endcan
            </div>
        @endif
    </div>
@stop

@section('footer')
    <script type="text/javascript">

    </script>
@stop