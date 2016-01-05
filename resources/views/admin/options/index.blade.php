@extends('admin.layout')

@section('page-header')
Options Lists
@stop

@section('content')
    <div class="col-lg-10 col-lg-offset-1">
        @include('flash::message')
        @if(count($options))
            <form action="{{ url('/admin/options/update') }}" method="POST" class="form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="PATCH">
                @foreach($options as $option)
                    <div class="form-group">
                        {!! Form::label($option->name, $option->label.'('.$option->name.')', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            @if($option->type == 'textarea')
                                {!! Form::textarea($option->name, $option->value, ['class' => 'form-control']) !!}
                            @else
                                {!! Form::text($option->name, $option->value, ['class' => 'form-control']) !!}
                            @endif
                        </div>
                    </div>
                @endforeach
                <div class="form-group">
                    {!! Form::submit('修改', ['class' => 'btn btn-primary form-control']) !!}
                </div>
            </form>
        @endif
    </div>
@stop