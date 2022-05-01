@extends('layouts.app')

@section('content')
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('sweetalert/sweetalert.css') }}">
@endpush
<x-slot name="title">All Roles</x-slot>
<x-slot name="breadcrumbTitle">All roles</x-slot>
<div class="py-2 pr-4">
    <a href="{{ route('role.create') }}" class="float-right"><i class="fal fa-plus"></i></a>
    <div class="clearfix"></div>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Roles</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="p-0 card-body">
        <table class="table table-striped projects">
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
                            <a class="btn btn-sm" href="{{ route('role.show', ['role' => $role->id]) }}">
                                <i class="fad fa-eye">
                                </i>
                            </a>
                            <a class="btn btn-sm" href="{{ route('role.edit', ['role' => $role->id]) }}">
                                <i class="fal fa-pencil-alt">
                                </i>
                            </a>
                            <a class="btn btn-sm" href="#" onclick="deleteRole({{ $role->id }});">
                                <i class="fad fa-trash">
                                </i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>

<form method="POST" id="deleteForm">
    @method('delete')
    @csrf
</form>
@push('scripts')
    <script src="{{ asset('sweetalert/sweetalert.min.js') }}"></script>
    <script>
        function deleteRole(roleId) {
            var url = '/role/' + roleId;
            $('#deleteForm').attr('action', url);
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                icon: 'warning',
                buttons: {
                    cancel: true,
                    delete: 'Yes, Delete It'
                },
            }).then(
                function(isConfirm) {
                    if (isConfirm) {
                        $('#deleteForm').submit()
                    }
                    return false;
                }
            )
        }
    </script>
@endpush



@endsection
