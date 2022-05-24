@extends('layouts.app')
@section('title', 'Detail of syindication room')


@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-custom gutter-b">
                <div class="card-header border-0 py-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label font-weight-bolder text-dark">Training and trainners</span>
                        <span class="text-muted mt-3 font-weight-bold font-size-sm">Total {{ count($trainings) }}
                            trainings in this session</span>
                    </h3>
                    <div class="card-toolbar">
                        <a href="#" data-toggle="modal" data-target="#assignMasterModal"
                            class="btn btn-success font-weight-bolder font-size-sm">
                            <span class="svg-icon svg-icon-md svg-icon-white">
                            </span>
                            Assign master trainners
                        </a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <table width="100%" class="table">
                        <thead>
                            </tr>
                            <th> Training </th>
                            <th> <i class="menu-icon flaticon-list"></i> </th>
                            <th> Trainner </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainings as $key => $training)
                                @php
                                    $masterId = $training->trainner(Request::route('training_session'), $trainingCenter, $training)?->id;
                                    $trainner = $training->trainner(Request::route('training_session'), $trainingCenter, $training)?->master->user;
                                @endphp
                                <tr style="font-size: 13px;">
                                    <td>
                                        {{ $training->name }}
                                    </td>
                                    <td>
                                        <a class="link"
                                            href="{{ route('session.training_center.training.show', ['training_session' => Request::route('training_session')->id, 'training_center' => $trainingCenter->id, 'training' => $training->id]) }}">
                                            <i class="menu-icon flaticon-list"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <span
                                                class="btn {{ $trainner ? 'btn-light-primary' : 'btn-light-danger' }} btn-sm font-weight-bold btn-upper btn-text">
                                                {{ $trainner?->name() == null ? 'Assign Trainner' : '' }}
                                                @if ($trainner)
                                                    <a href="#" onclick="confirmDeleteMasterPlacement({{ $masterId }})"
                                                        style="display: flex;align-items: center;justify-content: space-between;width: 185px;">
                                                        {{ $trainner?->name() }}
                                                        <i class="fa fa-times fa-sm"></i>
                                                    </a>
                                                @endif

                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if (count($trainings) <= 0)
                                <tr style="font-size: 13px;" class="text-center">
                                    <td colspan="3" style="">No training assigned</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <!--begin: Items-->
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-custom gutter-b">
                <div class="card-header border-0 py-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label font-weight-bolder text-dark">Assign Other users</span>
                    </h3>
                </div>
                <div class="card-body pt-1">
                    <form id="checkerForm"
                        action="{{ route('session.training_center.assign_checker', ['training_session' => Request::route('training_session')->id, 'training_center' => $trainingCenter->id]) }}"
                        method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-8">
                                <select name="checkerUser" id="checkerUser" required
                                    class=" @error('checkerUser') is-invalid @enderror select2 form-control  form-control select2">
                                    @foreach ($checkerUsers as $checkerUser)
                                        <option
                                            {{ old('checkerUser') != null ? (old('checkerUser') == $checkerUser->id ? 'selected' : '') : '' }}
                                            value="{{ $checkerUser->id }}">
                                            {{ $checkerUser->name }}
                                        </option>
                                    @endforeach

                                    @if (count($checkerUsers) <= 0)
                                        <option>
                                            Please add checker users
                                        </option>
                                    @endif
                                </select>
                                @error('checkerUser')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <span class="form-text text-muted">Please select Checker User center.</span>
                            </div>
                            <div class="form-group col-md-3 ml-auto">
                                <input type="submit" value="Assign checkers"
                                    class="btn btn-success float-right font-weight-bolder font-size-sm">
                            </div>
                        </div>
                    </form>
                    <form id="centerCoordinatorForm"
                        action="{{ route('session.training_center_based_permission.store', ['training_session' => Request::route('training_session')->id, 'training_center' => $trainingCenter->id]) }}"
                        method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-8">
                                <input type="hidden" name="permission_id"
                                    value="{{ Spatie\Permission\Models\Permission::findOrCreate('centerCooridnator')->id }}">
                                <input type="hidden" name="training_center_id" value="{{ $trainingCenter->id }}">
                                <input type="hidden" name="training_session_id"
                                    value="{{ Request::route('training_session')->id }}">
                                <select name="user_id" id="centerCoordinator" required
                                    class=" @error('centerCoordinator') is-invalid @enderror select2 form-control  form-control select2">
                                    @foreach ($centerCoordinatorUsers as $centerCoordinatorUser)
                                        <option
                                            {{ old('centerCoordinatorUser') != null ? (old('centerCoordinatorUser') == $centerCoordinatorUser->id ? 'selected' : '') : '' }}
                                            value="{{ $centerCoordinatorUser->id }}">
                                            {{ $centerCoordinatorUser->name }}
                                        </option>
                                    @endforeach

                                    @if (count($centerCoordinatorUsers) <= 0)
                                        <option>
                                            Please add center coordinator
                                        </option>
                                    @endif
                                </select>
                                @error('centercenterCoordinator')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <span class="form-text text-muted">Please select Checker User center.</span>
                            </div>
                            <div class="form-group col-md-3 ml-auto">
                                <input type="submit" value="Assign Coordinator"
                                    class="btn btn-success float-right font-weight-bolder font-size-sm">
                            </div>
                        </div>
                    </form>
                    <table width="100%" class="table">
                        <thead>
                            </tr>
                            <th> Name </th>
                            <th> Role </th>
                            <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($centerCoordinators as $centerCoordinator)
                                <tr style="font-size: 13px;">
                                    <td>{{ $centerCoordinator->name }}</td>
                                    <td>
                                        <span class="btn btn-light-info btn-sm font-weight-bold btn-upper btn-text">
                                            Coordinator
                                        </span>
                                    </td>
                                    <td><a href="#" onclick="confirmDeleteCoordinator({{ $centerCoordinator->id }})"><i
                                                class="fa fa-times"></i></a></td>
                                </tr>
                            @endforeach
                            @foreach ($centerCheckers as $centerChecker)
                                <tr style="font-size: 13px;">
                                    <td>{{ $centerChecker->name }}</td>
                                    <td>
                                        <span class="btn btn-light-info btn-sm font-weight-bold btn-upper btn-text">
                                            Checker
                                        </span>
                                    </td>
                                    <td><a href="#" onclick="confirmDeleteChecker({{ $centerChecker->id }})"><i
                                                class="fa fa-times"></i></a></td>
                                </tr>
                            @endforeach
                            @if (count($centerCheckers) <= 0 && count($centerCoordinators) <= 0)
                                <tr>
                                    <td colspan="2" class="text-center">
                                        Please add coordinator & checker
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="assignMasterModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST"
                    action="{{ route('session.training_master_placement.store', ['training_session' => Request::route('training_session'), 'cindication_room' => $cindicationRoom->id]) }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body" style="height: 200px;">
                        @csrf
                        <div class="form-group">
                            <select name="training" id="training" required
                                class=" @error('training') is-invalid @enderror select2 form-control  form-control select2">
                                @foreach ($trainings as $training)
                                    <option
                                        {{ old('training') != null ? (old('training') == $training->id ? 'selected' : '') : '' }}
                                        value="{{ $training->id }}">
                                        {{ $training->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('training')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <span class="form-text text-muted">Please select training center.</span>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="training_center" value="{{ $trainingCenter->id }}">
                            <input type="hidden" name="cindication_room" value="{{ $cindicationRoom->id }}">
                        </div>
                        <div class="form-group">
                            <select name="trainner" id="trainner"
                                class=" @error('trainner') is-invalid @enderror select2 form-control  form-control select2">
                                <option value="">Select Trainner</option>
                                @foreach ($freeTrainners as $freeTrainner)
                                    <option
                                        {{ old('trainner') != null ? (old('trainner') == $freeTrainner->id ? 'selected' : '') : '' }}
                                        value="{{ $freeTrainner->id }}">{{ $freeTrainner->user->name }}</option>
                                @endforeach
                            </select>
                            @error('trainner')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <span class="form-text text-muted">Please select trainner.</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold"
                            data-dismiss="modal">Close</button>
                        {{-- <button type="button" class="btn btn-primary font-weight-bold">Save changes</button> --}}
                        <input type="submit" value="Assign Master Trainer" class="btn btn-sm btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form method="POST" id="deleteForm">
        @csrf
        @method('DELETE')
    </form>
    <form id="removeCheckerForm"
        action="{{ route('session.training_center.assign_checker', ['training_session' => Request::route('training_session')->id, 'training_center' => $trainingCenter->id]) }}"
        method="POST">
        @csrf
        <input type="hidden" name="checkerUser" id="checkerUserRemove">
    </form>
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
        $('.select2').select2({
            allowClear: true
        });
        @if (old('training') != null)
            $('#assignMasterModal').modal().show()
        @endif



        function confirmDeleteMasterPlacement(masterId) {
            var sessionId = '{{ Request::route('training_session')->id }}';
            $('#deleteForm').attr('action', '/' + sessionId + '/training_master_placement/' + masterId);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $('#deleteForm').submit();
                }
            });
        }

        function confirmDeleteCoordinator(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $("#centerCoordinator").html(`<option value="${id}"></option>`);
                    $('#centerCoordinatorForm').submit();
                }
            });
        }

        function confirmDeleteChecker(checkerId) {
            $('#checkerUserRemove').val(checkerId);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $('#removeCheckerForm').submit();
                }
            });
        }
    </script>
@endpush
