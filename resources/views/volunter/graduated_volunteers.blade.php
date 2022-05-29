@extends('layouts.app')
@section('title', 'Graduated Volunteers')
@section('breadcrumb-list')
    <li class="active">Graduated Volunteers</li>
@endsection
@section('breadcrumbTitle', 'Graduated Volunteers')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Graduated Volunteers</a>
    </li>
@endsection

@push('js')
    <script src="{{ asset('assets/js/pages/crud/ktdatatable/base/data-ajax.js') }}"></script>
@endpush
{{--  --}}
@section('content')
    <!--begin::Card-->
    <div class="card card-custom card-body mb-3">
        <form action="" method="GET">
            <div class=" ml-0 col-12 p-0">
                <div class="row">
                    <div class="form-group col-5">
                        <select name="region" id="" class="form-control select2">
                            <option value="">Select Region</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}" @if (Request::get('region') == $region->id) selected @endif>
                                    {{ $region->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-5">
                        <select name="training_center" id="" class="form-control select2">
                            <option value="">Select Training Center</option>
                            @foreach ($training_centers as $training_center)
                                <option value="{{ $training_center->id }}"
                                    @if (Request::get('training_center') == $training_center->id) selected @endif>{{ $training_center->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-2">
                        <button class="btn btn-primary btn-block"> Filter</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card card-custom">
        <div class="card-header flex-wrap  pt-6 ">
            <div class="card-title mr-0">
                <h3 class="card-label">Graduated Volunteer List</h3>
            </div>
            <div class="card-toolbar">
                <div class="d-flex">
                    <a class="btn ml-4 btn-sm btn-primary" href="{{ route('session.deployment.deploy',[Request::route('training_session')]) }}"><i class="fal fa-server"></i> Deploy Volunteers
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table width="100%" class="table table-striped ">
                <thead>
                    </tr>
                    <th> #</th>
                    <th> Name </th>
                    {{-- <th> Middle Name </th> --}}
                    <th> Region </th>
                    <th> Training Center </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($graduatedVolunteers as $key => $graduatedVolunteer)
                        <tr>
                            <td>{{ $graduatedVolunteer->id_number }}</td>
                            <td>{{ $graduatedVolunteer->name() }}</td>
                            {{-- <td>{{ $placedVolunteer->approvedApplicant->volunteer->father_name }}</td> --}}
                            {{-- <td> {{ $placedVolunteer->approvedApplicant->volunteer->grand_father_name }} </td> --}}
                            <td> {{ $graduatedVolunteer->woreda->zone->region->name }} </td>
                            {{-- <td> {{ $graduatedVolunteer->approvedApplicant->trainingPlacement->trainingCenterCapacity->trainingCenter->name }} </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex" style="justify-content: space-between;">
            <div class="">
                <span class="mr-5">Total: {{ $graduatedVolunteers->total() }}</span>
                <span>Page {{ $graduatedVolunteers->currentPage() > 0 ? $graduatedVolunteers->currentPage() : 0 }} of
                    {{ ceil($graduatedVolunteers->total() / $graduatedVolunteers->perPage()) }}</span>
            </div>
            <div class="">
                {{ $graduatedVolunteers->withQueryString()->links() }}
            </div>
        </div>

    </div>

@endsection
@push('js')
    <script>
        $('.select2').select2({});
    </script>
@endpush
