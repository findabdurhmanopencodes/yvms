@extends('layouts.app')
@section('title', 'All Permissions')
@section('breadcrumbTitle', 'All Permissions')
@section('breadcrumbList')
    <li class="breadcrumb-item active">Permissions</li>
@endsection

@push('js')
    <script>
        var HOST_URL = "{{ route('permission.index') }}";

        function deletePermission(permissionId, parent) {
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
                        url: '/permission/' + permissionId,
                        data: {
                            "id": permissionId,
                            "_method": 'DELETE',
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        dataType: 'json',
                        success: function(data) {
                            $(parent).closest('tr')[0].remove();
                            Swal.fire(
                                "Deleted!",
                                "Permission has been deleted.",
                                "success"
                            )
                        },
                        error: function(data) {
                            if (data.status) {
                                Swal.fire("Forbidden!", "You can't delete this permission!", "error");
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
                    var permissionId = row.id;
                    return '\
                                                <div class="d-flex" style="justify-content: space-between;">\@can('Permission.destroy')
                                                            <a href="javascript:;" onclick="deletePermission(' +
                        permissionId + ',$(this))" class="btn btn-sm btn-clean btn-icon" >\
                                                                <i class="far fa-trash"></i>\
                                                            </a>\@endcan
                                                            \@can('Permission.update')
                                                            <a href="/permission/' + permissionId + '/edit" class="btn btn-sm btn-clean btn-icon" >\
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
                <h3 class="card-label">List of permissions
                    <span class="text-muted pt-2 font-size-sm d-block">Permissions</span>
                </h3>
            </div>
            <div class="card-toolbar">

                <!--begin::Button-->
                @can('Permission.store')
                <a href="{{ route('permission.create', []) }}" class="btn btn-primary font-weight-bolder">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <i class="fal fa-plus"></i>
                        <!--end::Svg Icon-->
                    </span>Add New Permission</a>
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
