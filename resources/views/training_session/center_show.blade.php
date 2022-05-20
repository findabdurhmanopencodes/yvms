@extends('layouts.app')
@section('title', 'Center base detail')
@section('content')
    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="card-body">
            <div class="d-flex">
                <!--begin: Pic-->
                <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                    <div class="symbol symbol-50 symbol-lg-120">
                        <img alt="Pic" src="{{ $trainingCenter->getLogo() }}" />
                    </div>
                    <div class="symbol symbol-50 symbol-lg-120 symbol-primary d-none">
                        <span class="font-size-h3 symbol-label font-weight-boldest">{{ $trainingCenter->code }}</span>
                    </div>
                </div>
                <!--end: Pic-->
                <!--begin: Info-->
                <div class="flex-grow-1">
                    <!--begin: Title-->
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="mr-3">
                            <!--begin::Name-->
                            <a href="#"
                                class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-3">{{ $trainingCenter->name }}
                                - <span> {{ $trainingCenter->code }}</span>
                                <i class="flaticon2-correct text-success icon-md ml-2"></i></a>
                            <!--end::Name-->
                            <!--begin::Contacts-->
                            <div class="d-flex flex-wrap my-2">

                                <a href="#" class="text-muted text-hover-primary font-weight-bold">
                                    <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Map/Marker2.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path
                                                    d="M9.82829464,16.6565893 C7.02541569,15.7427556 5,13.1079084 5,10 C5,6.13400675 8.13400675,3 12,3 C15.8659932,3 19,6.13400675 19,10 C19,13.1079084 16.9745843,15.7427556 14.1717054,16.6565893 L12,21 L9.82829464,16.6565893 Z M12,12 C13.1045695,12 14,11.1045695 14,10 C14,8.8954305 13.1045695,8 12,8 C10.8954305,8 10,8.8954305 10,10 C10,11.1045695 10.8954305,12 12,12 Z"
                                                    fill="#000000" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>{{ $trainingCenter->zone->name . ' / ' . $trainingCenter->zone->region->name . ' / ' }}</a>
                            </div>
                            <!--end::Contacts-->
                        </div>
                        <div class="my-lg-0 my-1">
                            <a href="#" class="btn btn-sm btn-light-success font-weight-bolder text-uppercase mr-3">Print
                                Badge</a>
                            <a href="#" class="btn btn-sm btn-info font-weight-bolder text-uppercase">New Task</a>
                        </div>
                    </div>
                    <!--end: Title-->
                    <!--begin: Content-->
                    <div class="d-flex align-items-center flex-wrap justify-content-between">
                        <div class="flex-grow-1 font-weight-bold text-dark-50 py-5 py-lg-2 mr-5 w-100">
                            {{ $trainingCenter->description ?? 'There is no description of the center' }}
                            <br />
                        </div>
                        <div class="d-flex flex-wrap align-items-center py-2">
                            <div class="d-flex align-items-center mr-10">
                                <div class="mr-6">
                                    <div class="font-weight-bold mb-2">Start Date</div>
                                    <span class="btn btn-sm btn-text btn-light-primary text-uppercase font-weight-bold">07
                                        May, 2020</span>
                                </div>
                                <div class="">
                                    <div class="font-weight-bold mb-2">Due Date</div>
                                    <span class="btn btn-sm btn-text btn-light-danger text-uppercase font-weight-bold">10
                                        June, 2021</span>
                                </div>
                            </div>
                            <div class="flex-grow-1 flex-shrink-0 w-150px w-xl-300px mt-4 mt-sm-0">
                                <span class="font-weight-bold">Progress</span>
                                <div class="progress progress-xs mt-2 mb-2">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 63%;"
                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="font-weight-bolder text-dark">78%</span>
                            </div>
                        </div>
                    </div>
                    <!--end: Content-->
                </div>
                <!--end: Info-->
            </div>
            <div class="separator separator-solid my-7"></div>
            <!--begin: Items-->
            <div class="d-flex align-items-center flex-wrap">
                <!--begin: Item-->
                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                    <span class="mr-4">
                        <i class="flaticon-piggy-bank icon-2x text-muted font-weight-bold"></i>
                    </span>
                    <div class="d-flex flex-column text-dark-75">
                        <span class="font-weight-bolder font-size-sm">Total Volunteers</span>
                        <span class="font-weight-bolder font-size-h5">
                            <span class="text-dark-50 font-weight-bold"></span>{{ $totalVolunteers }}</span>
                    </div>
                </div>
                <!--end: Item-->
                <!--begin: Item-->
                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                    <span class="mr-4">
                        <i class="flaticon-confetti icon-2x text-muted font-weight-bold"></i>
                    </span>
                    <div class="d-flex flex-column text-dark-75">
                        <span class="font-weight-bolder font-size-sm">Checked In Volunteer</span>
                        <span class="font-weight-bolder font-size-h5">
                            <span class="text-dark-50 font-weight-bold"></span>{{ $totalVolunteers }}</span>
                    </div>
                </div>
                <!--end: Item-->
                <!--begin: Item-->
                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                    <span class="mr-4">
                        <i class="flaticon-pie-chart icon-2x text-muted font-weight-bold"></i>
                    </span>
                    <div class="d-flex flex-column text-dark-75">
                        <span class="font-weight-bolder font-size-sm">Training Masters</span>
                        <span class="font-weight-bolder font-size-h5">
                            <span class="text-dark-50 font-weight-bold"></span>{{ $totalTrainingMasters }}</span>
                    </div>
                </div>
                <!--end: Item-->
                <!--begin: Item-->
                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                    <span class="mr-4">
                        <i class="flaticon-file-2 icon-2x text-muted font-weight-bold"></i>
                    </span>
                    <div class="d-flex flex-column flex-lg-fill">
                        <span class="text-dark-75 font-weight-bolder font-size-sm">Total Resource</span>
                        <a href="#"
                            class="text-primary font-weight-bolder">{{ $trainingCenter->resources()->count() }}</a>
                    </div>
                </div>
                <!--end: Item-->
            </div>
            <!--begin: Items-->
        </div>
    </div>
    <!--end::Card-->


    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">Training and trainners</span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm">Total {{ count($trainings) }} trainings in
                    this
                    session</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('session.training_master_placement.index', ['training_session'=>Request::route('training_session')]) }}" class="btn btn-success font-weight-bolder font-size-sm">
                <span class="svg-icon svg-icon-md svg-icon-white">
                </span>Add master trainners</a>
            </div>
        </div>
        <div class="card-body pt-0">
            <table width="100%" class="table table-striped ">
                <thead>
                    </tr>
                        <th> # </th>
                        <th> Training </th>
                        <th> Trainner </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trainings as $key => $training)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                {{ $training->name }}
                            </td>
                            <td>
                                {{ $training->trainner(Request::route('training_session'), $trainingCenter, $training)?->master->user->name() ?? 'Assign Trainner' }}
                            </td>
                        </tr>
                    @endforeach
                    {{-- @foreach ($trainingMasterPlacements as $key => $trainingMasterPlacement)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <a href="{{ route('training_master.show', ['training_master' => $trainingMasterPlacement->master->id]) }}">
                                    {{ $trainingMasterPlacement->master->user->name() }}
                                </a>
                            </td>
                            <td>
                                {{$trainingMasterPlacement->training->name}}
                            </td>
                            <td>
                                <a href="{{ route('TrainingCenter.show', ['TrainingCenter' => $trainingMasterPlacement->center->id]) }}">
                                    {{ $trainingMasterPlacement->center->name }}
                                </a>
                            </td>
                            <td>
                                <a href="#" onclick="confirmDeleteMasterPlacement({{ $trainingMasterPlacement->id }})"
                                    class="btn btn-icon">
                                    <span class="fa fa-trash"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
            <!--begin: Items-->
        </div>
    </div>
    <!--end::Card-->

@endsection
