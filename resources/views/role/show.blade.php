@extends('layouts.app')
@section('title', 'Role detail')
@section('breadcrumb-list')
    <li class=""><a href="{{ route('role.index', []) }}">Roles</a></li>
    <li class="active">{{ $role->name }}</li>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-duallistbox.min.css') }}" />
    <!-- page specific plugin styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-multiselect.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}" />
@endpush
@push('js')
    <script src="{{ asset('assets/js/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.raty.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-multiselect.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-typeahead.js') }}"></script>
    <script>
        $(function() {
            var demo1 = $('select[name="permission_list[]"]').bootstrapDualListbox({
                infoTextFiltered: '<span class="label label-purple label-lg">Filtered</span>',
            });

        })
    </script>
@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Permissions List</h3>
        </div>
        <div class="p-0 card-body">
            <div class="px-2 m-1">
                <form action="{{ route('roles.permissions.give', ['role' => $role->id]) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        {{-- <label class="col-sm-2 control-label no-padding-top" for="duallist"> Select Permission </label> --}}

                        <div class="col-sm-12">
                            <select multiple="multiple" size="10" name="permission_list[]" id="duallist">
                                @foreach ($permissions as $key => $permission)
                                    <option value="{{ $permission->id }}" selected>{{ $permission->name }}</option>
                                @endforeach
                                @foreach ($freePermissions as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>
                            <div class="hr hr-16 hr-dotted"></div>
                            <button class="btn btn-primary">
                                <i class="fal fa-plus"></i>
                                Update Permission List
                            </button>
                        </div>
                    </div>
                </form>
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
@endsection
