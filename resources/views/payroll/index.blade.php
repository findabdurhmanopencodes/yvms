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

@push('css')
<style>
    .select2,
    .select2-container,
    .select2-container--default,
    .select2-container--below {
        width: 100% !important;
    }
</style>
@endpush

<script>
  $( document ).ready(function() {
      $('#training_session').select2({
      });

  });


</script>

    <script src="{{ asset('assets/js/pages/crud/ktdatatable/base/data-ajax.js') }}"></script>
@endpush
@section('content')
    <!--begin::Card-->

    <div class="card card-custom card-body mb-3">




        <form action=""  id="form" method="GET">
        <div class=" ml-1 col-12 p-0">
            <div class="row ">

                <div class="form-group col-8">
                    <select name="training_session" id="training_session"  required="required" class="form-control select2">
                        <option value="">Select Training Session </option>
                        @foreach ($training_sessions as $training_session)
                            <option value="{{ $training_session->id }}"> {{ $training_session->startDateET() }} -   {{ $training_session->endDateET() }} ዓ.ም </option>
                        @endforeach
                    </select>
                </div>





                <div class="form-group col-4">
                    <button class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Filter </button>
                </div>


            </div>
        </div>
    </form>
    </div>



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
              <i class="fa fa-usd"> </i> New payroll </a>
                <form method="POST" action="{{ route('payroll.store', []) }}">
                        @csrf
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md"  role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                       <span styel="text-align:left;">
                                        <strong style="color:red;"><u> Warning </u>! </strong> Do not create duplicate payrolls for a specifice training session.
                                        But, You may create multiple payroll sheet for each training centers in  a given training round.

                                        <button type="button" class="close" data-dismiss="modal" -label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                       </span>

                                    </div>

                                    <div class="modal-body">
                                        <div class="card-body">
                                  <span style="font-size:13px;">
                                    <i class="fa fa-info" aria-hidden="true"></i>  Create payroll for Training session range from
                                    @foreach ($last_sessions as $last_session)
                                    <option value=""> {{ $last_session->startDateET() }}  -   {{ $last_session->endDateET() }} ዓ.ም </option>
                                      @endforeach

                                 in order to create payroll sheet for each training center!
                                   </span>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal"> <i class="fa fa-arrow-left" aria-hidden="true"></i>Close</button>
                                        <button type="submit" class="btn btn-primary font-weight-bold"><i class="fa fa-arrow-right" aria-hidden="true"></i>
                                         &nbsp;Proceed</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <table width="100%"  style="font-size:12px;" class="table table-striped ">
                <thead>
                    </tr>
                    <th> #</th>
                    <th> Code </th>
                    <th> Training Session </th>
                    <th> User </th>
                    <th>  Created at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payrolls as $key => $payroll)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $payroll->name }}</td>

                            <td>[ {{ $payroll->trainingSession->startDateET() }} ዓ.ም -

                                {{   $payroll->trainingSession->endDateET() }}  ዓ.ም ] </td>

                            <td>{{ $payroll->user->first_name }} {{ $payroll->user->father_name }} </td>
                            <td>{{ $payroll->created_at->diffForHumans(); }}</td>
                            <td>
                            <a href="{{ route('payrollSheet.payroll_list', ['payroll_id'=> $payroll->id]) }}"


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
