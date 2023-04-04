@extends('layouts.app')
@section('title', 'Deployment')
@section('breadcrumb-list')
    <li class="active">Volunteer Deployment</li>
@endsection
@section('breadcrumbTitle', 'Deployment')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Deployment</a>
    </li>
@endsection

@push('js')
    <script src="{{ asset('assets/js/pages/crud/ktdatatable/base/data-ajax.js') }}"></script>
@endpush

@section('content')
    <!--begin::Card-->
    <div class="card card-custom card-body mb-3">
        <form name="filterForm" action="" method="GET">
            <div class=" ml-0 col-12 p-0">
                <div class="row ">
                    @if (Auth::user()->getCordinatingRegion() == null && Auth::user()->getCordinatingZone() == null)
                        <div class="form-group col-3">
                            <select name="region" id="" class="form-control select2">
                                <option value="">Select Region</option>
                                @foreach ($regionIntakes as $regionIntake)
                                    <option value="{{ $regionIntake->region->id }}"
                                        @if (Request::get('region') == $regionIntake->region->id) selected @endif>
                                        {{ $regionIntake->region->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    @if (Auth::user()->getCordinatingZone() == null)
                        <div class="form-group col-3">
                            <select name="zone" id="" class="form-control select2">
                                <option value="">Select Zone</option>
                                @foreach ($zoneIntakes as $zoneIntake)
                                    <option value="{{ $zoneIntake->zone->id }}"
                                        @if (Request::get('zone') == $zoneIntake->zone->id) selected @endif>
                                        {{ $zoneIntake->zone->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="form-group col-3">
                        <select name="woreda" id="" class="form-control select2">
                            <option value="">Select Woreda</option>
                            @foreach ($woredaIntakes as $woredaIntake)
                                <option value="{{ $woredaIntake->woreda->id }}"
                                    @if (Request::get('woreda') == $woredaIntake->woreda->id) selected @endif>
                                    {{ $woredaIntake->woreda->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <input type="text" name="id_number" class="form-control" placeholder="ID number">
                    </div>
                    <div class="form-group col-3">
                        <select name="training_center" id="" class="form-control select2">
                            <option value="">Select Training Center</option>
                            @foreach ($trainingCenterCapacities as $trainingCenterCapacity)
                                <option value="{{ $trainingCenterCapacity->trainingCenter->id }}"
                                    @if (Request::get('training_center') == $trainingCenterCapacity->trainingCenter->id) selected @endif>
                                    {{ $trainingCenterCapacity->trainingCenter->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <select name="fied_of_study" id="" class="form-control select2">
                            <option value="">Select Field of study</option>
                            @foreach ($fieldOfStudies as $fieldOfStudy)
                                <option value="{{ $fieldOfStudy->id }}" {{ Request::get('fied_of_study') == $fieldOfStudy->id ? 'selected' : '' }}>{{ $fieldOfStudy->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary btn-block"> Filter</button>
                </div>
            </div>
            <input type="hidden" name="print" id="print" value="">
        </form>
    </div>

    <div class="modal fade" id="deploymentWoredaEdit" tabindex="-1" role="dialog" aria-labelledby="deploymentWoredaEdit"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                {{-- <form action="/trh" method="POST"> --}}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Change Deployment Woreda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="changeDeploymentForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="woreda_intake_id" class="font-weight-bold">Deployment Woreda</label>
                            <select name="woreda_intake_id" id="woreda_intake_id" class="form-control select2"
                                style="width: 100%">
                                @foreach ($woredaIntakes as $woredaIntake)
                                    <option value="{{ $woredaIntake->id }}">
                                        {{ $woredaIntake->woreda->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Save Changes" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form id="approvePlacmentForm"
        action="{{ route('session.placment.approve', [request()->route('training_session')]) }}" method="POST">
        @csrf
    </form>

    <div class="card card-custom">
        <div class="card-header flex-wrap  pt-6 ">
            <div class="card-title mr-0">
                <h3 class="card-label"> Volunteers Deployment </h3>
            </div>
            <div class="card-toolbar">
                <div class="btn-group">

                    @if ($trainingSession->status == \App\Constants::TRAINING_SESSION_GRADUATED)
                        <a class="btn btn-sm btn-info"
                            href="{{ route('session.deployment.reset', [request()->route('training_session')]) }}">
                            <i class="fal fa-recycle"></i> Reset
                        </a>
                        <a class="btn btn-sm btn-success" onclick="approvePlacment()" href="#">
                            <i class="fal fa-stamp"></i> Approve Deployment
                        </a>
                    @endif
                    @if ($trainingSession->status == \App\Constants::TRAINING_SESSION_DEPLOYMENT_APPROVED)
                        <a href="#">
                            <span class="label label-xl label-light-success label-inline">Volunteer Deployment Approved</span>
                        </a>
                    @endif
                    {{-- <a class="btn btn-sm btn-primary" href="#" onclick="document.filterForm.print.value = '1';document.filterForm.submit();">
                        <i class="fal fa-print"></i> Print
                    </a> --}}
                    <div class="my-1 my-lg-0">
                        <div class="dropdown dropdown-inline">
                            <a href="#" class="px-5 btn btn-sm btn-primary font-weight-bolder dropdown-toggle"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">print</a>
                            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="">
                                <!--begin::Navigation-->
                                <ul class="navi navi-hover">
                                    <li class="navi-item">
                                        <a data-toggle="modal" data-target="#import" class="navi-link" onclick="document.filterForm.print.value = '1';document.filterForm.submit();">
                                            <span class="navi-icon">
                                                <i class="fa fa-file-import"></i>
                                            </span>
                                            <span class="navi-text">PDF</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="#" onclick="document.filterForm.print.value = '2';document.filterForm.submit();"
                                            class="navi-link">
                                            <span class="navi-icon">
                                                <i class="fa fa-file-export"></i>
                                            </span>
                                            <span class="navi-text">Excel</span>
                                        </a>
                                    </li>
                                </ul>
                                <!--end::Navigation-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table width="100%" class="table table-striped ">
                <thead>
                    </tr>
                    <th> SNo.</th>
                    <th> Name </th>
                    <th> ID </th>
                    <th> Region </th>
                    <th> Zone </th>
                    <th> Woreda </th>
                    <th> Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deployedVolunteers as $key => $deployedVolunteer)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $deployedVolunteer?->trainingPlacement?->approvedApplicant?->volunteer?->name() }}</td>
                            <td>{{ $deployedVolunteer?->trainingPlacement->approvedApplicant->volunteer->id_number }}</td>
                            <td> {{ $deployedVolunteer?->woredaIntake?->woreda?->zone?->region?->name }} </td>
                            <td> {{ $deployedVolunteer->woredaIntake->woreda?->zone?->name }} </td>
                            <td> {{ $deployedVolunteer?->woredaIntake?->woreda?->name }} </td>
                            <td>
                                <a href="#" data-action="{{ route('session.deployment.change', [request()->route('training_session'), $deployedVolunteer->id]) }}" class="btn btn-icon"
                                    onclick="$('#changeDeploymentForm').attr('action',this.dataset.action);onSubmit();">
                                    <span class="fa fa-edit"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex" style="justify-content: space-between;">
            <div class="">
                <span class="mr-5">Total: {{ $deployedVolunteers->total() }}</span>
            </div>
            <div class="">
                {{ $deployedVolunteers->withQueryString()->links() }}
            </div>
            <div>
                <span>Page {{ $deployedVolunteers->currentPage() > 0 ? $deployedVolunteers->currentPage() : 0 }} of
                    {{ ceil($deployedVolunteers->total() / $deployedVolunteers->perPage()) }}</span>
            </div>
        </div>

    </div>

@endsection
@push('js')
    <script>
        $('.select2').select2({});
    </script>

    <script>
        function onSubmit() {

            event.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "This Will change the Deployment Woreda of the Volunteer!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Change it!"
            }).then(function(result) {
                if (result.value) {
                    $('#deploymentWoredaEdit').modal();
                }
            });
        }

        function approvePlacment() {
            event.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "This action will not be reverted!",
                type: "danger",
                showCancelButton: true,
                confirmButtonText: "Yes, Approve!"
            }).then(function(result) {
                if (result.value) {
                    $('#approvePlacmentForm').submit();
                }
            });
        }
    </script>
@endpush
