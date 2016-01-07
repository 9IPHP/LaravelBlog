@extends('layouts.users')

@section('title'){{$user->name}}的关注 - @parent @stop

@section('container')
    @include('users._rightnav')
    <div class="panel-body remove-pd-h">
        @if(count($follows))
            @if($currentUser && $currentUser->id == $user->id)
                <div class="alert alert-info text-center clearfix">
                    TA的关注
                </div>
            @endif
            <div class="follow-list">
                @foreach($follows as $follow)
                    <div class="media col-md-4 col-sm-6 bb-15">
                        <div class="pull-left">
                            <a href="/user/{{ $follow->id }}" target="_blank">
                                <img src="{{ getAvarar($follow->email, 48) }}" class="media-object avatar avatar-48">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="/user/{{ $follow->id }}" target="_blank">{{ $follow->name }}</a></h4>
                            <div class="text-muted">加入时间：{{ $follow->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @endforeach
                {!! $follows->render() !!}
            </div>
        @else
            <div class="alert alert-warning text-center">
                暂无关注
            </div>
        @endif
    </div>
@stop

@section('footer')
    <script type="text/javascript">

    </script>
@stop