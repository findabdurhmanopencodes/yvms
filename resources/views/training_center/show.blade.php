@extends('layouts.app')
@section('title', 'Training Centers Detail')

@section('breadcrumbTitle', 'Training Centers Detail')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Training Centers</a>
    </li>
    <li class="breadcrumb-item">
        <a href="" class="text-muted">{{ $trainingCenter->name }}</a>
    </li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            @if (count($capaityAddedInCenter) < 1)
                <a class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addCapacity"><i
                        class="fa  fa-plus"></i>Add Capacity For Session</a>
            @endif


        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $trainingCenter->name }}</h5>

            <table class="table table-light">
                <thead>
                    <th>capacity</th>
                    <th>Training Session Dates</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @foreach ($trainingCenter->capacities as $capacityHistory)
                    {{-- @dd($capacityHistory) --}}
                        <tr>
                            <td> {{ $capacityHistory->capacity }} Volunter</td>

                            <td>{{ $capacityHistory->trainningSession->start_date }} <span
                                    class="text text-success font-weight-bolder"> to</span>
                                {{ $capacityHistory->trainningSession->end_date }}</td>
                            <td>
                                @if (Carbon\Carbon::now()->between(Carbon\Carbon::parse($capacityHistory->trainningSession->start_date), Carbon\Carbon::parse($capacityHistory->trainningSession->end_date)))
                                    <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editCapacity"
                                        onclick="capacityChange({{ $capacityHistory->trainining_center_id}},{{   $capacityHistory->training_session_id }});"><i
                                            class="fa fa-edit"></i>change Capacity</a>
                                @else
                                    <span class="badge badge-danger badge-pill">Can't Change Capacity</span>
                                @endif
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
            <form method="POST" action="{{ route('TrainingCenterCapacity.store') }}">
                <input type="hidden" name="trainingCenterId" value="{{ $trainingCenter->id }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCapacityLabel">Add Capacity To {{ $trainingCenter->name }}</h5>
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
    <div class="modal fade" id="editCapacity" tabindex="-1" role="dialog" aria-labelledby="editCapacityLael"
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
    </div>

@endsection
@push('js')
    <script>
        function capacityChange(training_center, training_session) {
            console.log(training_center,training_session)
            $('#training_session_id').val(training_session);
            $('#trainining_center_id').val(training_center);
        }
    </script>
@endpush
