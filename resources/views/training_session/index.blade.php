@extends('layouts.app')
@section('title', 'All Volunteer Programs')
@section('breadcrumb-list')
    <li class="active">Programs</li>
@endsection
@section('breadcrumbTitle', 'Regions')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Programs</a>
    </li>
@endsection

@push('js')
    <script>
        var HOST_URL = "{{ route('training_session.index') }}";

        function deleteTrainingSession(training_sessionId, parent) {
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
                        url: '/training_session/' + training_sessionId,
                        data: {
                            "id": training_sessionId,
                            "_method": 'DELETE',
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        dataType: 'json',
                        success: function(data) {
                            $(parent).closest('tr')[0].remove();
                            Swal.fire(
                                "Deleted!",
                                "Program has been deleted.",
                                "success"
                            )
                        },
                        error: function(data) {
                            if (data.status) {
                                Swal.fire("Forbidden!", "You can't delete this program!", "error");
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
                field: 'start_date',
                title: 'Program start date',
                sortable: 'asc',
            },
            {
                field: 'end_date',
                title: 'Program end date',
                sortable: 'asc',
            },
            {
                field: 'registration_start_date',
                title: 'Registration start date',
                sortable: 'asc',
            },
            {
                field: 'registration_dead_line',
                title: 'Registration end date',
                sortable: 'asc',
            },
            {
                field: 'quantity',
                title: 'Number of Volunteer',
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
                    var training_sessionId = row.id;
                    return '\
                                    <div class="d-flex">\
                                                <a href="javascript:;" onclick="deleteTrainingSession(' + training_sessionId + ',$(this))" class="btn btn-sm btn-clean btn-icon" >\
                                                    <i class="far fa-trash"></i>\
                                                </a>\
                                                \
                                                <a href="/training_session/' + training_sessionId + '/edit" class="btn btn-sm btn-clean btn-icon" >\
                                                    <i class="far fa-pen"></i>\
                                                </a>\
                                                <a href="' + training_sessionId + '/dashboard" class="btn btn-sm btn-clean btn-icon">\
                                                    <i class="flaticon-eye"></i>\
                                                </a>\
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
                <h3 class="card-label">List of programs
                    <span class="text-muted pt-2 font-size-sm d-block">Programs</span>
                </h3>
            </div>
            <div class="card-toolbar">

                <!--begin::Button-->
                <a href="{{ route('training_session.create', []) }}" class="btn btn-primary font-weight-bolder">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <i class="fal fa-plus"></i>
                        <!--end::Svg Icon-->
                    </span>Add New Program</a>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
            <!--end: Datatable-->
        </div>
    </div>
    <!--end::Card-->
    {{-- <div class="py-2 pr-4">
        <a href="{{ route('role.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add Role</a>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"></h3>
        </div>
        <div class="p-0 card-body">
            <table class="table table-striped table-bordered table-hover dataTable no-footer table-striped projects">
                <thead>
                    <tr>
                        <th style="width: 1%">
                            #
                        </th>
                        <th style="width: 20%">
                            Name
                        </th>
                        <th style="width: 20%">
                            Created at
                        </th>
                        <th style="width: 10%">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $key => $role)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <a>{{ $role->name }}</a>
                            </td>
                            <td>{{ $role->created_at }}</td>
                            <td class="text-right project-actions">
                                <a class="btn btn-sm  btn-primary" href="{{ route('role.show', ['role' => $role->id]) }}">
                                    <i class="fa fa-eye">
                                    </i>
                                </a>
                                <a class="btn btn-sm  btn-primary" href="{{ route('role.edit', ['role' => $role->id]) }}">
                                    <i class="fa fa-pencil">
                                    </i>
                                </a>
                                <a class="btn btn-danger btn-sm" href="#" onclick="deleteRole({{ $role->id }},this);">
                                    <i class="fa fa-trash">
                                    </i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    @empty($roles)
                        <tr>
                            <td colspan="3">
                                <b>Roles not found</b>
                            </td>
                        </tr>
                    @endempty
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div> --}}
@endsection
