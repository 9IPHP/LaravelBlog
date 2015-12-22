@extends('layouts.users')

@section('title'){{$user->name}}的最新动态 - @parent @stop

@section('container')
    <ul class="nav nav-tabs nav-justified">
        <li role="presentation" class="active"><a href="/user/{{ $user->id }}">Home</a></li>
        <li role="presentation"><a href="/user/{{ $user->id }}/articles">文章</a></li>
        <li role="presentation"><a href="/user/{{ $user->id }}/collects">收藏</a></li>
        <li role="presentation"><a href="#">Messages</a></li>
    </ul>
    <div class="panel-body remove-pd-h">
        @if(count($histories))
            <div class="alert alert-info text-center clearfix">
                用户动态
            </div>
            <ul class="list-group">
                @foreach($histories as $history)
                    <li class="list-group-item clearfix history todel" data-id="{{ $history->id }}">
                        <i class="fa @if($history->type == 'article') fa-file-o @elseif($history->type == 'comment') fa-comment-o @elseif($history->type == 'like') fa-thumbs-o-up @elseif($history->type == 'collect') fa-bookmark-o @endif"></i> {!! $history->content !!}
                        <span class="pull-right">
                            <i class="fa fa-calendar"></i> {{ $history->created_at->diffForHumans() }}
                        </span>
                    </li>
                @endforeach
                {!! $histories->render() !!}
            </ul>
        @else
            <div class="alert alert-warning text-center">
                暂无动态
            </div>
        @endif
    </div>
@stop