@extends('layouts.app')
@section('title', 'Zones')
@section('breadcrumb-list')
    <li class="active">Zones</li>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('content')
    <div class="py-2 pr-4">
        {{-- <a href="{{ route('permission.create') }}" class="float-right btn btn-sm btn-primary"><i class="fal fa-plus"></i>
            Add Permission</a>
        <div class="clearfix"></div> --}}
    </div>
    <div class="py-2 pr-4">
        <a href="#my-zone-form" role="button" class="pull-right btn btn-sm btn-primary" data-toggle="modal"><i class="fal fa-plus"></i>
            &nbsp; Add Zone &nbsp;
        </a>
        <div class="clearfix"></div>
    </div>

    <div id="my-zone-form" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('zone.store', []) }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="smaller lighter blue no-margin">Register new region</h3>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="form-zone-name" class="col-12 control-label no-padding-right">
                                    Name: <span style="color: red;"></span>
                                </label>
    
                                <div class="col-12">
                                    <input type="text" id="form-zone-name" placeholder="zone name" name="name" required/>
                                    @error('name')
                                        <small class="text-danger"><b>{{ $message }}</b></small>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group col-md-4">
                                <label for="form-zone-code" class="col-12 control-label no-padding-right">
                                    Code: <span style="color: red;"></span>
                                </label>
    
                                <div class="col-12">
                                    <input type="text" id="form-zone-code" placeholder="region code" name="code" required/>
                                    @error('code')
                                        <small class="text-danger"><b>{{ $message }}</b></small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label for="form-zone-region" class="col-12 control-label no-padding-right">
                                    Region: <span style="color: red;"></span>
                                </label>
    
                                <div class="col-12">
                                    <select class="js-example-basic-single" name="region" data-placeholder="Choose a State...">
                                        <option value=""></option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->code }}</option>
                                        @endforeach
                                      </select>
                                    @error('region')
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
            <h3 class="card-title">Zones</h3>
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
                    @if (count($zones) == 0)
                        <tr>
                            <td colspan="4" class="text-center"><b>No woreda available!</b></td>
                        </tr>
                    @endif
                    @foreach ($zones as $key => $zone)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <a>{{ $zone->name }}</a>
                            </td>
                            <td>
                                <a>{{ $zone->code }}</a>
                            </td>
                            <td>{{ $zone->created_at }}</td>
                            <td class="project-actions">
                                <a class="btn btn-sm btn-primary"
                                    href="{{ route('zone.edit', ['zone' => $zone->id]) }}">
                                    <i class="fa fa-pencil">
                                    </i>
                                </a>
                                <a class="btn btn-sm btn-danger" href="#"
                                    onclick="deletePermission({{ $zone->id }},this);">
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
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });
            // $('.js-data-example-ajax').select2({
            //     ajax: {
            //         url: 'https://api.github.com/search/repositories',
            //         dataType: 'json'
            //         // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            //     }
            // });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            function deletePermission(zoneId, parent) {
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
                            url: '/zone/' + zoneId,
                            data: {
                                "id": zoneId,
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
