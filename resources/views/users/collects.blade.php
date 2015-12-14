@extends('layouts.users')

@section('title'){{$user->name}}收藏的全部文章 - @parent @stop

@section('container')
    <ul class="nav nav-tabs nav-justified">
        <li role="presentation"><a href="/user/{{ $user->id }}">Home</a></li>
        <li role="presentation"><a href="/user/{{ $user->id }}/articles">文章</a></li>
        <li role="presentation" class="active"><a href="/user/{{ $user->id }}/collects">收藏</a></li>
        <li role="presentation"><a href="#">Messages</a></li>
    </ul>
    <div class="panel-body remove-pd-h">
        @if($currentUser && $currentUser->id == $user->id)
            <div class="alert alert-info  clearfix">
                可以点击列表中的书签符号（<i class="fa fa-bookmark"></i>）可以取消收藏
            </div>
        @endif
        <ul class="list-group">
            @foreach($articles as $article)
                <li class="list-group-item clearfix article todel" data-id="{{ $article->id }}">
                    <a href="/article/{{ $article->id }}">{{ $article->title }}</a>
                    <span class="user-articles-meta">
                        <span class="pull-right">
                            <i class="fa fa-calendar"></i> {{ $article->created_at->diffForHumans() }}
                            @if($currentUser && $currentUser->id == $user->id)
                                <label class="js-action js-delete" data-action="Collect"><i class="fa fa-bookmark"></i> <span>{{ $article->collect_count }}</span></label>
                            @endif
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