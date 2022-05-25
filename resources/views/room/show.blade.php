@extends('layouts.app')
@section('title', 'Detail of syindication room')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-custom gutter-b">
                <div class="py-5 border-0 card-header">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label font-weight-bolder text-dark">Syndication Room
                            {{ $cindicationRoom->number }}</span>
                        <span class="mt-3 text-muted font-weight-bold font-size-sm">Total capacity of
                            {{ $cindicationRoom->number_of_volunteer }}
                            volunteers</span>
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-custom gutter-b">
                <div class="py-5 border-0 card-header">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label font-weight-bolder text-dark">Training and trainners</span>
                        <span class="mt-3 text-muted font-weight-bold font-size-sm">Total {{ count($trainings) }}
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
                <div class="pt-0 card-body">
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
                                    $masterId = $training->trainner(Request::route('training_session'), $trainingCenter, $cindicationRoom)?->id;
                                    $trainner = $training->trainner(Request::route('training_session'), $trainingCenter, $cindicationRoom)?->master->user;
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
                <div class="py-5 border-0 card-header">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label font-weight-bolder text-dark">Assign Co-facilitator</span>
                    </h3>
                </div>
                <div class="pt-1 card-body">
                    <form id="coFacilitatorForm"
                        action="{{ route('session.training_center_based_permission.store', ['training_session' => Request::route('training_session')->id]) }}"
                        method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                <input type="hidden" name="permission_id"
                                    value="{{ Spatie\Permission\Models\Permission::findOrCreate('coFacilitator')->id }}">
                                <input type="hidden" name="cindication_room_id" value="{{ $cindicationRoom->id }}">
                                <input type="hidden" name="training_center_id" value="{{ $trainingCenter->id }}">
                                <input type="hidden" name="training_session_id"
                                    value="{{ Request::route('training_session')->id }}">
                                <select name="user_id" id="user_id" required
                                    class=" @error('user_id') is-invalid @enderror select2 form-control  form-control select2">
                                    @foreach ($coFacilitatorUsers as $coFacilitatorUser)
                                        <option
                                            {{ old('coFacilitatorUser') != null ? (old('coFacilitatorUser') == $coFacilitatorUser->id ? 'selected' : '') : '' }}
                                            value="{{ $coFacilitatorUser->id }}">
                                            {{ $coFacilitatorUser->name }}
                                        </option>
                                    @endforeach
                                    @if (count($coFacilitatorUsers) <= 0)
                                        <option>
                                            Please add co-facilitator
                                        </option>
                                    @endif
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <span class="form-text text-muted">Please select Checker User center.</span>
                            </div>
                            <div class="ml-auto form-group col-md-12">
                                <input type="submit" value="Assign Coordinator"
                                    class="float-right btn btn-success w-100 font-weight-bolder font-size-sm">
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
                            @foreach ($coFacilitators as $coFacilitator)
                                <tr style="font-size: 13px;">
                                    <td>{{ $coFacilitator->name }}</td>
                                    <td>
                                        <span class="btn btn-light-info btn-sm font-weight-bold btn-upper btn-text">
                                            Co-Facilitator
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('session.training_center_based_permission.remove', ['training_session' => Request::route('training_session')->id, 'training_center' => $trainingCenter, 'cindication_room' => $cindicationRoom->id, 'user' => $coFacilitator->id, 'permission' => $coFacilitatorPermission->id]) }}"
                                            id="remover">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            @if (count($coFacilitators) <= 0)
                                <tr>
                                    <td colspan="2" class="text-center">
                                        Please add Co-Facilitator
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

        $('#remover').on('click', function() {
            event.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    // $('#remover').attr('href',url);
                    // $('#remover').click();
                    location.href = $('#remover').attr('href');
                    // $('#coFacilitatorForm').attr('action', url);
                    // $('#coFacilitatorForm').submit();
                }
            });
        });


        function confirmDeleteCoFacilitator(url) {
            event.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $('#remover').attr('href', url);
                    $('#remover').click();
                    $('#coFacilitatorForm').attr('action', url);
                    // $('#coFacilitatorForm').submit();
                }
            });
        }
    </script>
@endpush
