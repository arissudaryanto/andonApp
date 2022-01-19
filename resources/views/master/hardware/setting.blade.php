@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box page-title-box-alt">
                <h4 class="page-title"> Hardware</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a class="float-left" href="{{ route('master.hardware.index') }}"><i class="fe-arrow-left mR-10"></i> {{ trans('global.btn_back')}} </a>
                    <hr class="mB-30">
                        {!! Form::model($item, [
                                'route' => ['master.hardware.setting', $item->id],
                                'method' => 'post', 
                            ])
                        !!}
                        <div class="form-group row mb-2">
                            <div class="col-sm-2">Device ID</div>
                            <div class="col-sm-6">: {{ $item->device_id }} </div>
                        </div>
                        <div class="form-group row mb-2">
                            <div class="col-sm-2">Nama</div>
                            <div class="col-sm-6">: {{ $item->name }} </div>
                        </div>
                        <hr>
                        <div class="form-group row mb-2">
                            <div class="col-sm-3">Setting User <span class="text-danger">*</span><br><small>User yang dapat mengakses Line/Trolley</small></div>
                            <div class="col-sm-6">
                                {!! Form::select('users[]', $user, json_decode($item->users), ['class' => 'form-control select2', 'multiple' => 'multiple', 'requires' => 'required']) !!}
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-8">
                                <a href="{{ route('master.hardware.index') }}" class="btn btn-light text-uppercase mr-3">{{ trans('global.btn_cancel') }}</a>
                                {!! Form::submit(trans('global.btn_submit'), ['class' => 'btn btn-danger text-uppercase','id'=>'btn-submit']) !!}
                            </div>
                        </div>
                        
                    {!! Form::close() !!}
                          
                </div>
            </div>
        </div>
    </div>

</div>
	
@stop



@section('js')
    <script>

        $(document).ready(function() {
            
           
        });
    </script>
@stop