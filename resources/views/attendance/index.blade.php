@extends('layouts.app')
@section('title', 'Attendances')
@section('content')

    <div class="card card-custom card-body mb-3">
        {{-- <form action="" method="GET">
        <div class=" ml-0 col-12 p-0">
            <div class="row ">
                <div class="form-group col-3">
                    <select name="region" id="" class="form-control select2">
                        <option value="">Select Region</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-3">
                    <select name="zone" id="" class="form-control select2">
                        <option value="">Select Zone</option>
                        @foreach ($zones as $zone)
                            <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-3">
                    <select name="woreda" id="" class="form-control select2">
                        <option value="">Select Woreda</option>
                        @foreach ($woredas as $woreda)
                            <option value="{{ $woreda->id }}">{{ $woreda->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-3">
                    <select name="training_center" id="" class="form-control select2">
                        <option value="">Select Training Center</option>
                        @foreach ($training_centers as $training_center)
                            <option value="{{ $training_center->id }}">{{ $training_center->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-primary btn-block"> Filter</button>
            </div>
        </div>
    </form> --}}
    </div>

    <div class="modal fade" id="trainingCenterEdit" tabindex="-1" role="dialog" aria-labelledby="trainingCenterEdit"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                {{-- <form action="/trh" method="POST"> --}}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Change Training Center</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="changePlacementForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="training_center" class="font-weight-bold">Training Center</label>
                            <select name="training_center_capacity_id" id="training_center_capacity_id"
                                class="form-control select2" style="width: 100%">
                                {{-- @foreach ($trainingCenterCapacities as $trainingCenterCapacity)
                                <option value="{{ $trainingCenterCapacity->id }}">
                                    {{ $trainingCenterCapacity->trainingCenter->name }}</option>
                            @endforeach --}}
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Save Changes" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card card-custom">
        <div class="card-header flex-wrap  pt-6 ">
            <div class="card-title mr-0">
                <h3 class="card-label"> Volunteer Attendance </h3>
            </div>
        </div>
        <div class="card-body">
            <table width="100%" class="table table-striped ">
                <thead>
                    </tr>
                    <th> #</th>
                    <th> Volunteer Name </th>
                    <th> Region </th>
                    <th> Training Center </th>
                    <th> Attendance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($volunteers as $key => $volunteer)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $volunteer->name() }}</td>
                            <td> {{ $volunteer->woreda->zone->region->name }} </td>
                            <td>
                                {{ $volunteer->approvedApplicant->trainingPlacement->trainingCenterCapacity->trainingCenter->name }}
                            </td>
                            <td>

                                <a href="{{ route('session.volunteer.attendance', ['training_session'=>Request::route('training_session'),'volunteer' => $volunteer->id]) }}"
                                    class="btn btn-icon">
                                    <span class="fa fa-list"></span>
                                </a>
                                {{-- <a href="{{ route('session.volunteer.attendance', ['training_session' => Request::Route('training_session'), 'volunteer' => $volunteer->id]) }}"
                                    class="btn btn-icon">
                                    <span class="fa fa-list"></span>
                                </a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="m-auto col-6 mt-3">
            {{ $volunteers->withQueryString()->links() }}
        </div>
    </div>
@endsection
