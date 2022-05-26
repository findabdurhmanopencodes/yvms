@extends('layouts.app')
@section('title', 'Payroll')
@section('breadcrumb-list')
    <li class="active"> Trainne Payroll</li>
@endsection
@section('breadcrumbTitle', 'Payroll')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted"> Payroll List</a>
    </li>
@endsection
@push('js')
    <script>
        var HOST_URL = "{{ route('payroll.index') }}";

        function deletePayroll(payrollId, parent) {
            event.preventDefault();
            Swal.fire({
                title: "Are you sure to delete this payroll?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: '/payroll/' +payrollId,
                        data: {
                            "id": payrollId,
                            "_method": 'DELETE',
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        dataType: 'json',
                        success: function(data) {
                            $(parent).closest('tr')[0].remove();
                            Swal.fire(
                                "Deleted!",
                                "Payroll has been deleted.",
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



    <script src="{{ asset('assets/js/pages/crud/ktdatatable/base/data-ajax.js') }}"></script>
@endpush
@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">List of Payrolls
                    <span class="text-muted pt-2 font-size-sm d-block">Payroll </span>
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
              <i class="fa fa-usd"> </i>   Create new payroll </a>
                <form method="POST" action="{{ route('payroll.store', []) }}">
                        @csrf
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg"  role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Create payroll </h5>
                                        <button type="button" class="close" data-dismiss="modal" -label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="card-body">
                                  <span style="font-size:16px;">
                                    Here you have to create payroll for a specific training session in order to create payroll sheet for each training center!
                                   </span>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary font-weight-bold">Create</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <table width="100%" class="table table-striped ">
                <thead>
                    </tr>
                    <th> #</th>
                    <th> Code </th>
                    <th> Training Session </th>
                    <th> Created by </th>
                    <th>  Created at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payrolls as $key => $payroll)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $payroll->name }}</td>
                            <td>{{ $payroll->training_session_id }} </td>
                            <td>{{ $payroll->user_id }} </td>
                            <td>{{ $payroll->created_at }}</td>
                            <td>
                            <a href=" {{ route('payrollSheet.index', ['payroll_id'=>$payroll->id]) }}"


                                class="btn btn-icon">
                                <span class="fa fa-list"></span>
                            </a>
                            <a href="javascript:;" onclick="deletePayroll(' +payroll+ ',$(this))" class="btn btn-sm btn-clean btn-icon"
                                class="btn btn-icon">
                                <span class="fa fa-trash"></span>
                            </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="m-auto col-6 mt-3">
         {{ $payrolls->withQueryString()->links() }}
        </div>
    </div>
@endsection
