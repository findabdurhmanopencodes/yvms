@extends('layouts.app')
@section('title', 'Tarif')
@section('breadcrumb-list')
    <li class="active"> Transport tarif</li>
@endsection
@section('breadcrumbTitle', 'Transport tarif')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted"> Payroll List</a>
    </li>
@endsection
@push('js')

@push('js')
    <script>
        var HOST_URL = "{{ route('transportTarif.index') }}";

        function deleteTarif(tarifId, parent) {
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
                        url: '/transportTarif/' + tarifId,
                        data: {
                            "id":tarifId,
                            "_method": 'DELETE',
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        dataType: 'json',
                        success: function(data) {
                            $(parent).closest('tr')[0].remove();
                            Swal.fire(
                                "Deleted!",
                                "Transport tarif  has been deleted.",
                                "success"
                            )
                        },
                        error: function(data) {
                            if (data.status) {
                                Swal.fire("Forbidden!", "You can't delete this tarif!", "error");
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
                width: 50,
                type: 'number',
                selector: false,
                textAlign: 'center',
                template: function(row, index) {
                    return index + 1;
                }
            },
            {
                field: 'price',
                title: 'Tarif in ETB',

            },
            {
                field: 'created_at',
                title: 'Date',
                sortable: 'desc',
                format: 'dd/mm/yyyy'
            },

            {
                field: 'Actions',
                title: 'Actions',
                sortable: false,
                width: 100,
                overflow: 'visible',
                autoHide: false,
                template: function(row) {
                    var tarifId = row.id;
                    return '\
                                    <div class="d-flex">\
                                                <a href="javascript:;" onclick="deleteTarif(' +tarifId + ',$(this))" class="btn btn-sm btn-clean btn-icon" >\
                                                    <i class="far fa-trash"></i>\
                                                </a>\
                                                \
                                                <a href="/transportTarif/' + tarifId + '/edit" class="btn btn-sm btn-clean btn-icon" >\
                                                    <i class="far fa-pen"></i>\
                                                </a>\
                                            </div>\
                                            ';
                },
            }
        ];
    </script>
    <script src="{{ asset('assets/js/pages/crud/ktdatatable/base/data-ajax.js') }}"></script>
@endpush
@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <div class="input-icon">
                    <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                    <span>
                        <i class="flaticon2-search-1 text-muted"></i>
                    </span>
                </div>
                {{-- <h3 class="card-label">List of Transport tarif
                    <span class="text-muted pt-2 font-size-sm d-block">Tarif </span>
                </h3> --}}
            </div>
            <div class="card-toolbar">

                <!--begin::Button-->
                <a href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#exampleModal">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <i class="fal fa-plus"></i>
                        <!--end::Svg Icon-->
                 </span>
              <i class="fa fa-usd"> </i>  Add tarif </a>
                <form method="POST" action="{{ route('transportTarif.store', []) }}">
                        @csrf
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md"  role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"> How much birr per a Killo Meter? </h5>
                                        <button type="button" class="close" data-dismiss="modal" -label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="card-body">


                                             <div class="form-group col-12">
                                               <h3>    1KM =? Birr</h3>
                                               </div>

                                            <div class="form-group col-12">
                                                <input type="text" name="price" class="form-control" placeholder="Enter total birr" required>
                                               </div>



                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary font-weight-bold">Save </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
        </div>

        <div class="m-auto col-6 mt-3">
         {{ $tarifs->withQueryString()->links() }}
        </div>
    </div>
@endsection
