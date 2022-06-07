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
                        <div class="my-1 my-lg-0">
                            <div class="dropdown dropdown-inline">
                                <a href="#" class="px-5 btn btn-sm btn-primary font-weight-bolder dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</a>
                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="">
                                    <!--begin::Navigation-->
                                    <ul class="navi navi-hover">
                                        <li class="navi-item">
                                            <a href="" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="flaticon2-shopping-cart-1"></i>
                                                </span>
                                                <span class="navi-text">Resources</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="fa fa-users"></i>
                                                </span>
                                                <span class="navi-text">Checked In List</span>
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
