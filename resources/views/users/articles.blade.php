@extends('layouts.users')

@section('title'){{$user->name}}的全部文章 - @parent @stop

@section('container')
    @include('users._rightnav')
    <div class="panel-body remove-pd-h">
        @if(count($articles))
            @if($currentUser && $currentUser->id == $user->id)
                <div class="alert alert-info text-center clearfix">
                    可以点击“评论”修改文章是否允许评论
                </div>
            @endif
            <ul class="list-group">
                @foreach($articles as $article)
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
                            <h4 class="modal-title" id="myModalLabel">删除文章</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" value="">
                            <p class="text-danger text-center">确认删除文章《<strong class="title"></strong>》？</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" onclick="delArticle()" data-dismiss="modal">Yes</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning text-center">
                暂无文章
            </div>
        @endif
    </div>
@stop

@section('footer')
    <script type="text/javascript">

    </script>
@stop