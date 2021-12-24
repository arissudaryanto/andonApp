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
 
                <div class="row mB-20">
                    <div class="col-sm-12">
                        <a class="float-left" href="{{ route('maintenance.index') }}"><i class="fe-arrow-left mR-10"></i> {{ trans('global.btn_back')}} </a>
                    </div>
                </div>

                <hr class="mB-30">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-5">Line/Trolley ID</label>
                            <div class="col-6">:  {{ $hardware->device_id }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-5">Status</label>
                            <div class="col-6">:  {!! getStatusLight($hardware->light) !!}</div>
                        </div>
                    </div>
                    <div class="col-md-6 d-none d-lg-inline-block">
                        <div class="row justify-content-end">
                            <div class="col-xl-4 col-md-4">
                                <div class="card bg-primary text-dark">
                                    <div class="card-body p-2 text-white">
                                        <h2 class="mb-1 mt-0 text-white">{{  $statistic[0]->open + $statistic[0]->closed }}  </h2>
                                        Total Issues <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mB-20">
                    <div class="col-sm-12">
                        <a href="#" data-bs-toggle="collapse" data-bs-target="#export" class="float-end text-muted">
                            <i class="fa fa-file-excel fa-2x"></i>
                        </a>
                        <h5>DATA LOG</h5>
                    </div>
                </div>
                <hr>

                <div class="collapse mb-3" id="export" aria-expanded="false">
                    <form id="form" method="GET" action="{{ route('maintenance.export') }}">
                        <input type='hidden' name='line' value="{{ $hardware->device_id }}">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <div class="mb-2 col-sm-3">
                                <label>Damaged Category</label>
                                {!! Form::select('category_id', $category,null, ['class' => 'form-control select2']) !!}
                            </div>
                            <div class="col-sm-4">
                                <label>Periode</label>
                                <div class="input-group w-100">
                                    <input name="start_date" type="date" class="form-control" required value="{{ date('Y-m-d') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">ke</div>
                                    </div>
                                    <input type="date" name="end_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-danger border mt-3 text-uppercase" id="btn-filter">EXPORT</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                </div>  

                <div class="table-responsive">
                    <table id="dataTables" class="table table-striped" cellspacing="0" width="100%">
                        <thead class="bg-default">
                            <tr>
                                <th>Timestamp RED</th>
                                <th>Timestamp GREEN</th>
                                <th>Downtime</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>

@endsection

@section('js')
    <script>
    $(document).ready(function() {

       var table = $('#dataTables').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('maintenance.log.datatables',$hardware->device_id) }}',
            columns: [
                {data: 'downtime', name: 'downtime', searchable: false},
                {data: 'uptime', name: 'uptime', searchable: false},
                {data: 'range', name: 'range'},
                {data: 'category', name: 'categories.name'},
                {data: 'status', name: 'status', searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            "order": [[ 0, 'desc' ]]
        });
        setInterval(function() {
            table.ajax.reload();
        }, 10000 );

        setTimeout(function () { 
            location.reload();
        }, 30000);
    });
</script>
@stop