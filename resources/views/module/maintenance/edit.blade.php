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

                <a class="float-left" href="{{ route('maintenance.index') }}"><i class="fe-arrow-left mR-10"></i> {{ trans('global.btn_back')}} </a>
                <hr class="mB-30">
            
                    {!! Form::model($items, [
                            'route' => ['maintenance.update', $items->id],
                            'method' => 'put', 
                        ])
                    !!}
                        
                        @include('maintenance.form')
				
			        {!! Form::close() !!}
                </div>  
            </div>  
	    </div>
    </div>

</div>
	
@stop
