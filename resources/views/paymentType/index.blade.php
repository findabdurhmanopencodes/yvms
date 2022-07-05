@extends('layouts.app')
@section('title', 'Payment type')
@section('breadcrumb-list')
    <li class="active"> Payment type </li>
@endsection
@section('breadcrumbTitle','Payment type ')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted"> Payment type </a></a>
    </li>
@endsection
@push('js')
    <script>
        var HOST_URL = "{{ route('paymentType.index') }}";

        function deletepaymentType(paymentTypeId, parent) {
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
                        url: '/paymentType/' + paymentTypeId,
                        data: {
                            "id": paymentTypeId,
                            "_method": 'DELETE',
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        dataType: 'json',
                        success: function(data) {
                            $(parent).closest('tr')[0].remove();
                            Swal.fire(
                                "Deleted!",
                                "Payment type has been deleted.",
                                "success"
                            )
                        },
                        error: function(data) {
                            if (data.status) {
                                Swal.fire("Forbidden!", "You can't delete this payment type!", "error");
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
                sortable: 'desc',
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
            },

            {
                field: 'amount',
                title: 'Amount',
            },
            {
                field: 'created_at',
                title: 'Last update',
            },

            {
                field: 'Actions',
                title: 'Actions',
                sortable: false,
                width: 100,
                overflow: 'visible',
                autoHide: false,
                template: function(row) {
                    var paymentTypeId = row.id;
                    return '\
                                               <div class="d-flex">\
                                                <a href="javascript:;" onclick="deletepaymentType(' +paymentTypeId+ ',$(this))" class="btn btn-sm btn-clean btn-icon" >\
                                                    <i class="far fa-trash"></i>\
                                                </a>\
                                                \
                                                <a href="/paymentType/' +paymentTypeId+ '/edit" class="btn btn-sm btn-clean btn-icon" >\
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
                <h3 class="card-label">List of  payment type
                    <span class="text-muted pt-2 font-size-sm d-block">Payment</span>
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
                 New payment type</a>
                <form method="POST" action="{{ route('paymentType.store', []) }}">
                        @csrf
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg"  role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add payment Type</h5>
                                        <button type="button" class="close" data-dismiss="modal" -label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card-body">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="col-lg-6">
                                                        <label>Payment type:</label>
                                                        <input type="text" class="form-control"  name="name"/>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <label>Amount:</label>
                                                        <input type="text" class="form-control" placeholder="Leave for transportation" name="amount"/>
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

            {{-- <table width="100%" class="table table-striped ">
                <thead>
                    </tr>
                    <th> #</th>

                    <th> Payment type</th>
                    <th> Amount </th>
                    <th> Description </th>
                  <th>Action </th>

                    </tr>
                </thead>
                <tbody>

                    @foreach($paymentTypes  as $key =>  $paymentType )
                        <tr>
                                 <td> {{ $key + 1 }}</td>
                                 <td> {{ $paymentType->name }} </td>
                                 <td> {{ $paymentType->amount }} </td>
                                 <td> - </td>
                            </td>
                            <td>

                                <a href="javascript:;" onclick="deletepaymentType(' +paymentType + ',$(this))" class="btn btn-sm btn-clean btn-icon" >
                                    <i class="far fa-trash"></i>
                                </a>


                                 <a href="#"
                                    class="btn btn-icon">
                                    <span class="fa fa-edit"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}
            <!--begin: Datatable-->
        <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
            <!--end: Datatable-->
        </div>
    </div>
@endsection
