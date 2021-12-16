@extends('layouts.app')


@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box page-title-box-alt">
                    <h4 class="page-title">{{ trans('Permission') }}</h4>
                </div>
                <input class="form-control yearpicker float-end" name="year" required id="year" value="{{ $year }}" style="width:100px">          

            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                    <a href="{{ route('setting.permissions.create') }}" class="btn btn-info">@lang('global.btn_add')</a>
                    <hr>
                    <div class="table-responsive">
                        <table id="dataTables" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>@lang('global.name')</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('setting.permissions.datatables') }}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "pageLength": 50
            });
        });
    </script>
@stop