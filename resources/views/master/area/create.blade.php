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

                <a class="float-left" href="{{ route('master.area.index') }}"><i class="fe-arrow-left mR-10"></i> {{ trans('global.btn_back')}} </a>
                <hr class="mB-30">

                {!! Form::open(['method' => 'POST', 'route' => ['master.area.store']]) !!}
                    
                     @include('master.area.form')

                {!! Form::close() !!}       
            </div>  
        </div>
    </div>
        
@endsection
