@extends('layouts.app')

@section('page-header')
    @lang('global.permissions.title') <small>{{ trans('app.add_new_item') }}</small>
@endsection

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box page-title-box-alt">
                <h4 class="page-title">{{ trans('Permission') }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                <a class="float-left" href="{{ route('setting.permissions.index') }}"><i class="fe-arrow-left mR-10"></i> {{ trans('global.btn_back')}} </a>
                <hr class="mB-30">
    
                {!! Form::model($permission, ['method' => 'PUT', 'route' => ['setting.permissions.update', $permission->id]]) !!}


                        <div class="form-group">
                            {!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
                            {!! Form::text('name', old('title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('name'))
                                <p class="help-block">
                                    {{ $errors->first('name') }}
                                </p>
                            @endif
                        </div>
                        

                    <a href="{{ route('setting.permissions.index') }}" class="btn btn-light float-end mr-2 ">{{ trans('global.btn_cancel') }}</a>
                    {!! Form::submit(trans('global.btn_submit'), ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>

@stop

