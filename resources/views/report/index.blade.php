@extends('layouts.app')
@section('title', 'Training session based reporting')
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


    </script>
    <script src="{{ asset('assets/js/pages/crud/ktdatatable/base/data-ajax.js') }}"></script>
@endpush


    <div class="card card-custom card-body mb-3">

  <form action="{{ route('report.generatePdf',[]) }}"  id="form" method="GET">
        <div class=" ml-1 col-12 p-0">
            <div class="row ">

                <div class="form-group col-8">
                    <select name="training_session" id="training_session"  required="required" class="form-control select2">
                        <option value=""> Report per training session </option>
                        @foreach ($training_sessions as $training_session)
                            <option value="{{ $training_session->id }}"> {{ $training_session->startDateET() }} -   {{ $training_session->endDateET() }} ዓ.ም </option>
                        @endforeach
                    </select>
                </div>




                <div class="form-group col-4">
                    <button class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Print</button>
                </div>


            </div>
        </div>
    </form>
    </div>



    <div class="card card-custom">
        <div class="card-header flex-wrap  pt-6 ">
            <div class="card-title mr-0">
             <h5> <i class=" fa fa-list"></i> &nbsp; Report per training ceneter based  <u>{{ '' }}</u> </h5>
            </div>
            <div class="card-title mr-0">
            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">



    </a>

</div>
</div>

        <div class="card-body">
            <table width="100%"  style="font-size:12px;"  class="table table-striped ">
                <thead>
                    </tr>
                    <th> #</th>

                    <th> Training Center </th>
                    <th> Session round </th>
                    <th> Status</th>

                    <th> Print </th>

                    </tr>
                </thead>
                <tbody>

                    @foreach($payroll_sheets  as $key =>  $payroll_sheet )
                        <tr>


                                 <td> {{ $key + 1 }}</td>
                                 <td> {{ $payroll_sheet->traininingCenter->name }} </td>
                                 <td> {{ $payroll_sheet->payroll->name }}   </td>

                                 <td> Closed  </td>

                            </td>
                            <td>



                                 <a href="{{ route('payrollSheet.payee', ['payroll_sheet_id'=> $payroll_sheet->id]) }}" class="btn btn-icon">
                                    <span class="fa fa-print"></span>
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

@endsection
