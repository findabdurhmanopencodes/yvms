@extends('layouts.app')
@section('title', 'Regions')
@section('breadcrumb-list')
    <li class="active">Regions</li>
@endsection

@section('content')
    <div class="py-2 pr-4">
        <a href="{{ route('region.create') }}" class="float-right btn btn-sm btn-primary"><i class="fal fa-plus"></i>
            Add Region</a>
        <div class="clearfix"></div>
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
                            <td class="text-right project-actions">
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
