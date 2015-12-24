@extends('admin.layout')

@section('page-header')
Roles Lists
@stop

@section('content')
    <div class="col-lg-4 col-lg-offset-4">
        @include('flash::message')
        <h2>修改 "{{ $role->name }}" 的权限</h2>
        <div class="row">
            <form action="{{ action('Admin\UserController@updateRole', $role->id) }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="PATCH">
                @foreach($permissions as $p)
                    <div class="col-md-6">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="permission_id[]" value="{{ $p->id }}"
                                    @foreach($role->permissions as $per)
                                        @if($per->id == $p->id) checked @endif
                                    @endforeach
                                >
                                {{ $p->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
                <div class="col-md-12">
                    <button class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@stop