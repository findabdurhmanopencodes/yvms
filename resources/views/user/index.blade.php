@extends('layouts.app')
@section('title', 'All Users')
@section('breadcrumbList')
    <li class="breadcrum-item active">Users</li>
@endsection
@push('js')
    <script>
        $(function() {
            var datatable = $('#kt_datatable').KTDatatable({
                "columns": [{
                        "width": "25px"
                    },
                    {
                        "width": "25px"
                    }
                ],
            });
            // var table = $('#kt_datatable');

            // begin first table
            // table.DataTable({
            //     responsive: true,
            //     pageLength: 10,
            // })
        });
    </script>
@endpush
@section('content')
    <div class="py-2 pr-4">
        <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add User</a>
    </div>
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">List of Users</h3>
            </div>
            <div class="card-toolbar">

                <!--begin::Button-->
                <a href="{{ route('user.create', []) }}" class="btn btn-primary font-weight-bolder">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <i class="fal fa-plus"></i>
                        <!--end::Svg Icon-->
                    </span>Add New User</a>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Full Name
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <a>{{ $user->name() }}</a>
                            </td>
                            <td>
                                <a>{{ $user->email }}</a>
                            </td>
                            <td class="text-right project-actions">
                                <a class="btn btn-sm  btn-primary" href="{{ route('user.show', ['user' => $user->id]) }}">
                                    <i class="fa fa-eye">
                                    </i>
                                </a>
                                <a class="btn btn-sm  btn-primary" href="{{ route('user.edit', ['user' => $user->id]) }}">
                                    <i class="fa fa-pencil">
                                    </i>
                                </a>
                                <a class="btn btn-danger btn-sm" href="#" onclick="deleteUser({{ $user->id }},this);">
                                    <i class="fa fa-trash">
                                    </i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    @empty($users)
                        <tr>
                            <td colspan="3">
                                <b>Users not found</b>
                            </td>
                        </tr>
                    @endempty
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
@endsection
