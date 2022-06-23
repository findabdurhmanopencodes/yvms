@extends('layouts.app')
@section('title', 'All Training Centers')

@section('breadcrumbTitle', 'Training Centers')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Training Centers</a>
    </li>
@endsection

@push('js')
    <script>
        var HOST_URL = "{{ route('TrainingCenter.index') }}";

        function deleteTainingCenter(trainingCenterId, parent) {
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
                        url: '/TraininingCenter/' + trainingCenterId,
                        data: {
                            "id": trainingCenterId,
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
                field: 'code',
                title: 'Code',
                sortable: 'asc',
            },

            {
                field: 'scale',
                title: 'Payment Scale',
                sortable: 'asc',
            },
            {
                field: 'logo',
                title: 'Logo',



            },

            {
                field: 'Actions',
                title: 'Actions',
                sortable: false,
                width: 100,
                overflow: 'visible',
                autoHide: false,
                template: function(row) {
                    var trainingCenterId = row.id;
                    return '\
                                        <div class="d-flex">\
                                                    <a href="javascript:;" onclick="deleteTainingCenter(' + trainingCenterId + ',$(this))" class="btn btn-sm btn-clean btn-icon" >\
                                                        <i class="far fa-trash"></i>\
                                                    </a>\
                                                    \
                                                    <a href="/TrainingCenter/' + trainingCenterId + '" class="btn btn-sm btn-clean btn-icon" >\
                                                        <i class="far fa-"></i>\
                                                    </a>\
                                                    <a href="/TrainingCenter/' + trainingCenterId + '/edit" class="btn btn-sm btn-clean btn-icon" >\
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
                <h3 class="card-label">List of Training Centers
                    <span class="text-muted pt-2 font-size-sm d-block">Training Centers </span>
                </h3>
            </div>
            <div class="card-toolbar">

                <!--begin::Button-->
                <a href="{{ route('TrainingCenter.create', []) }}" class="btn btn-primary font-weight-bolder">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <i class="fal fa-plus"></i>
                        <!--end::Svg Icon-->
                    </span>Add New Training Center</a>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
            <!--end: Datatable-->
        </div>
    </div>

@endsection
