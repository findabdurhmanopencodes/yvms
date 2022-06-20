@extends('layouts.app')
@section('title', 'Payment report')
@section('content')
@push('js')

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
        $( document ).ready(function() {
            $('#training_center').select2({
            });

        });
        $( document ).ready(function() {
            $('#center').select2({
            });

        });

    </script>
    <script src="{{ asset('assets/js/pages/crud/ktdatatable/base/data-ajax.js') }}"></script>
@endpush

    <div class="card card-custom card-body mb-3">




        <form action=""  id="form" method="GET">
        <div class=" ml-1 col-12 p-0">
            <div class="row ">

                 <div class="form-group col4-">
                    <select name="training_center" id="training_center" class="form-control select2" required>
                        <option value="">Select Training Center</option>
                        @foreach ($training_centers as $training_center)
                            <option value="{{ $training_center->id }}">{{ $training_center->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-4">
                    <select name="training_session" id="training_session" class="form-control select2" required>
                        <option value="">Select Training Session</option>
                        @foreach ($training_sessions as $training_session)
                            <option value="{{ $training_session->id }}">
                                {{ Carbon\Carbon::parse($training_session->start_date)->format('D M, Y')}}  -
                                {{ Carbon\Carbon::parse($training_session->end_date)->format('D M, Y')}}( R-{{ $training_session->id }})

                            </option>
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
        <div class="card-header flex-wrap  pt-6 ">
            <div class="card-title mr-0">
             <h5> <i class=" fa fa-list"></i> &nbsp;  Active payment reports</h5>
            </div>
            <div class="card-title mr-0">
            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">

      <i class="fa fa-check"> </i> Approval
    </a>

</div>
</div>

        <div class="card-body">
            <table width="100%"  style="font-size:12px;"  class="table table-striped ">
                <thead>
                    </tr>
                    <th> #</th>

                    <th> Training Center </th>
                    <th> Training Session </th>
                    <th> Payment type </th>
                    <th> Total payee </th>
                    <th> Total amount</th>
                    <th> Creared by </th>
                    <th> Created at </th>

                    {{-- <th>Action </th> --}}

                    </tr>
                </thead>
                <tbody>

                    @foreach($payment_reports  as $key =>$payment_report )
                        <tr>


                                 <td> {{ $key + 1 }}</td>
                                 <td> {{ $payment_report->traininingCenter->name }} </td>

                                 <td> {{ Carbon\Carbon::parse($payment_report->trainingSession->start_date)->format('m/d/Y')}}  -
                                    {{ Carbon\Carbon::parse($payment_report->trainingSession->end_date)->format('m/d/Y')}}
                                   </td>
                                 <td> {{ $payment_report->paymentType->name }}  </td>
                                 <td> {{  $payment_report->total_payee }} </td>
                                <td> Birr  {{  number_format($payment_report->total_amount,2) }} </td>

                                 <td> {{ $payment_report->user->first_name }}  {{ $payment_report->user->father_name }}  </td>
                                 <td>{{ Carbon\Carbon::parse($payment_report->created_at)->format(' D M, Y') }} </td>
                            </td>
                            {{-- <td>
                                <a href="javascript:;" onclick="deletePayrollSheet('payment_report ',$(this))" class="btn btn-sm btn-clean btn-icon" class="btn btn-icon">
                                <span class="fa fa-trash"></span>
                                </a>

                                 <a href="{{ route('payrollSheet.payee', ['payment_report_id'=> $payment_report->id]) }}" class="btn btn-icon">
                                    <span class="fa fa-list"></span>
                                </a>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="m-auto col-6 mt-3">
            {{ $payment_reports->withQueryString()->links() }}
        </div>
    </div>
    <div class="card-toolbar">
        <form method="POST" action="{{ route('payrollSheet.store', []) }}">
                @csrf
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md"  role="document">
                              <div class="modal-content">
                               <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Create payroll sheet</h5>
                                <button type="button" class="close" data-dismiss="modal" -label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="form-group col-12">
                                        <select name="training_center" id="center" class="form-control select2">
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
