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
<form method="POST" action="{{ route('session.import.deployment_attendance', ['training_session' => Request::route('training_session')->id, 'woreda' => Request::route('woreda')->id]) }}" enctype="multipart/form-data">
    @csrf
    <div style="z-index: 9999999;" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import File</h5>
                    <button type="button" class="close" data-dismiss="modal" -label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Attendance File: </label>
                                    <input type="file" name="attendance"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
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
                        <div class="my-1 my-lg-0">
                            <div class="dropdown dropdown-inline">
                                <a href="#" class="px-5 btn btn-sm btn-primary font-weight-bolder dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</a>
                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="">
                                    <!--begin::Navigation-->
                                    <ul class="navi navi-hover">
                                        <li class="navi-item">
                                            <a href="{{ route('session.deployment_attendance.export', ['training_session'=> Request::route('training_session')->id, 'woreda' => Request::route('woreda')->id]) }}" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="flaticon2-shopping-cart-1"></i>
                                                </span>
                                                <span class="navi-text">Export Attendance</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="" class="navi-link" data-toggle="modal" data-target="#exampleModal">
                                                <span class="navi-icon">
                                                    <i class="fa fa-users"></i>
                                                </span>
                                                <span class="navi-text">Import Attendance</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="" class="navi-link">
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
                                            <a href="" class="navi-link">
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
                </div>
                <!--end: Info-->
            </div>
            <div class="separator separator-solid my-7"></div>
            <!--begin: Items-->
            <div class="flex-wrap d-flex align-items-center">
                <!--begin: Item-->
                <div class="my-1 mr-5 d-flex align-items-center flex-lg-fill">
                    <span class="mr-4">
                        <i class="flaticon-piggy-bank icon-2x text-muted font-weight-bold"></i>
                    </span>
                    <div class="d-flex flex-column text-dark-75">
                        <span class="font-weight-bolder font-size-sm">Total Volunteers</span>
                        <span class="font-weight-bolder font-size-h5">
                            <span class="text-dark-50 font-weight-bold"></span>{{ '2' }}</span>
                    </div>
                </div>
                <!--end: Item-->
            </div>
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
