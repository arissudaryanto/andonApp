@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box page-title-box-alt">
                <h4 class="page-title"> Group Area</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row mB-20">
                        <div class="col-sm-12">
                            <a href="{{ route('master.area.create') }}" class="btn btn-success text-uppercase">
                                {{ trans('global.btn_add')}}
                            </a>
    
                            <a  href="#" data-toggle="collapse" data-target="#export" class="float-end text-uppercase">
                                <i class="ri-file-excel-2-fill text-success fa-2x"></i>
                            </a>
                            <a href="#" class="text-uppercase fsz-sm float-end mr-lg-2 fw-600" data-toggle="collapse" data-target="#filter">
                                <i class=" ri-filter-2-fill fa-2x"></i>
                            </a>
                        </div>
                    </div>
    
                    <hr class="mB-30">

                    

                    <table id="dataTables" class="table table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Updated</th>
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
            pageLength: 25,
            processing: true,
            serverSide: true,
            ajax: '{{ route('master.area.datatables') }}',
            columns: [
                {data: 'code', name: 'code'},
                {data: 'name', name: 'name'},
                {data: 'status', name: 'status', searchable: false},
                {data: 'updated_at', name: 'updated_at', searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>
@stop