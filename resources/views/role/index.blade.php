@extends('layouts.app')
@section('title', 'Roles')
@section('breadcrumb-list')
    <li class="active">Roles</li>
@endsection
@push('js')
    <script>
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
@endpush
@section('content')
    <div class="py-2 pr-4">
        <a href="{{ route('role.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add Role</a>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Roles</h3>
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
    </div>
@endsection
