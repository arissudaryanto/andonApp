@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box page-title-box-alt">
                <h4 class="page-title"> Maintenance</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                <a class="float-left" href="{{ route('maintenance.log',Hashids::encode($hardware->id)) }}"><i class="fe-arrow-left mR-10"></i> {{ trans('global.btn_back')}} </a>
                <hr class="mB-30">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3">Line/Trolley ID</label>
                            <div class="col-sm-6">:  {{ $hardware->device_id }}</div>
                        </div>
                    </div>
                </div>

                <hr>
                {!! Form::model($data,[
                        'method' => 'POST', 
                        'route' => ['maintenance.store'],
                        'files' => true
                    ]) !!}

                    <input type="hidden" value="{{ $data->id }}" name="data_log_id">
                    <input type="hidden" value="{{ $hardware->id }}" name="hardware_id">

                    @include('module.maintenance.form')

                {!! Form::close() !!}       
            </div>  
        </div>
    </div>
</div>

        
@endsection
