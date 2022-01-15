@extends('layouts.app')

@section('content')

    <!-- Start Content-->
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="page-title-box page-title-box-alt">
                    <div class="page-title">
                        <h4 class="float-left page-title">Dashboard
                            <small class="text-muted ml-2"><i class="fe-calendar"></i> {{ date('d M Y') }} </small>
                        </h4>
                    </div>
                </div>
            </div>
        </div>     
        <!-- end page title --> 

        <div class="row ">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-xl-3 col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body p-2">
                                <div class="text-center">
                                    Open Issues <br>
                                    <h2 class="mb-1 mt-0 text-white"> {{ $entity[0]->open }} </h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body p-2">
                                <div class="text-center">
                                    Closed Issues <br>
                                    <h2 class="mb-1 mt-0 text-white"> {{ $entity[0]->closed }} </h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body p-2">
                                <div class="text-center">
                                   Line Production <br>
                                    <h2 class="mb-1 mt-0 text-white">{{ $hardware[0]->line}} </h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-3">
                        <div class="card bg-primary">
                            <div class="card-body p-2 text-white">
                                <div class="text-center">
                                    Trolley <br>
                                    <h2 class="mb-1 mt-0 text-white">{{ $hardware[0]->trolley }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row mt-4">
            <h5>LINE/TROLLEY</h5>
            @foreach ($device as $item)
                <div class="col-lg-2 mb-2">
                    <a href="{{ route('maintenance.log',Hashids::encode($item->id)) }}" >
                        {{ $item->name }}
                    </a>
                    <a href="{{ route('maintenance.log',Hashids::encode($item->id)) }}" >
                        <div class="p-2 bg-line">
                            <div class="row">
                                <div class="col text-center">
                                    <i class="fa fa-circle font-28 {{ ($item->light=='RED') ? 'text-danger' : 'text-muted' }}"></i> 
                                </div>
                                <div class="col text-center">
                                    <i class="fa fa-circle font-28 {{ ($item->light=='GREEN') ? 'text-success' : 'text-muted' }}"></i> 
                                </div>
                            </div>
                        </div>
                    </a>
                    <small>Last Downtime: {{ ($item->downtime) ? date('d/m/Y H:s:s', strtotime($item->downtime)) : '-'}} </small>
                </div>
            @endforeach
        </div>
        
    </div> 

@endsection



@section('js')
    <script>
        $(document).ready(function() {
            setTimeout(function () { 
                location.reload();
            }, 10000);
        });
    </script>
@stop