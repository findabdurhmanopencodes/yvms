@extends('layouts.app')
@section('title', 'All Roles')
@section('breadcrumbList')
    <li class="active">Roles</li>
@endsection
@section('breadcrumbTitle', 'Roles')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Roles</a>
    </li>
@endsection

@push('js')
    <script>
        var HOST_URL = "{{ route('role.index') }}";

        function deleteRole(roleId, parent) {
            event.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: '/role/' + roleId,
                        data: {
                            "id": roleId,
                            "_method": 'DELETE',
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        dataType: 'json',
                        success: function(data) {
                            $(parent).closest('tr')[0].remove();
                            Swal.fire(
                                "Deleted!",
                                "Role has been deleted.",
                                "success"
                            )
                        },
                        error: function(data) {
                            if (data.status) {
                                Swal.fire("Forbidden!", "You can't delete this role!", "error");
                            }
                        }
                    });
                }
            });
        }
    </script>
    <script>
        var COLUMNS = [{
                field: 'id',
                title: '#',
                sortable: 'asc',
                width: 30,
                type: 'number',
                selector: false,
                textAlign: 'center',
                template: function(row, index) {
                    return index + 1;
                }
            },
            {
                field: 'name',
                title: 'Name',
                sortable: 'asc',
            },
            {
                field: 'Actions',
                title: 'Actions',
                sortable: false,
                width: 100,
                overflow: 'visible',
                autoHide: false,
                template: function(row) {
                    var roleId = row.id;
                    return '\
                                    <div class="d-flex">\@can('Role.destroy')
                                                <a href="javascript:;" onclick="deleteRole(' + roleId + ',$(this))" class="btn btn-sm btn-clean btn-icon" >\
                                                    <i class="far fa-trash"></i>\
                                                </a>\@endcan
                                                \@can('Role.show')
                                                <a href="/role/' + roleId + '" class="btn btn-sm btn-clean btn-icon" >\
                                                    <i class="far fa-eye"></i>\
                                                </a>\@endrole @can('Role.update')
                                                <a href="/role/' + roleId + '/edit" class="btn btn-sm btn-clean btn-icon" >\
                                                    <i class="far fa-pen"></i>\
                                                </a>\@endcan
                                                \
                                            </div>\
                                            ';
                },
            }
        ]
    </script>
    <script src="{{ asset('assets/js/pages/crud/ktdatatable/base/data-ajax.js') }}"></script>
@endpush
@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">List of roles
                    <span class="text-muted pt-2 font-size-sm d-block">Roles</span>
                </h3>
            </div>
            <div class="card-toolbar">

                <!--begin::Button-->
                @can('Role.store')
                <a href="{{ route('role.create', []) }}" class="btn btn-primary font-weight-bolder">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <i class="fal fa-plus"></i>
                        <!--end::Svg Icon-->
                    </span>Add New Role</a>
                @endcan
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
            <!--end: Datatable-->
        </div>
    </div>
@endsection
