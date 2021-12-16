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

                <a class="float-left" href="{{ route('maintenance.index') }}"><i class="fe-arrow-left mR-10"></i> {{ trans('global.btn_back')}} </a>
                <hr class="mB-30">

                <h5 class="mb-3">DATA LOG</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-2">API Key</label>
                            <div class="col-sm-6">:  {{ $data->api_key }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">Hardware ID</label>
                            <div class="col-sm-6">:  {{ $data->line }}</div>
                        </div>
        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-2">Light</label>
                            <div class="col-sm-6">:  {!! getStatusLight($data->light) !!}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">Timestamp</label>
                            <div class="col-sm-6">: {{ date('d M Y H:i:s',strtotime($data->created_at)) }}
                            </div>
                        </div>
                    </div>
                </div>
       

                <hr>
                <h5 class="mb-3">DATA MAINTENANCE</h5>

                {!! Form::open([
                    'method' => 'POST', 
                    'route' => ['maintenance.store'],
                    'files' => true
                    ]) !!}

                    <input type="hidden" value="{{ $data->id }}" name="data_log_id">

                    @include('module.maintenance.form')

                {!! Form::close() !!}       
            </div>  
        </div>
    </div>
</div>

        
@endsection
