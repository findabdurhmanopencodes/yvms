@extends('layouts.app')
@section('title', 'Monthly payroll')
@section('breadcrumb-list')
    <li class="active"> Monthly Payroll</li>
@endsection
@section('breadcrumbTitle', 'Payroll')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted"> Monthly payroll</a>
    </li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('calendar/css/redmond.calendars.picker.css') }}">
@endpush

@push('js')
    <script src="{{ asset('assets/js/pages/crud/ktdatatable/base/data-ajax.js') }}"></script>
    {{-- <script src=" {{ asset('assets/js/select2.min.js') }}"></script> --}}
    <script src=" {{ asset('calendar/js/jquery.plugin.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.plus.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.picker.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.ethiopian.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.ethiopian-am.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.picker-am.js') }}">  </script>

<script>
var calendar = $.calendars.instance('ethiopian', 'en');
$('#sdate').calendarsPicker({
    calendar: calendar
});
</script>

<script>
    var calendar = $.calendars.instance('ethiopian', 'en');
    $('#edate').calendarsPicker({
        calendar: calendar
    });
    </script>
@endpush


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
      $('#woreda').select2({
      });

  });

</script>
@push('')

    <script src="{{ asset('assets/js/pages/crud/ktdatatable/base/data-ajax.js') }}"></script>
@endpush
@section('content')
    <!--begin::Card-->

    <div class="card card-custom card-body mb-3">
        <form action="{{ route('payrollSheet.monthlyPayroll',[]) }}" method="GET">

            <div class=" ml-0 col-12 p-0">
                <div class="row ">
                    <div class="form-group col-3">


                         <select name="woreda" id="woreda" class="form-control " required>
                            <option value="">Select woreda  </option>
                            @foreach ($woredas as $woreda)
                                <option value="{{ $woreda->id }}">{{ $woreda->name }}</option>
                            @endforeach
                        </select>
                    </div>


                <div class="form-group col-3">

                    <input type="text"  id="sdate" required="required"  autocomplete="off" class="form-control" placeholder="Start date" name="sdate">

              </div>

                     <div class="form-group col-3">

                       <input type="text"  id="edate" required="required"   autocomplete="off" class="form-control" placeholder="End date" name="edate">

                   </div>


                   <div class="form-group col-3">
                    <button class="btn btn-primary btn-sm"><i class="fa fa-print"> </i> Generate</button>
                </div>


                </div>







                </div>
            </div>
        </form>
    </div>

    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label"> Active Deployment session

                </h3>
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
                    <th> Last update </th>
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
