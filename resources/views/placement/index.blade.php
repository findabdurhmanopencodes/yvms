@extends('layouts.app')
@section('title', 'Placement')
@section('breadcrumb-list')
    <li class="active">Regions</li>
@endsection
@section('breadcrumbTitle', 'Placement')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Placement</a>
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
        <div class="row ">
            <div class="form-group col-3">
                <select name="region" id="" class="form-control">
                    <option value="">Select Region</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-3">
                <select name="zone" id="" class="form-control">
                    <option value="">Select Zone</option>
                    @foreach ($zones as $zone)
                        <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-3">
                <select name="woreda" id="" class="form-control">
                    <option value="">Select Woreda</option>
                    @foreach ($woredas as $woreda)
                        <option value="{{ $woreda->id }}">{{ $woreda->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-3">
                <select name="training_center" id="" class="form-control">
                    <option value="">Select Training Center</option>
                    @foreach ($training_centers as $training_center)
                        <option value="{{ $training_center->id }}">{{ $training_center->name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-primary btn-block"> Filter</button>
        </div>
    </div>
    </form>
</div>

    <div class="card card-custom">
        <div class="card-header flex-wrap  pt-6 ">
            <div class="card-title mr-0">
                <h3 class="card-label"> Volunteer Placement </h3>
            </div>
            <span>Total: {{ $placedVolunteers->total()}}</span>
            <span>Page  {{ $placedVolunteers->currentPage()}} of {{ ceil($placedVolunteers->total()/ $placedVolunteers->perPage())}}</span>
        </div>
        <div class="card-body">
            <table width="100%" class="table table-striped ">
                <thead>
                    </tr>
                    <th> #</th>
                    <th> Name </th>
                    {{-- <th> Middle Name </th> --}}
                    {{-- <th> Last Name </th> --}}
                    <th> Region </th>
                    <th> Training Center </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($placedVolunteers as $key => $placedVolunteer)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $placedVolunteer->approvedApplicant->volunteer->name() }}</td>
                            {{-- <td>{{ $placedVolunteer->approvedApplicant->volunteer->father_name }}</td> --}}
                            {{-- <td> {{ $placedVolunteer->approvedApplicant->volunteer->grand_father_name }} </td> --}}
                            <td> {{ $placedVolunteer->approvedApplicant->volunteer->woreda->zone->region->name }} </td>
                            <td> {{ $placedVolunteer->trainingCenterCapacity->trainingCenter->name }} </td>
                            {{-- <td>
                                    <a href="#" class="btn btn-sm btn-primary btn-primary btn-round">
                                        Approve
                                    </a>
                                </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="m-auto col-6 mt-3">
            {{ $placedVolunteers->withQueryString()->links() }}
        </div>
    </div>

@endsection
