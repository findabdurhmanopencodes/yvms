@extends('layouts.app')
@section('title', 'All resources')
@section('breadcrumbList')
    <li class="active">resources</li>
@endsection
@section('breadcrumbTitle', 'resources')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Resources</a>
    </li>
@endsection

@push('js')
    <script>
        var HOST_URL = "{{ route('resource.index') }}";

        function deleteresource(resourceId, parent) {
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
                        url: '/resource/' + resourceId,
                        data: {
                            "id": resourceId,
                            "_method": 'DELETE',
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        dataType: 'json',
                        success: function(data) {
                            $(parent).closest('tr')[0].remove();
                            Swal.fire(
                                "Deleted!",
                                "resource has been deleted.",
                                "success"
                            )
                        },
                        error: function(data) {
                            if (data.status) {
                                Swal.fire("Forbidden!", "You can't delete this resource!", "error");
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
                    var resourceId = row.id;
                    return '\
                                                    <div class="d-flex">\
                                                                <a href="javascript:;" onclick="deleteresource(' +
                        resourceId + ',$(this))" class="btn btn-sm btn-clean btn-icon" >\
                                                                    <i class="far fa-trash"></i>\
                                                                </a>\
                                                                \
                                                              \
                                                                </a>\
                                                                <a href="/resource/' + resourceId + '/edit" class="btn btn-sm btn-clean btn-icon" >\
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

<div id="assignResource" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('resource.assign') }}" method="post">
            @csrf
            <input type="hidden" name="resource_id" value="{{ $resource->id }}">
            <input type="hidden" id="training_center_id" name="training_center_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bg-red-600">Assign {{ $resource->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div>
                        <label>Amount:</label>
                        <input type="number" name="amount" class="form-control">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Submit</button>

                </div>
            </div>
        </form>
    </div>
</div>
@section('content')
    <div class="card">

        <div class="card-body">
            <h5 class="card-title"><span class="text text-primary">{{ $resource->name }}</span> Resource Allocation
                For
                Universities</h5>
            <ul class="list-group">

                @foreach ($trainingCenters as $trainingCenter)
                    <li class="h4">
                        {{ $trainingCenter->name }} ({{ $trainingCenter->code }})
                        <div class="list-group-item d-flex justify-content-md-between">
                            <span
                                class="badge badge-primary badge-pill">{{ $trainingCenter->resources == null ? $trainingCenter->resources()->latest() : '0 item' }}</span>
                            @if ($trainingCenter->resource == null)
                                <a class="btn btn-primary" data-toggle="modal" data-target="#assignResource" onclick="getCenterId({{$trainingCenter->id }});"><i
                                        class="fa fa-plus"></i>Add</a>
                            @else
                                <a class="btn btn-warning"><i class="fa fa-edit"></i>Edit</a>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function getCenterId(training_center) {
            console.log(training_center)
            $('#training_center_id').val(training_center);
        }
    </script>
@endpush
