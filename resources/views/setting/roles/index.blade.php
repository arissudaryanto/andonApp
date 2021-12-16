@extends('layouts.app')


@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box page-title-box-alt">
                    <h4 class="page-title">{{ trans('Roles') }}</h4>
                </div>
            </div>
        </div>

    
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="btn-toolbar">
                            <div class="btn-group focus-btn-group">
                                <a href="{{ route('setting.roles.create') }}" class="btn btn-success">@lang('global.btn_add')</a>
                            </div>
                        </div>
                        <hr>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped {{ count($roles) > 0 ? 'datatable' : '' }} dt-select">
                            <thead>
                                <tr>
                                    <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                                    <th>@lang('global.name')</th>
                                    <th>@lang('app.permission')</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                @if (count($roles) > 0)
                                    @foreach ($roles as $role)
                                        <tr data-entry-id="{{ $role->id }}">
                                            <td></td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                @foreach ($role->permissions()->pluck('name') as $permission)
                                                    <span class="label label-info label-many">{{ $permission }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('setting.roles.edit',[$role->id]) }}" class="btn"><i class="fe-edit icon-lg"></i></a>
                                                    {!! Form::open([
                                                        'class'=>'delete',
                                                        'url'  => route('setting.roles.destroy', $role->id), 
                                                        'method' => 'DELETE',
                                                        ]) 
                                                    !!}
                                                        <button class="btn text-danger " title="{{ trans('global.btn_delete') }}" type="submit" ><i class="fe-trash icon-lg"></i></button>
                                                    {!! Form::close() !!}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">@lang('global.no_entries')</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop

@section('javascript') 
    <script>
        window.route_mass_crud_entries_destroy = '{{ route('setting.roles.mass_destroy') }}';
    </script>
@endsection