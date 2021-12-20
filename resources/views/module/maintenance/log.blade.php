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

                <h5 class="mb-3">HARDWARE</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-2">Device ID</label>
                            <div class="col-sm-6">:  {{ $hardware->device_id }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">Alias</label>
                            <div class="col-sm-6">:  {{ $hardware->name }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-2">Light</label>
                            <div class="col-sm-6">:  {!! getStatusLight($hardware->light) !!}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">Updated Data</label>
                            <div class="col-sm-6">: {{ date('d M Y H:i:s',strtotime($hardware->updated_at)) }}
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mB-20">
                    <div class="col-sm-12">

                        <a  href="#" data-bs-toggle="collapse" data-bs-target="#export" class="btn btn-sm float-end btn-outline-success text-uppercase">
                            EXPORT DATA
                        </a>
                    </div>
                </div>
                <div class="collapse mb-3" id="export" aria-expanded="false">
                    <form id="form" method="GET" action="{{ route('maintenance.export') }}">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <div class="mb-2 col-sm-3">
                                <label>Damaged Category</label>
                                {!! Form::select('category_id', $category,null, ['class' => 'form-control select2']) !!}
                            </div>
                            <div class="mb-2 col-sm-2">
                                <label>Status</label>
                                {!! Form::select('status_id', $status,null, ['class' => 'form-control select2']) !!}
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
                                <th>Timestamp</th>
                                <th>Light</th>
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

<div class="modal fade" id="modal_test" tabindex="-2" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            {!! Form::open(['method' => 'POST', 'route' => ['maintenance.status'],'files' => true]) !!}
            <input type="hidden" value="" name="data_log_id" id="dataID">
    
            <div class="modal-header">
                  <h5 class="modal-title" id="modalMdTitle">Update Status</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-right">Status <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                      <select class="form-control" name="status">
                          <option value="1"> Process</option>
                          <option value="2"> Hold</option>
                          <option value="3"> Closed</option>
                      </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-right">Remark</label>
                    <div class="col-sm-8">
                        {!! Form::textarea('remark', old('remark'), ['class' => 'form-control', 'rows' => 3, 'placeholder' => '']) !!}
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <label class="col-sm-3 col-form-label">Attachment </label>
                    <div class="col-sm-8">
                        <input type="file" id="files" name="file_attachment">
                    </div>
                </div>

              </div>
              <div class="modal-footer">
                    <button data-bs-dismiss="modal" class="float-right btn btn-light text-uppercase fsz-sm fw-600 mr-3">{{ __('global.btn_cancel') }}</a>
                    <button type="submit" class="btn btn-danger text-uppercase float-right ">{{ __('global.btn_submit') }}</button>
              </div>
    
            {!! Form::close() !!}   
      
        </div>
    </div>
</div>


@endsection

@section('js')
    <script>
    $(document).ready(function() {

        $('#modal_test').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            $('#dataID').val(id);
        });

        $('#modal_test').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
        })

        $('#dataTables').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('maintenance.log.datatables',$hardware->device_id) }}',
            columns: [
                {data: 'created_at', name: 'created_at', searchable: false},
                {data: 'light', name: 'light'},
                {data: 'status', name: 'status', searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            "order": [[ 0, 'desc' ]]
        });
    });
</script>
@stop