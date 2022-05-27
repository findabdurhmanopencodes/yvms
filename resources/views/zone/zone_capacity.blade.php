@extends('layouts.app')
@section('title', 'Zone Intake')

@section('breadcrumbTitle', 'Zone Intake Detail')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Zone Intakes</a>
    </li>
    <li class="breadcrumb-item">
        <a href="" class="text-muted">{{ $zone->name }} </a>
    </li>
@endsection
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
@push('js')
    <script>
        $(document).ready(function() {
            $('#user_id').select2({
                placeholder: "Select a User"
            });

        });
    </script>
@endpush
@section('content')
    <div class="card">

        <div class="card-header">
            {{-- <div class="col-xl-10">
                <!--begin::List Widget 13-->
                <div class="card card-custom card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0">
                        <h3 class="card-title font-weight-bolder text-dark">Training Center Checker </h3>
                        <a data-toggle="modal" data-target="#assignChecker"
                            class="btn btn-sm btn-clean btn-primary float-lg-right my-4 mx-4">
                            <i class="fa fa-user-plus">Adding Checker</i>
                        </a>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-2">
                        <!--begin::Item-->
                        <div class="d-flex flex-wrap align-items-center mb-10">

                            @foreach ($trainingCenter->checkers as $checker)
                                <div class="d-flex justify-around">
                                    <h4>
                                        {{ $checker->name }} <a class="btn btn-icon btn-danger  ml-4"
                                            onclick="confirm('Are You Sure Removing This User');"
                                            href="{{ route('TrainingCenter.removeChecker', ['checker_id' => $checker->id]) }}"><i
                                                class="fa fa-trash"></i></a>
                                    </h4>
                                </div>
                            @endforeach
                            @if (count($trainingCenter->checkers) < 1)
                                <p class="text text-danger">No Checker Assigned Yet!!</p>
                            @endif
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::List Widget 13-->
            </div> --}}

        </div>


        @if (count($intake_exist) < 1 && count($curr_sess) > 0)
            <div>
                <a class="btn btn-primary btn-sm float-right mx-2 my-2" data-toggle="modal" data-target="#addCapacity"><i class="fa  fa-plus"></i>Add zone Intake</a>
            </div>
        @endif

        <div class="card-body">
            <h5 class="card-title">{{ $zone->name }} Zone</h5>

            <table class="table table-light">
                <thead>
                    <th>#</th>
                    <th>Training Session</th>
                    <th>capacity</th>
                    {{-- <th>Training Session Dates</th> --}}
                    <th>Actions</th>
                </thead>
                <tbody>

                    @foreach ($zone->zoneIntakes as $key => $zoneIntake)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $trainingSession->moto }}</td>
                            <td> {{ $zoneIntake->intake }}</td>

                            {{-- <td>{{ $capacityHistory->trainningSession?->start_date }} <span
                                    class="text text-success font-weight-bolder"> to</span>
                                {{ $capacityHistory->trainningSession?->end_date }}</td>
                            <td> --}}
                            <td>    
                                <span class="badge badge-danger badge-pill">Can't Change Capacity</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>


    <div class="modal fade" id="addCapacity" tabindex="-1" role="dialog" aria-labelledby="addCapacityLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" action="{{ route('session.zone.intake_store', ['zone_id'=>$zone->id, 'training_session'=>$trainingSession->id]) }}">
                {{-- <input type="hidden" name="trainingCenterId" value="{{ $region->id }}"> --}}
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCapacityLabel">Add Capacity To {{ $zone->name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" -label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-6">
                            <label>Capacity:</label>
                            <input type="number" class="form-control" placeholder="Capacity" name="capacity" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-danger font-weight-bold"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- <div class="modal fade" id="editCapacity" tabindex="-1" role="dialog" aria-labelledby="editCapacityLael"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" action="{{ route('TrainingCenterCapacity.capacityChange') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCapacityLabel">Editing Capacity To {{ $trainingCenter->name }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" -label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-6">
                            <label>Capacity:</label>
                            <input type="hidden" id="trainining_center_id" name="trainining_center_id" />
                            <input type="hidden" id="training_session_id" name="training_session_id" />
                            <input type="number" class="form-control" placeholder="Capacity" name="capacity" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-danger font-weight-bold"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}
    {{-- <div class="modal fade" id="assignChecker" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="assignLeader" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form name="new_store" method="post" action="{{ route('TrainingCenter.assignChecker') }}">
                <input type="hidden" name="trainingCenterId" value="{{ $trainingCenter->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Assign Store-Leader </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Users</label>
                                <br>
                                <select class="form-control select2" id="user_id" name="user_id[]" required multiple>
                                    <option value=""></option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->first_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="close" type="button" class="btn btn-light-primary font-weight-bold"
                            data-dismiss="modal">Close
                        </button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}

@endsection
@push('js')
    <script>
        function capacityChange(training_center, training_session) {
            console.log(training_center, training_session)
            $('#training_session_id').val(training_session);
            $('#trainining_center_id').val(training_center);
        }
    </script>
@endpush
