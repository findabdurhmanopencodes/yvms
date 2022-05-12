@extends('layouts.app')
@section('title', 'Dashboard')
@section('breadcrumbList')
    <li class="active">Dashboard</li>
@endsection

@push('css')
    <style>
        .card-counter {
            box-shadow: 2px 2px 10px #DADADA;
            margin: 5px;
            padding: 20px 10px;
            background-color: #fff;
            height: 100px;
            border-radius: 5px;
            transition: .3s linear all;
        }

        .card-counter:hover {
            box-shadow: 4px 4px 20px #DADADA;
            transition: .3s linear all;
        }

        .card-counter.primary {
            background-color: #007bff;
            color: #FFF;
        }

        .card-counter.danger {
            background-color: #ef5350;
            color: #FFF;
        }

        .card-counter.success {
            background-color: #66bb6a;
            color: #FFF;
        }

        .card-counter.info {
            background-color: #26c6da;
            color: #FFF;
        }

        .card-counter i {
            font-size: 5em;
            opacity: 0.2;
        }

        .card-counter .count-numbers {
            position: absolute;
            right: 35px;
            top: 20px;
            font-size: 32px;
            display: block;
        }

        .card-counter .count-name {
            position: absolute;
            right: 35px;
            top: 65px;
            font-style: italic;
            text-transform: capitalize;
            opacity: 0.5;
        }

    </style>

    {{-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" /> --}}
@endpush
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card-counter primary">
                    <i class="fa fa-users" style="color:black;"></i>
                    <span class="count-numbers">

                        {{ $users }}

                    </span>
                    <span class="count-name"> Total Users</span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-counter danger">
                    <i class="fa fa-users" style="color:black;"></i>
                    <span class="count-numbers">{{ $traininingCenters }}</span>
                    <span class="count-name"> Training Centers</span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-counter success">
                    <i class="fa fa-users" style="color:black;"></i>
                    <span class="count-numbers">{{ $volunteers }}</span>
                    <span class="count-name"> Active Application</span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-counter info">
                    <i class="fa fa-flag" style="color:black;"></i>
                    <span class="count-numbers">{{ $regions }}</span>
                    <span class="count-name"> Regions</span>
                </div>
            </div>
        </div>
        <br>

    </div>
    </div>

    <div class="row">
        <!--end::Card-->
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b" style="min-height: 500px;">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Intake Capacity of Training Centers</h3>
                    </div>
                </div>
                <div class="card-body" style="position: relative;">
                    <!--begin::Chart-->
                    <div id="chart_5" style="min-height: 400px;">

                    </div>
                </div>
                <!--end::Chart-->
                <div class="resize-triggers">
                    <div class="expand-trigger">
                        <div style="width: 444px; height: 414px;"></div>
                    </div>
                    <div class="contract-trigger"></div>
                </div>
            </div>
        </div>
        <!--end::Card-->

    </div>


    <div class="row">


        <!--end::Card-->
        <div class="col-lg-6">
            <!--begin::Card-->
            <div class="card card-custom gutter-b" style="min-height: 500px;">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label"> Regional Quotas</h3>
                    </div>
                </div>
                <div class="card-body" style="position: relative;">
                    <!--begin::Chart-->
                    <div id="chart_12" style="min-height: 400px;">

                    </div>
                </div>
                <!--end::Chart-->
                <div class="resize-triggers">
                    <div class="expand-trigger">
                        <div style="width: 444px; height: 414px;"></div>
                    </div>
                    <div class="contract-trigger"></div>
                </div>
            </div>
        </div>
        <!--end::Card-->

        <div class="col-lg-6">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <!--begin::Header-->
                <div class="card-header h-auto">
                    <div class="card-title py-5">
                        <h3 class="card-label">National Intake Trend</h3>
                    </div>
                </div>
                <!--end::Header-->
                <div class="card-body" style="position: relative;">
                    <!--begin::Chart-->
                    <div id="chart_1" style="min-height: 365px;">

                    </div>
                </div>
                <!--end::Chart-->
                <div class="resize-triggers">
                    <div class="expand-trigger">
                        <div style="width: 444px; height: 414px;"></div>
                    </div>
                    <div class="contract-trigger"></div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        {{-- <div class="col-lg-6">
            <!--begin::Card-->

            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Stock and Asset Requests Trend</h3>
                    </div>
                </div>
                <div class="card-body" style="position: relative;">
                    <!--begin::Chart-->
                    <div id="chart_2" style="min-height: 365px;">

                    </div>
                </div>
                <!--end::Chart-->
                <div class="resize-triggers">
                    <div class="expand-trigger">
                        <div style="width: 444px; height: 414px;"></div>
                    </div>
                    <div class="contract-trigger"></div>
                </div>
            </div>
        </div> --}}
        <!--end::Card-->


        {{-- <div class="col-lg-6">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <!--begin::Header-->
                <div class="card-header h-auto">
                    <div class="card-title py-5">
                        <h3 class="card-label">Requests Approval Trend</h3>
                    </div>
                </div>
                <!--end::Header-->
                <div class="card-body" style="position: relative;">
                    <!--begin::Chart-->
                    <div id="chart_1" style="min-height: 365px;">

                    </div>
                </div>
                <!--end::Chart-->
                <div class="resize-triggers">
                    <div class="expand-trigger">
                        <div style="width: 444px; height: 414px;"></div>
                    </div>
                    <div class="contract-trigger"></div>
                </div>
            </div>
        </div> --}}

    </div>
    <div class="row">
        <div class="col-lg-6">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <!--begin::Header-->
                <div class="card-header h-auto">
                    <div class="card-title py-5">
                        <h3 class="card-label">Line Chart</h3>
                    </div>
                </div>
                <!--end::Header-->
                <div class="card-body" style="position: relative;">
                    <!--begin::Chart-->
                    <div id="chart_11" style="min-height: 365px;">

                    </div>
                </div>
                <!--end::Chart-->
                <div class="resize-triggers">
                    <div class="expand-trigger">
                        <div style="width: 444px; height: 414px;"></div>
                    </div>
                    <div class="contract-trigger"></div>
                </div>
            </div>
        </div>
        <!--end::Card-->

        <div class="col-lg-6">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <!--begin::Header-->
                <div class="card-header h-auto">
                    <div class="card-title py-5">
                        <h3 class="card-label">Regional Contribution of Training Center</h3>
                    </div>
                </div>
                <!--end::Header-->
                <div class="card-body" style="position: relative;">
                    <!--begin::Chart-->
                    <div id="chart_3" style="min-height: 365px;">

                    </div>
                </div>
                <!--end::Chart-->
                <div class="resize-triggers">
                    <div class="expand-trigger">
                        <div style="width: 444px; height: 414px;"></div>
                    </div>
                    <div class="contract-trigger"></div>
                </div>
            </div>
        </div>
        <!--end::Card-->

        <!--end::Card-->

    </div>

@endsection

@push('js')
    <script type="text/javascript">
        var trainingCenter = {{ Js::from($trainingCentersCapacity) }}

    </script>
    <script type="text/javascript" src="{{ asset('assets/js/pages/features/charts/apexcharts.js') }}"></script>
@endpush
