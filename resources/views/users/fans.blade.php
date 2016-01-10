@extends('layouts.users')

@section('title'){{$user->name}}的粉丝 - @parent @stop

@section('container')
    @include('users._rightnav')
    <div class="panel-body remove-pd-h">
        @if(count($fans))
            <div class="alert alert-info text-center clearfix">
                @if($currentUser && $currentUser->id == $user->id) 我的粉丝 @else TA的粉丝 @endif
            </div>
            <div class="fan-list">
                @foreach($fans as $fan)
                    <div class="media col-md-4 col-sm-6 bb-15">
                        <div class="pull-left">
                            <a href="/user/{{ $fan->id }}" target="_blank">
                                <img src="{{ getAvarar($fan->email, 48) }}" class="media-object avatar avatar-48">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="/user/{{ $fan->id }}" target="_blank">{{ $fan->name }}</a></h4>
                            <div class="text-muted">加入时间：{{ $fan->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @endforeach
                {!! $fans->render() !!}
            </div>
        @else
            <div class="alert alert-warning text-center">
                暂无粉丝
            </div>
        @endif
    </div>
@stop

@section('footer')
    <script type="text/javascript">

    </script>
@stop