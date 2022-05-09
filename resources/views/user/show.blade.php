@extends('layouts.app')
@section('title', 'User Detail')
@section('breadcrumbTitle', 'User Detail')
@section('breadcrumbList')
    <li class="breadcrumb-item"><a href="{{ route('user.index', []) }}">Users</a></li>
    <li class="breadcrumb-item active">User Detail</li>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        var HOST_URL = "{{ route('user.permission.index', ['user' => $user->id]) }}";
        var COLUMNS = [{
                field: 'id',
                title: '#',
                sortable: 'asc',
                width: 30,
                type: 'number',
                selector: false,
                textAlign: 'center',
                template: function(row, index) {
                    return '<input type="checkbox"  name="reset_permissions[]" value="' + row.id +
                        '" id="permission_' + row.id +
                        '" class="reset_permissions"/>';
                }
            },
            {
                field: 'name',
                title: 'Name',
                sortable: 'asc',
                template: function(row) {
                    return "<label for='permission_" + row.id + "'>" + row.name + "</label>"
                }
            },
        ]
        $(function() {
            $('#select_permission').select2({
                placeholder: "Select a permission"
            });
            $('#reset_permission_button').on('click', function() {
                var checkedNum = $('input[name="reset_permissions[]"]:checked').length;
                if (!checkedNum) {
                    Swal.fire(
                        "Warning!",
                        "Select at least one permission.",
                        "error"
                    );
                } else {
                    $('#revokePermission').submit();

                }
            });
        });

        function revokeAllPermission() {
            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, revoke all permission!"
            }).then(function(result) {
                if (result.value) {
                    $('#formRevokeAllPermission').submit();
                }
            });
        }


        function giveAllPermission() {
            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, give all permission!"
            }).then(function(result) {
                if (result.value) {
                    $('#formGiveAllPermission').submit();
                }
            });
        }

        function deleteUser(permissionId, parent) {
            event.preventDefault();
            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: '/user/' + {{ $user->id }} + '/permission/' + permissionId,
                        data: {
                            "id": permissionId,
                            "_method": 'DELETE',
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        dataType: 'json',
                        success: function(data) {
                            $(parent).closest('tr')[0].remove();
                            swal.fire(
                                "Deleted!",
                                "User has been deleted.",
                                "success"
                            )
                        },
                        error: function(data) {
                            if (data.status) {
                                swal.fire("Forbidden!", "You can't delete this user!", "error");
                            }
                        }
                    });
                }
            });
        }
    </script>
    <script src="{{ asset('assets/js/pages/crud/ktdatatable/base/data-ajax.js') }}"></script>
@endpush
@section('content')
    <form action="{{ route('user.giveAllPermission', ['user' => $user->id]) }}" id="formGiveAllPermission" method="post">
        @csrf
    </form>
    <form action="{{ route('user.removeAllPermission', ['user' => $user->id]) }}" id="formRevokeAllPermission"
        method="post">
        @csrf
    </form>
    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="card-body">
            <!--begin::Details-->
            <div class="d-flex mb-9">
                <!--begin: Pic-->
                <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                    <div class="symbol symbol-50 symbol-lg-120">
                        <img src="{{ $user->getProfilePhoto() }}" alt="{{ $user->name }}" />
                    </div>
                    <div class="symbol symbol-50 symbol-lg-120 symbol-primary d-none">
                        <span class="font-size-h3 symbol-label font-weight-boldest">JM</span>
                    </div>
                </div>
                <!--end::Pic-->
                <!--begin::Info-->
                <div class="flex-grow-1">
                    <!--begin::Title-->
                    <div class="d-flex justify-content-between flex-wrap mt-1">
                        <div class="d-flex mr-3">
                            <a href="{{ $user->hasRole('applicant') ? route('applicant.show', ['applicant' => $user->volunteer->id]) : '#' }}"
                                class="text-dark-75 text-hover-primary font-size-h5 font-weight-bold mr-3">{{ $user->name }}</a>
                            <a href="#">
                                <i
                                    class="{{ $user->email_verified_at != null ? 'flaticon2-correct' : '' }} text-success font-size-h5"></i>
                            </a>
                        </div>
                        <div class="my-lg-0 my-3">
                            <a href="{{ route('user.edit', ['user' => $user->id]) }}"
                                class="btn btn-sm btn-light-success font-weight-bolder text-uppercase mr-3">

                                Edit
                            </a>

                            @if ($user->hasRole('applicant'))
                                <a href="{{ route('applicant.show', ['applicant' => $user->volunteer->id]) }}"
                                    class="btn btn-sm btn-light-primary font-weight-bolder text-uppercase mr-3">
                                    My Appication
                                </a>
                            @endif
                        </div>
                    </div>
                    <!--end::Title-->
                    <!--begin::Content-->
                    <div class="d-flex flex-wrap justify-content-between mt-1">
                        <div class="d-flex flex-column flex-grow-1 pr-8">
                            <div class="mb-4 col-md-5">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="font-weight-bold mr-2">Email:</span>
                                    <a href="#" class="text-muted text-hover-primary"> {{ $user->email }}</a>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="font-weight-bold mr-2">Role:</span>
                                    <span class="text-muted">{{ Str::ucfirst($user->roles[0]->name) }}</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="font-weight-bold mr-2">Gender:</span>
                                    <span class="text-muted">{{ $user->getGender() }}</span>
                                </div>
                                @if ($user->hasRole('applicant'))
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="font-weight-bold mr-2">Woreda:</span>
                                        <span class="text-muted">{{ $user->volunteer->woreda->name }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div>

                        </div>
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->
            <div class="separator separator-solid"></div>
            <!--begin::Items-->
            <div>
                <div class="mt-5">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <div class="row align-items-center">
                                <form action="{{ route('user.permission.give', ['user' => $user->id]) }}"
                                    class="col-12 row" method="POST">
                                    <div class="col-md-10">
                                        <div class="row align-items-center">
                                            <div class="col-md-12 my-2 my-md-0">
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <select
                                                            class="form-control select2 @error('permission') is-invalid @enderror"
                                                            id="select_permission" multiple name="permissions[]">
                                                            <option value=""></option>
                                                            @foreach ($freePermissions as $permission)
                                                                <option value="{{ $permission->id }}">
                                                                    {{ $permission->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('permission')
                                                            <div class="fv-plugins-message-container">
                                                                <div data-field="permission" data-validator="stringLength"
                                                                    class="fv-help-block">{{ $message }}</div>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @csrf
                                    <div class="col-md-2 mt-5 mt-lg-0">
                                        <input type="submit" class="btn btn-light-primary px-6 font-weight-bold"
                                            value="Assign Permission">
                                    </div>
                                </form>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary px-6 font-weight-bold" onclick="giveAllPermission();">Give
                                    All
                                    Permission</button>
                                <button class="btn btn-danger px-6 font-weight-bold" onclick="revokeAllPermission();">Remove
                                    All
                                    Permission</button>
                            </div>
                            <div class="mt-4">
                                <form id="revokePermission"
                                    action="{{ route('user.permission.revoke', ['user' => $user->id]) }}" method="POST">
                                    @csrf
                                    <div class="d-flex justify-between my-2">
                                        <h3 class="">Manage direct permissions</h3>
                                    </div>
                                    <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
                                    <div class="d-flex mt-8">
                                        <button onclick="event.preventDefault()" id="reset_permission_button"
                                            class="btn btn-danger ml-auto mt-1">Remove Selected Permissions</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--begin::Items-->
        </div>
    </div>
    <!--end::Card-->
@endsection
{{--  --}}
