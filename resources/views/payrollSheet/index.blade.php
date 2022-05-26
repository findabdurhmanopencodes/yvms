@extends('layouts.app')
@section('title', 'Payroll sheet')
@section('content')
@push('js')
    <script>
        var HOST_URL = "{{ route('payrollSheet.index') }}";

        function deletepayrollSheet(id, parent) {
            event.preventDefault();
            Swal.fire({
                title: "Are you sure to delete this payroll sheet?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: '/payrollSheet/'+id,
                        data: {
                            "id": id,
                            "_method": 'DELETE',
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        dataType: 'json',
                        success: function(data) {
                            $(parent).closest('tr')[0].remove();
                            Swal.fire(
                                "Deleted!",
                                "Payroll sheet has been deleted.",
                                "success"
                            )
                        },
                        error: function(data) {
                            if (data.status) {
                                Swal.fire("Forbidden!", "You can't delete this payroll sheet", "error");
                            }
                        }
                    });
                }
            });
        }
    </script>
    <script src="{{ asset('assets/js/pages/crud/ktdatatable/base/data-ajax.js') }}"></script>
@endpush

    <div class="card card-custom card-body mb-3">




        <form action=""  id="form" method="GET">
        <div class=" ml-1 col-12 p-0">
            <div class="row ">

                <div class="form-group col-5">
                    <select name="training_session" id="" class="form-control">
                        <option value="">Select Training Session </option>
                        @foreach ($training_sessions as $training_session)
                            <option value="{{ $training_session->id }}">{{ $training_session->moto }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group col-5">
                    <select name="training_center" id="" class="form-control">
                        <option value="">Select Training Center</option>
                        @foreach ($training_centers as $training_center)
                            <option value="{{ $training_center->id }}">{{ $training_center->name }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group col-2">
                    <button class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Filter </button>
                </div>


            </div>
        </div>
    </form>
    </div>



    <div class="card card-custom">
        <div class="card-header flex-wrap  pt-6 ">
            <div class="card-title mr-0">
                <h3 class="card-label">Payroll code :</u> MoP-YVMS-02-204-payroll</u> </h3>
            </div>
            <div class="card-title mr-0">
            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">

                <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                <i class="fal fa-plus"></i>
                <!--end::Svg Icon-->

      <i class="fa fa-usd"> </i> New sheet
    </a>

</div>
</div>

        <div class="card-body">
            <table width="100%" class="table table-striped ">
                <thead>
                    </tr>
                    <th> #</th>

                    <th> Training Center </th>
                    <th> Training Session ID </th>
                    <th> User </th>
                    <th> Created at </th>


                    <th>Action </th>

                    </tr>
                </thead>
                <tbody>

                    @foreach($payroll_sheets  as $key =>  $payroll_sheet )
                        <tr>
                                 <td> {{ $key + 1 }}</td>
                                 <td> {{ $payroll_sheet->trainining_center_id }} </td>
                                 <td> Training session ID  </td>
                                 <td> {{ $payroll_sheet->user_id }} </td>
                                 <td> {{ $payroll_sheet->created_at }} </td>
                            </td>
                            <td>
                                <a href="javascript:;" onclick="deletePayrollSheet('+payroll_sheet+ ',$(this))" class="btn btn-sm btn-clean btn-icon" class="btn btn-icon">
                                <span class="fa fa-trash"></span>
                                </a>
                                 <a href="{{ route('payrollSheet.payee', ['trainining_center_id'=>$payroll_sheet->trainining_center_id,'training_session_id'=>'sessionid']) }}"
                                    class="btn btn-icon">
                                    <span class="fa fa-list"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="m-auto col-6 mt-3">
            {{ $payroll_sheets->withQueryString()->links() }}
        </div>
    </div>


    <div class="card-toolbar">


        <form method="POST" action="{{ route('payrollSheet.store', ['payroll_id'=>1]) }}">
                @csrf
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Create  payroll sheet</h5>
                                <button type="button" class="close" data-dismiss="modal" -label="Close">
                                    <i aria-hidden="true" class="ki ki-close"></i>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="form-group col-12">
                                        <select name="training_center" id="" class="form-control">
                                            <option value="">Select Training Center</option>
                                            @foreach ($training_centers as $training_center)
                                                <option value="{{ $training_center->id }}">{{ $training_center->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary font-weight-bold"> Save </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <!--end::Button-->
    </div>
@endsection
