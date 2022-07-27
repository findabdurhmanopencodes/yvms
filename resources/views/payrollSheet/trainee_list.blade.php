@extends('layouts.app')
@section('title', 'Placement')
@section('breadcrumb-list')
    <li class="active"> List of payee</li>
@endsection
@section('breadcrumbTitle', 'List of payee')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted"> Payment sheet</a>
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
@endpush

{{--  --}}
@section('content')
    <!--begin::Card-->
    <div class="card card-custom card-body mb-3">
        <form action="{{ route('payrollSheet.generatePDF',[]) }}" method="GET">
            <input type="hidden" name="session" value="{{ $training_session_id }}">
            <input type="hidden" name="center" value="{{ $center->id }}">
            <div class=" ml-0 col-12 p-0">
                <div class="row ">
                    <div class="form-group col-3">


                        <select name="payment_type" id="" class="form-control select2" required>
                            <option value="">Select payment type  </option>
                            @foreach ($payment_types as $payment_type)
                                <option value="{{ $payment_type->id }}">{{ $payment_type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-3">
                                <select name="format" id="" class="form-control select2" required>
                                 <option value=""> Select output format </option>
                                <option value="pdf"> PDF </option>
                                <option value="excel"> Ms Exceel </option>


                        </select>
                    </div>
                    <div class="form-group col-2">

                      <input type="number" min ="1" required="required" max="30"  placeholder="No of days" class="form-control" name="day">

            </div>

            <div class="form-group col-2">

                        <input type="text"  id="sdate" required="required"  class="form-control" placeholder="Start date" name="sdate">

          </div>



                    <div class="form-group col-2">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-print"> </i> Print out</button>
                    </div>

              <span> Total Trainee :{{ $placedVolunteers->count() }}  &nbsp;  &nbsp;    Training Center: {{ $center->name }}</span>
                </div>
            </div>
        </form>
    </div>


    <div class="card card-custom">

        <div class="card-body">
            <table width="100%"  style="font-size:12px;" class="table table-striped ">
                <thead>
                    </tr>
                    <th> #</th>
                    <th> Full Name </th>
                    <th> Phone </th>
                    <th> Sex </th>
                    <th> CBE Acc </th>
                    <th> Trainee code </th>
                    <th> Region </th>
                    <th> Origin zone </th>
                    <th> Remark </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($placedVolunteers as $key => $placedVolunteer)
                        <tr>
                            <td> {{ $key + 1 }}</td>
                            <td> {{ $placedVolunteer->first_name}} {{ $placedVolunteer->father_name}}  {{ $placedVolunteer->grand_father_name}}  </td>
                             <td>+251{{ $placedVolunteer->phone }} </td>
                             <td> {{ $placedVolunteer->gender }} </td>
                             <td> {{ $placedVolunteer->account_number }} </td>
                             <td> {{ $placedVolunteer->id_number }}
                                {{-- ETB {{ number_format($PaymentType->amount,2) } --}}

                            </td>

                             <td> {{ $placedVolunteer->woreda->zone->region->name  }} </td>
                             <td>  {{ $placedVolunteer->woreda->zone->name }}  </td>
                             <td>  &nbsp; - </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>



        </div>
        <div class="m-auto col-6 mt-3">
    {{-- {{ $placedVolunteers->withQueryString()->links() }} --}}
        </div>
    </div>

@endsection
@push('js')
    <script>
        $('.select2').select2({});
    </script>

    <script>
        function onSubmit() {

            // require false;

            event.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "This Will change the training center of the Volunteer!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Change it!"
            }).then(function(result) {
                if (result.value) {
                    $('#trainingCenterEdit').modal();
                }
            });
        }
    </script>
@endpush
