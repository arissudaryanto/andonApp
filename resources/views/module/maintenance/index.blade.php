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
                        <a  href="#" data-bs-toggle="collapse" data-bs-target="#summary" class="btn btn-sm float-end btn-outline-danger text-uppercase ml-2">
                            EXPORT SUMMARY
                        </a>
                        <a  href="#" data-bs-toggle="collapse" data-bs-target="#export" class="btn btn-sm float-end btn-outline-success text-uppercase">
                            EXPORT DATA
                        </a>
                    </div>
                </div>

                <hr class="mB-30">
                <div class="collapse mb-3" id="summary" aria-expanded="false">
                    <form id="form" method="GET" action="{{ route('maintenance.recap') }}">
                        {{ csrf_field() }}
                        <div class="form-group row">
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


                <div class="collapse mb-3" id="export" aria-expanded="false">
                    <form id="form" method="GET" action="{{ route('maintenance.export') }}">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <div class="mb-2 col-sm-3">
                                <label>Line/Trolley</label>
                                {!! Form::select('line', $hardware,null, ['class' => 'form-control select2']) !!}
                            </div>
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
                                <th>Line/Trolley</th>
                                <th>Current Status</th>
                                <th>Last Downtime</th>
                                <th>Total Downtime per Day</th>
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

       var table =  $('#dataTables').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('maintenance.datatables') }}',
            columns: [
                {data: 'device_id', name: 'device_id'},
                {data: 'light', name: 'light'},
                {data: 'downtime', name: 'downtime', searchable: false},
                {data: 'total_downtime', name: 'total_downtime', searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        setInterval(function() {
            table.ajax.reload();
            }, 10000 );
        
        setTimeout(function () { 
            location.reload();
        }, 60 * 1000);
     });
</script>
@stop