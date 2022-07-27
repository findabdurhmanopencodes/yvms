@extends('layouts.app')
@section('title', 'All Disability types')
@section('breadcrumb-list')
    <li class="active">Disability Type</li>
@endsection
@section('breadcrumbTitle', 'Disability type')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Disability Types</a>
    </li>
@endsection
@push('js')
    <script>
        var HOST_URL = "{{ route('disablity.index') }}";

        function deleteRegion(disabilityId, parent) {
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
                        url: '/disablity/' + disabilityId,
                        data: {
                            "id": disabilityId,
                            "_method": 'DELETE',
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        dataType: 'json',
                        success: function(data) {
                            $(parent).closest('tr')[0].remove();
                            Swal.fire(
                                "Deleted!",
                                "Disability Type has been deleted.",
                                "success"
                            )
                        },
                        error: function(data) {
                            if (data.status) {
                                Swal.fire("Forbidden!", "You can't delete this Disability Type!", "error");
                            }
                        }
                    });
                }
            });
        }
    </script>
    <script>
        $( document ).ready(function() {

        });

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
                    var disabilityId = row.id;
                    return '\
                                    <div class="d-flex">\
                                                <a href="javascript:;" onclick="deleteRegion(' + disabilityId + ',$(this))" class="btn btn-sm btn-clean btn-icon" >\
                                                    <i class="far fa-trash"></i>\
                                                </a>\
                                                \
                                                <a href="/disability/' + disabilityId + '/edit" class="btn btn-sm btn-clean btn-icon" >\
                                                    <i class="far fa-pen"></i>\
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
                <h3 class="card-label">List of disability type
                    <span class="text-muted pt-2 font-size-sm d-block">Disability Types</span>
                </h3>
            </div>
            <div class="card-toolbar">

                <!--begin::Button-->
                <a href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#exampleModal">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <i class="fal fa-plus"></i>
                        <!--end::Svg Icon-->
                 </span>
                 Add New Disability Type</a>
                <form method="POST" action="{{ route('disablity.store', []) }}">
                        @csrf
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg"  role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add new Disability Type</h5>
                                        <button type="button" class="close" data-dismiss="modal" -label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card-body">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="col-lg-6">
                                                        <label>Name:</label>
                                                        <input type="text" class="form-control" placeholder="name" name="name"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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



{{-- @extends('layouts.app')
@push('css')  
@endpush
@section('content')

<div class="py-2 pr-4">
    <a href="{{ route('educational_level.create') }}" class="float-right btn btn-sm btn-primary"><i class="fal fa-plus"></i>
        Add Level of Education</a>
    <div class="clearfix"></div>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Level of Education</h3>
    </div>
    <div class="p-0 card-body">
        <table class="table table-striped table-striped table-bordered table-hover dataTable no-footer">
            <thead>
                <tr>
                    <th style="width: 1%">#</th>
                    <th style="width: 20%">Name</th>
                    <th style="width: 20%">Created At </th>
                    <th style="width: 10%">Action </th>
                </tr>
            </thead>
            <tbody>
                @if (count($educational_levels) == 0)
                    <tr>
                        <td colspan="4" class="text-center"><b> No educational level available!</b></td>
                    </tr>
                @endif
                @foreach ($educational_levels as $key => $educational_level)
               
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <a>{{ $educational_level->name }}</a>
                        </td>
                        <td>{{ $educational_level->created_at }}</td>
                        <td class="text-right project-actions">
                            <a class="btn btn-sm btn-primary btn-round" href="#"> --}}
                                {{-- {{ route('Level of Education.edit', ['educationalLevel' => $educational_levels->id]) }} --}}
                                {{-- <i class="fa fa-pencil"></i>
                                Edit
                            </a>
                            <a class="btn btn-sm btn-danger btn-round" href="#" onclick="DeleteEducationalLevel({{ $educational_level->id }},this);">
                                <i class="fad fa-trash"></i>
                                Delete
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
@push('js')
    <script>
        function DeleteEducationalLevel(permissionId, parent) {
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
                                "Education level has been deleted.",
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
@endpush
@endsection

@push('js')
    
@endpush --}}


{{-- @extends('layouts.app')
@push('css')  
@endpush
@section('content')

<div class="py-2 pr-4">
    <a href="{{ route('disablity.create') }}" class="float-right btn btn-sm btn-primary"><i class="fal fa-plus"></i>
        Add disablity type </a>
    <div class="clearfix"></div>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Disablity type </h3>
    </div>
    <div class="p-0 card-body">
        <table class="table table-striped table-striped table-bordered table-hover dataTable no-footer">
            <thead>
                <tr>
                    <th style="width: 1%">
                        #
                    </th>
                    <th style="width: 20%">
                        Name
                    </th>
                    <th style="width: 20%">
                        Created At
                    </th>
                    <th style="width: 10%">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @if (count($disablities) == 0)
                    <tr>
                        <td colspan="4" class="text-center"><b> No disablity type available!</b></td>
                    </tr>
                @endif
                @foreach ($disablities as $key => $disablity)
               
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <a>{{ $disablity->name }}</a>
                        </td>
                        <td>{{ $disablity->created_at }}</td>
                        <td class="text-right project-actions">
                            <a class="btn btn-sm btn-primary btn-round" href="#"> --}}
                                {{-- {{ route('Level of Education.edit', ['educationalLevel' => $educational_levels->id]) }} --}}
                                {{-- <i class="fa fa-pencil"></i>
                                Edit
                            </a>
                            <a class="btn btn-sm btn-danger btn-round" href="#" onclick="Deletedisablity({{ $disablity->id }},this);">
                                <i class="fad fa-trash"></i>
                                Delete
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
@push('js')
    <script>
        function Deletedisablity(permissionId, parent) {
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
                                "Education level has been deleted.",
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
@endpush
@endsection

@push('js')
    
@endpush --}}