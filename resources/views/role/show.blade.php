<x-admin-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('sweetalert/sweetalert.css') }}">
        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">

    @endpush
    <x-slot name="title">Permission of {{ $role->name }}</x-slot>
    <x-slot name="breadcrumbTitle">All permissions</x-slot>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Permissions</h3>
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
            <div class="px-2 m-1">
                <form action="{{ route('role.assignPermissionTo', ['role' => $role->id]) }}" method="POST">
                    @csrf
                    <label for="">Select Permission</label>

                    <div class="row">
                        <div class="col-md-9">
                            <select name="permissions[]" id="" class="form-control select2" multiple>
                                @foreach ($freePermissions as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>
                            @error('permissions')
                                <small class="text-danger"><b>{{ $message }}</b></small>
                            @enderror
                        </div>
                        <div class="text-right col-md-3">
                            <button class="btn btn-block btn-outline-primary">
                                <i class="fal fa-plus"></i>
                                Add Permission
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div>
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
                        @if (count($permissions) == 0)
                            <tr>
                                <td colspan="4" class="text-center"><b>No permission available!</b></td>
                            </tr>
                        @endif
                        @foreach ($permissions as $key => $permission)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <a>{{ $permission->name }}</a>
                                </td>
                                <td>{{ $permission->created_at }}</td>
                                <td class="text-right project-actions">
                                    <a class="btn btn-sm" href="#"
                                        onclick="revokePermissionOf({{ $permission->id }});">
                                        <i class="fad fa-trash">
                                        </i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
    </div>

    <form method="POST" id="deleteForm">
        @csrf
    </form>
    @push('scripts')
        <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('sweetalert/sweetalert.min.js') }}"></script>
        <script>
            $(function() {
                $('.select2').select2();
                $('#date').datetimepicker({
                    format: 'L'
                });
            });

            function revokePermissionOf(permissionId) {
                var url = '/role/{{ $role->id }}/revoke/' + permissionId;
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
</x-admin-layout>
