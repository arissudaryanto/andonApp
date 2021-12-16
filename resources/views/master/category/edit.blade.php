@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box page-title-box-alt">
                <h4 class="page-title"> Category</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                <a class="float-left" href="{{ route('master.category.index') }}"><i class="fe-arrow-left mR-10"></i> {{ trans('global.btn_back')}} </a>
                <hr class="mB-30">
            
                    {!! Form::model($items, [
                            'route' => ['master.category.update', $items->id],
                            'method' => 'put', 
                        ])
                    !!}
                        
                        @include('master.category.form')
				
			        {!! Form::close() !!}
                </div>  
            </div>  
	    </div>
    </div>

</div>
	
@stop
