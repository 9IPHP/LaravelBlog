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
        @if(count($articles))
            @if($currentUser && $currentUser->id == $user->id)
                <div class="alert alert-info text-center clearfix">
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
        @else
            <div class="alert alert-warning text-center">
                暂无收藏
            </div>
        @endif
    </div>
@stop

@section('footer')
    <script type="text/javascript">

    </script>
@stop