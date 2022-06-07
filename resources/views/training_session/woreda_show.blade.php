@extends('layouts.app')
@section('title', 'Center base detail')
@push('css')
    <style>
        .select2,
        .select2-container,
        .select2-container--default,
        .select2-container--below {
            width: 100% !important;
        }
    </style>
@endpush
@section('content')
    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        {{-- <div cl --}}
        <div class="card-body">
            <div class="d-flex">
                <!--begin: Pic-->
                <div class="flex-shrink-0 mt-3 mr-7 mt-lg-0">
                    <div class="symbol symbol-50 symbol-lg-120">
                        <h3>{{ $woreda->name }}</h3>
                        <a href="">
                            <i class="ml-2 flaticon2-location text-success icon-md"></i>
                            {{ $woreda->zone->name }} - {{ $woreda->zone->region->name }}
                        </a>
                    </div>
                </div>
                <!--end: Pic-->
                <!--begin: Info-->
                <div class="flex-grow-1">
                    <!--begin: Title-->
                    <div class="flex-wrap d-flex align-items-center justify-content-end">
                        {{-- <div class="my-1 my-lg-0">
                            <div class="dropdown dropdown-inline">
                                <a href="#" class="px-5 btn btn-sm btn-primary font-weight-bolder dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Emport/Export
                                    Volunteers</a>
                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="">
                                    <!--begin::Navigation-->
                                    <ul class="navi navi-hover">
                                        <li class="navi-item">
                                            <a data-toggle="modal" data-target="#import" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="fa fa-file-import"></i>
                                                </span>
                                                <span class="navi-text">Import</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="{{ route('session.volunteer.export', ['training_session' => Request::route('training_session')->id, 'training_center' => $woreda->id]) }}"
                                                class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="fa fa-file-export"></i>
                                                </span>
                                                <span class="navi-text">Export</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!--end::Navigation-->
                                </div>
                            </div>
                        </div> --}}
                        <div class="my-1 my-lg-0">
                            <div class="dropdown dropdown-inline">
                                <a href="#" class="px-5 btn btn-sm btn-primary font-weight-bolder dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</a>
                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="">
                                    <!--begin::Navigation-->
                                    <ul class="navi navi-hover">
                                        <li class="navi-item">
                                            <a href=""
                                                class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="flaticon2-shopping-cart-1"></i>
                                                </span>
                                                <span class="navi-text">Resources</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href=""
                                                class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="fa fa-users"></i>
                                                </span>
                                                <span class="navi-text">Checked In List</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href=""
                                                class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="flaticon2-shopping-cart-1"></i>
                                                </span>
                                                <span class="navi-text">Trainners List</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" onclick="confirmPlacment()" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="fal fa-map-marker-check"></i>
                                                </span>
                                                <span class="navi-text">Place Volunteers</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href=""
                                                class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="fal fas fa-graduation-cap"></i>
                                                </span>
                                                <span class="navi-text">Graduate Volunteers</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!--end::Navigation-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end: Title-->
                    <!--begin: Content-->
                    {{-- <div class="flex-wrap d-flex align-items-center justify-content-between">
                    <div class="py-5 mr-5 flex-grow-1 font-weight-bold text-dark-50 py-lg-2 w-100">
                        {{ $woreda->description ?? 'There is no description of the center' }}
                        <br />
                    </div>
                    <div class="flex-wrap py-2 d-flex align-items-center">
                        <div class="mr-10 d-flex align-items-center">
                            <div class="mr-6">
                                <div class="mb-2 font-weight-bold">Start Date</div>
                                <span
                                    class="btn btn-sm btn-text btn-light-primary text-uppercase font-weight-bold">{{ Request::route('training_session')->startDateET() }}</span>
                            </div>
                            <div class="">
                                <div class="mb-2 font-weight-bold">Due Date</div>
                                <span
                                    class="btn btn-sm btn-text btn-light-primary text-uppercase font-weight-bold">{{ Request::route('training_session')->endDateET() }}</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 mt-4 flex-grow-1 w-150px w-xl-300px mt-sm-0">
                            <span class="font-weight-bold">Progress</span>
                            <div class="mt-2 mb-2 progress progress-xs">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 63%;"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="font-weight-bolder text-dark">78%</span>
                        </div>
                    </div>
                </div> --}}
                    <!--end: Content-->
                </div>
                <!--end: Info-->
            </div>
            <div class="separator separator-solid my-7"></div>
            <!--begin: Items-->
            {{-- <div class="flex-wrap d-flex align-items-center">
            <!--begin: Item-->
            <div class="my-1 mr-5 d-flex align-items-center flex-lg-fill">
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
            <div class="my-1 mr-5 d-flex align-items-center flex-lg-fill">
                <span class="mr-4">
                    <i class="flaticon-confetti icon-2x text-muted font-weight-bold"></i>
                </span>
                <div class="d-flex flex-column text-dark-75">
                    <span class="font-weight-bolder font-size-sm">Checked In Volunteers</span>
                    <span class="font-weight-bolder font-size-h5">
                        <span class="text-dark-50 font-weight-bold"></span>{{ count($checkedInVolunteers) }}</span>
                </div>

            </div>
            <!--end: Item-->
            <!--begin: Item-->
            <div class="my-1 mr-5 d-flex align-items-center flex-lg-fill">
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
            <div class="my-1 mr-5 d-flex align-items-center flex-lg-fill">
                <span class="mr-4">
                    <i class="flaticon-file-2 icon-2x text-muted font-weight-bold"></i>
                </span>
                <div class="d-flex flex-column flex-lg-fill">
                    <span class="text-dark-75 font-weight-bolder font-size-sm">Total Resource</span>
                    <a href="#"
                        class="text-primary font-weight-bolder">{{ $woreda->resources()->count() }}</a>
                </div>
            </div>
            <!--end: Item-->
        </div> --}}
            <!--begin: Items-->
        </div>
    </div>
    <!--end::Card-->
@endsection
@push('js')
    <script>
        $('.select2').select2({
            allowClear: true
        });

        @if (old('training') != null)
            $('#assignMasterModal').modal().show()
        @endif

        function confirmPlacment() {
            Swal.fire({
                title: "Are you sure?",
                text: "You are able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, place volunteers!"
            }).then(function(result) {
                if (result.value) {
                    $('#placeVolunteerForm').submit();
                }
            });
        }

        function confirmDeleteMasterPlacement(masterId) {
            var sessionId = '{{ Request::route('training_session')->id }}';
            $('#deleteForm').attr('action', '/' + sessionId + '/training_master_placement/' + masterId);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $('#deleteForm').submit();
                }
            });
        }

        function confirmDeleteCoordinator(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $("#centerCoordinator").html(`<option value="${id}"></option>`);
                    $('#centerCoordinatorForm').submit();
                }
            });
        }

        function confirmDeleteChecker(checkerId) {
            $('#checkerUserRemove').val(checkerId);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $('#removeCheckerForm').submit();
                }
            });
        }

        function confirmDeleteRoom(route) {
            $('#deleteRoomForm').attr('action', route);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $('#deleteRoomForm').submit();
                }
            });
        }
    </script>
@endpush
