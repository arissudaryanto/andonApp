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
                        <a  href="#" data-bs-toggle="collapse" data-bs-target="#filter" class="btn btn-sm float-end btn-outline-success text-uppercase">
                            FILTER DATA
                        </a>
                    </div>
                </div>

                <hr class="mB-30">

                <div class="table-responsive">
                    <table id="dataTables" class="table table-striped" cellspacing="0" width="100%">
                        <thead class="bg-default">
                            <tr>
                                <th>Device ID</th>
                                <th>Current Light</th>
                                <th>Last Downtime</th>
                                <th>Last Uptime</th>
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

        $('#dataTables').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('maintenance.datatables') }}',
            columns: [
                {data: 'device_id', name: 'device_id'},
                {data: 'light', name: 'light'},
                {data: 'downtime', name: 'downtime', searchable: false},
                {data: 'uptime', name: 'uptime', searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>
@stop