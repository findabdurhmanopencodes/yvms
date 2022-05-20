@extends('layouts.app')
@section('title', 'Payroll')
@section('breadcrumb-list')
    <li class="active"> Trainne Payroll</li>
@endsection
@section('breadcrumbTitle', 'Field of study')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted"> Payroll List</a>
    </li>
@endsection
@push('js')
    <script>
        var HOST_URL = "{{ route('payroll.index') }}";

        function deleteRegion(fieldofStudyId, parent) {
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
                        url: '/feild_of_study/' + fieldofStudyId,
                        data: {
                            "id": fieldofStudyId,
                            "_method": 'DELETE',
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        dataType: 'json',
                        success: function(data) {
                            $(parent).closest('tr')[0].remove();
                            Swal.fire(
                                "Deleted!",
                                "Field of study has been deleted.",
                                "success"
                            )
                        },
                        error: function(data) {
                            if (data.status) {
                                Swal.fire("Forbidden!", "You can't delete this payroll!", "error");
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
                title: 'Code',
            },
              
            {
                field: 'training_session',
                title: 'training Session',
             
            },
            {
                field: 'user_id',
                title: 'Creted by',
             
            },
            {
                field: 'created_at',
                title: 'Created at',
                sortable: 'desc',
             
            },

            {
                field: 'Actions',
                title: 'Actions',
                sortable: false,
                width: 100,
                overflow: 'visible',
                autoHide: false,
                template: function(row) {
                    var payroll = row.id;
                    return '\
                <div class="d-flex">\
                            <a href="javascript:;" onclick="deleteRegion(' + payroll + ',$(this))" class="btn btn-sm btn-clean btn-icon" >\
                                <i class="far fa-trash"></i>\
                            </a>\
                            \
                            <a href="/fieldofstudy/' + payroll + '/edit" class="btn btn-sm btn-clean btn-icon" >\
                                <i class="far fa-pen"></i>\
                            </a>\
                            \
                            <a href="/fieldofstudy/' +payroll+ '/edit" class="btn btn-sm btn-clean btn-icon" >\
                                <i class="far fa-list"></i>\
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
                <h3 class="card-label">List of Payrolls
                    <span class="text-muted pt-2 font-size-sm d-block">Payrools</span>
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
                 Create new payroll </a>
                <form method="POST" action="{{ route('payroll.store', []) }}">
                        @csrf
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg"  role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add new Field of study</h5>
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
@endsection