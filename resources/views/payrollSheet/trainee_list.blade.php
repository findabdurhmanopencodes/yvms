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

@push('js')
    <script src="{{ asset('assets/js/pages/crud/ktdatatable/base/data-ajax.js') }}"></script>
@endpush
{{--  --}}
@section('content')
    <!--begin::Card-->
    <div class="card card-custom card-body mb-3">
        <form action="{{ route('payrollSheet.generatePDF',[]) }}" method="GET">
            <div class=" ml-0 col-12 p-0">
                <div class="row ">
                    <div class="form-group col-4">


                        <select name="payment_type" id="" class="form-control select2" required>
                            <option value="">Select payment type </option>
                            @foreach ($payment_types as $payment_type)
                                <option value="{{ $payment_type->id }}">{{ $payment_type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-4">
                                <select name="format" id="" class="form-control select2" required>
                                 <option value=""> Select output format </option>
                                <option value="pdf"> PDF </option>
                                <option value="excel"> Ms Exceel </option>


                        </select>
                    </div>
                    <div class="form-group col-4">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-print"> </i> Print out</button>
                    </div>

              <span> Total Trainee :0  &nbsp;  Training Session ID :0    &nbsp;    Training Center: JU</span>
                </div>
            </div>
        </form>
    </div>


    <div class="card card-custom">

        <div class="card-body">
            <table width="100%" class="table table-striped ">
                <thead>
                    </tr>
                    <th> #</th>
                    <th> Name </th>
                    <th> Phone </th>
                    <th> Sex </th>
                    <th> CBE Acc </th>
                    <th> Amount </th>
                    <th> Zone </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($placedVolunteers as $key => $placedVolunteer)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $placedVolunteer->first_name}} {{ $placedVolunteer->father_name}}  {{ $placedVolunteer->grand_father_name}}  </td>
                             <td> {{ $placedVolunteer->phone }} </td>
                             <td> {{ $placedVolunteer->gender }} </td>
                             <td> 1000259685471 </td>
                             <td> 3,785.00 </td>
                             <td>  {{ $placedVolunteer->woreda->zone->name }}  </td>


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
