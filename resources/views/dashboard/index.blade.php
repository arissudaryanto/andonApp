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
                    <div class="float-end">
                            <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fe-calendar"></i></span>
                            </div>
                            <input class="form-control yearpicker" name="year" required id="year" value="{{ $year }}" style="width:100px">          
                        </div>
                    </div>
                </div>
            </div>
        </div>     
        <!-- end page title --> 

        <div class="row ">
            <div class="col-xl-4">
                <div class="row">

                    <div class="col-xl-6 col-md-6">
                        <div class="card bg-warning text-dark">
                            <div class="card-body p-2">
                                <div class="text-center">
                                    Open Issues <br>
                                    <small class="mb-1">including hold/process SLA </small>
                                    <h2 class="mb-1 mt-0"> {{ $entity[0]->open + $entity[0]->hold  + $entity[0]->process }} </h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-6">
                        <div class="card bg-success text-white">
                            <div class="card-body p-2">
                                <div class="text-center">
                                    Closed Issues <br>
                                    <small class="mb-1">(Total)</small>
                                    <h2 class="mb-1 mt-0 text-white">{{$entity[0]->closed }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-6">
                        <div class="card bg-info text-white">
                            <div class="card-body p-2">
                                <div class="text-center">
                                    Average Respone Time <br>
                                    <small class="text-white mb-1">(Hours)</small>
                                    <h2 class="mb-1 mt-0 text-white">2.3</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-6">
                        <div class="card bg-primary">
                            <div class="card-body p-2 text-white">
                                <div class="text-center">
                                    Average Resolution Time <br>
                                    <small class="text-white mb-1">(Hours)</small>
                                    <h2 class="mb-1 mt-0 text-white">2.3</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12">
                        <div class="card bg-vector">
                            <div class="card-body p-2">
                                <h4 class="header-title mb-0">Total Hardware</h4>
                                <div class="row mt-2">
                                    <div class="col">
                                        <h2 class="mb-3 mt-0">{{ $hardware[0]->line}} <small> Line Production</small></h2>
                                        <h2 class=" mt-0">{{ $hardware[0]->trolley }} <small>Trolley</small></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">

                        <h4 class="header-title">Daily Issues</h4>

                        <div class="mt-3 text-center">

                            <div dir="ltr">
                                <div id="chart-daily" class="apex-charts"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">

            <div class="col-xl-4 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-0">Issues by Group Area</h4>

                        <div class="mt-3 text-center">

                            <div dir="ltr">
                                <div id="chart-area" class="apex-charts" data-colors="#0056c1,#e3eaef"></div>
                            </div>

                        </div>
                    </div>
                </div> 
            </div> 

            <div class="col-xl-4 col-lg-6">
                <div class="card">
                    <div class="card-body">

                        <h4 class="header-title">Issues by Category </h4>

                        <div class="mt-3">
                            <div dir="ltr">
                                <div id="chart-category" class="apex-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Issues by Priority</h4>
                        <div class="mt-3">
                            <div dir="ltr">
                                <div id="chart-priority" class="apex-charts"></div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div> 

        </div>
        
    </div> 

    @include('dashboard.chart')
@endsection



