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
 
                    <div class="mB-20">
                        <a href="{{ route('master.hardware.create') }}" class="btn btn-success text-uppercase">
                            <i class="ti-plus"></i> {{ trans('global.btn_add')}}
                        </a>
                        <a  href="{{ route('master.hardware.export') }}" class="float-end text-uppercase" aria-controls="export">
                            <i class="ri-file-excel-2-fill text-success fa-2x"></i>
                        </a>
                    </div>
                    <hr class="mB-30">

                    <table id="dataTables" class="table table-striped w-100 dataTable no-footer dtr-inhardware"  cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Device ID</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Tgl Updated</th>
                                <th>Action</th>
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
            ajax: '{{ route('master.hardware.datatables') }}',
            columns: [
                {data: 'device_id', name: 'device_id'},
                {data: 'name', name: 'name'},
                {data: 'type', name: 'type'},
                {data: 'status', name: 'status', searchable: false},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            "language": {
                "paginate": {
                    "previous": "<i class='mdi mdi-chevron-left'>",
                    "next": "<i class='mdi mdi-chevron-right'>"
                }
            },
            "drawCallback": function () {
                $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
            }
        });
    });
</script>
@stop