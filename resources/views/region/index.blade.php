@extends('layouts.app')
@section('title', 'Regions')
@section('breadcrumb-list')
    <li class="active">Regions</li>
@endsection

@section('content')
    {{-- <div class="py-2 pr-4">
        <a href="{{ route('region.create') }}" class="float-right btn btn-sm btn-primary"><i class="fal fa-plus"></i>
            Add Region</a>
        <div class="clearfix"></div>
    </div> --}}
    <div class="py-2 pr-4">
        <a href="#my-region-form" role="button" class="pull-right btn btn-sm btn-primary" data-toggle="modal"><i class="fal fa-plus"></i>
            &nbsp; Add Region &nbsp;
        </a>
        <div class="clearfix"></div>
    </div>

    <div id="my-region-form" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('region.store', []) }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="smaller lighter blue no-margin">Register new region</h3>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="form-region-name" class="col-12 control-label no-padding-right">
                                    Name: <span style="color: red;"></span>
                                </label>
    
                                <div class="col-12">
                                    <input type="text" id="form-region-name" placeholder="region name" name="name" required/>
                                    @error('name')
                                        <small class="text-danger"><b>{{ $message }}</b></small>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group col-md-6">
                                <label for="form-region-code" class="col-12 control-label no-padding-right">
                                    Code: <span style="color: red;"></span>
                                </label>
    
                                <div class="col-12">
                                    <input type="text" id="form-region-code" placeholder="region code" name="code" required/>
                                    @error('code')
                                        <small class="text-danger"><b>{{ $message }}</b></small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="ace-icon fa fa-check bigger-110"></i>
                            Submit
                        </button>
                        <button class="btn btn-sm btn-danger pull-right" data-dismiss="modal">
                            <i class="ace-icon fa fa-times"></i>
                            Close
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Regions</h3>
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
                            Code
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
                    @if (count($regions) == 0)
                        <tr>
                            <td colspan="4" class="text-center"><b>No region available!</b></td>
                        </tr>
                    @endif
                    @foreach ($regions as $key => $region)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <a>{{ $region->name }}</a>
                            </td>
                            <td>
                                <a>{{ $region->code }}</a>
                            </td>
                            <td>{{ $region->created_at }}</td>
                            <td class="project-actions">
                                <a class="btn btn-sm btn-primary"
                                    href="{{ route('region.edit', ['region' => $region->id]) }}">
                                    <i class="fa fa-pencil">
                                    </i>
                                </a>
                                <a class="btn btn-sm btn-danger" href="#"
                                    onclick="deletePermission({{ $region->id }},this);">
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
    @push('js')
        <script>
            function deletePermission(regionId, parent) {
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
                            url: '/region/' + regionId,
                            data: {
                                "id": regionId,
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

            // function deletePermission(permissionId, item) {
            //     var url = '/permission/' + permissionId;
            //     $('#deleteForm').attr('action', url);
            //     swal({
            //         title: "Are you sure?",
            //         text: "You will not be able to recover this imaginary file!",
            //         icon: 'warning',
            //         buttons: {
            //             cancel: true,
            //             delete: 'Yes, Delete It'
            //         },
            //     }).then(
            //         function(isConfirm) {
            //             if (isConfirm) {
            //                 $('#deleteForm').submit()
            //             }
            //             return false;
            //         }
            //     )
            // }
        </script>
    @endpush
@endsection
