@extends('layouts.users')

@section('title'){{$user->name}}的全部文章 - @parent @stop

@section('container')
    <ul class="nav nav-tabs nav-justified">
        <li role="presentation"><a href="/user/{{ $user->id }}">Home</a></li>
        <li role="presentation" class="active"><a href="/user/{{ $user->id }}/articles">文章</a></li>
        <li role="presentation"><a href="#">Messages</a></li>
    </ul>
    <div class="panel-body remove-pd-v remove-pd-h">
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
                        <i class="fa fa-calendar"></i> {{ $article->created_at->diffForHumans() }}
                        <span class="pull-right">
                            <i class="fa fa-eye"></i> {{ $article->view_count }}
                            <i class="fa fa-comments"></i> {{ $article->comment_count }}
                            <i class="fa fa-bookmark"></i> {{ $article->collect_count }}
                            <i class="fa fa-heart"></i> {{ $article->like_count }}
                            @can('active', $article)<label class="article-opt publish"><i class="fa fa-{{$isActive}}"></i> 是否显示</label>
                            <label class="article-opt comment"><i class="fa fa-{{$commentStatus}}"></i> 开启评论</label>
                            @endcan
                            @can('update', $article)
                                <i class="fa fa-edit"></i> <a href="/article/{{ $article->id }}/edit" target="_blank">Edit</a>
                            @endcan
                        </span>
                    </span>
                </li>
            @endforeach
            {!! $articles->render() !!}
        </ul>
    </div>
@stop

@section('footer')
    <script type="text/javascript">

    </script>
@stop