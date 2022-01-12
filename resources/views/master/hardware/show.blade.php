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

                    <a class="float-left" href="{{ route('master.hardware.index') }}"><i class="fe-arrow-left mR-10"></i> {{ trans('global.btn_back')}}</a>
                    <hr class="mB-30">
                    <h5>Detail Hardware</h5>
                    <div class="row">
                        <div class="col-lg-3">
                            @if ($item->image_url)
                                <img src="{{ asset('storage'.$item->image_url) }}" class="img-fluid img-thumbnail w-75">
                            @else
                                <img src="{{ asset('images/no-image.png') }}" class="img-fluid img-thumbnail w-75">
                            @endif

                        </div>

                        <div class="col-lg-8">
                            <div class="form-group row">
                                <label class="col-sm-3">ID</label>
                                <div class="col-sm-8">
                                    : {{ $item->device_id }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3">Nama Hardware</label>
                                <div class="col-sm-8">
                                    : {{ $item->name }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3">Type</label>
                                <div class="col-sm-8">
                                    : {{ $item->type }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3">Deskripsi</label>
                                <div class="col-sm-8">
                                    : {{ $item->description }}
                                </div>
                            </div>
                        </div>
                    </div>
                    

                </div>  
	        </div>
        </div>
    </div>
</div>
	
@stop

