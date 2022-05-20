@extends('layouts.app')
@section('title', 'checkin report')

@section('breadcrumbTitle', 'checkin report')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted"></a>
    </li>
@endsection
@section('content')
    <!--begin::Card-->
    <div class="card card-custom card-body mb-3">
        <form action="{{ route('session.TrainingCenter.index.checked',['training_session'=>Request::route('training_session')]) }}" method="post">
            @csrf
            <div class=" ml-0 col-12 p-0">
                <div class="row ">

                    <div class="form-group col-6">
                        <select name="status" id="" class="form-control select2">
                            <option value="">Select status</option>
                            <option value="5">CheckedIn</option>
                            <option value="4">Not-Checked In</option>
                        </select>
                    </div>
                    <div>
                        <button class="btn btn-primary btn-block" name="filter" type="filter" value="filter">
                            Filter</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">volunteers
                    <span class="text-muted pt-2 font-size-sm d-block"> </span>
                </h3>
            </div>

        </div>
        <div class="card-body">
            <table class="table " width="100">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>region</th>
                        <th>status</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($volunteersChecked as $key => $volunteerChecked)
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $volunteerChecked->name() }}</td>
                            <td>{{ $volunteerChecked->phone }}</td>
                            <td>{{ $volunteerChecked->woreda->zone->region->name }}</td>
                            <td><span
                                    class="badge badge-pill badge-{{ $volunteerChecked->status->acceptance_status == 5 ? 'info' : 'warning' }}">{{ $volunteerChecked->status->acceptance_status == 5 ? 'Checked-In' : 'Not Checked-In' }}</span>
                            </td>
                        @endforeach
                    </tr>
                    @if (count($volunteersChecked) < 1)
                        <tr>
                            <td class="text-capitalize text-danger font-size-h4">No Applicants Found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{-- {!! $volunters->links() !!} --}}
            </div>

        </div>
    </div>

@endsection
@push('js')
    <script>
        $('.select2').select2({});
    </script>
@endpush
