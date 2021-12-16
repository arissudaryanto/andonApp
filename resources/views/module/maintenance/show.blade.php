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
                <div class="form-group row">
                    <label class="col-sm-2">API Key</label>
                    <div class="col-sm-6">:  {{ $data->api_key }}</div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2">Hardware ID</label>
                    <div class="col-sm-6">:  {{ $data->line }}</div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2">Light</label>
                    <div class="col-sm-6">:  {!! getStatusLight($data->light) !!}</div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2">Timestamp</label>
                    <div class="col-sm-6">: {{ date('d M Y H:i:s',strtotime($data->created_at)) }}
                    </div>
                </div>
       

                <hr>
                <h5 class="mb-3">MAINTENANCE</h5>
                <div class="form-group row">
                    <label class="col-sm-2">Ticket Number</label>
                    <div class="col-sm-6">:  {{ $data->maintenance->number }}</div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2">Category</label>
                    <div class="col-sm-6">:  {{ $data->maintenance->category->name }}</div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2">Description</label>
                    <div class="col-sm-6">:  {{ $data->maintenance->description }}</div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2">Assigned By</label>
                    <div class="col-sm-6">:  {{ $data->maintenance->user->name }}</div>
                </div>
                <table class="table table-striped mt-5">
                    <thead>
                        <th>Date</th>
                        <th>Remark</th>
                        <th>Status</th>
                        <th>Attachment</th>
                    </thead>
                    <tbody>
                        @foreach ($data->history as $item)
                            <tr>
                                <td>{{ date('d M Y H:i:s',strtotime($item->created_at)) }}</td>
                                <td>{{ $item->remark }}</td>
                                <td>{!! getStatusData($item->status) !!}</td>
                                <td>{{ $item->file_attachment }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                   
            </div>  
        </div>
    </div>
</div>

        
@endsection
