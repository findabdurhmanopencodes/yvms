@extends('layouts.app')
@section('title', 'Center base detail')
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
@section('content')
    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        {{-- <div cl --}}
        <div class="card-body">
            <div class="d-flex">
                <!--begin: Pic-->
                <div class="flex-shrink-0 mt-3 mr-7 mt-lg-0">
                    <div class="symbol symbol-50 symbol-lg-120">
                        <img alt="Pic" src="{{ $trainingCenter->getLogo() }}" />
                    </div>
                    <div class="symbol symbol-50 symbol-lg-120 symbol-primary d-none">
                        <span class="font-size-h3 symbol-label font-weight-boldest">{{ $trainingCenter->code }}</span>
                    </div>
                </div>
                <!--end: Pic-->
                <!--begin: Info-->
                <div class="flex-grow-1">
                    <!--begin: Title-->
                    <div class="flex-wrap d-flex align-items-center justify-content-between">

                        <div class="mr-3">
                            <!--begin::Name-->
                            <a href="#"
                                class="mr-3 d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold">{{ $trainingCenter->name }}
                                - <span> {{ $trainingCenter->code }}</span>
                                <i class="ml-2 flaticon2-correct text-success icon-md"></i></a>
                            <!--end::Name-->
                            <!--begin::Contacts-->
                            <div class="flex-wrap my-2 d-flex">
                                <a href="#" class="text-muted text-hover-primary font-weight-bold">
                                    <span class="mr-1 svg-icon svg-icon-md svg-icon-gray-500">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Map/Marker2.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path
                                                    d="M9.82829464,16.6565893 C7.02541569,15.7427556 5,13.1079084 5,10 C5,6.13400675 8.13400675,3 12,3 C15.8659932,3 19,6.13400675 19,10 C19,13.1079084 16.9745843,15.7427556 14.1717054,16.6565893 L12,21 L9.82829464,16.6565893 Z M12,12 C13.1045695,12 14,11.1045695 14,10 C14,8.8954305 13.1045695,8 12,8 C10.8954305,8 10,8.8954305 10,10 C10,11.1045695 10.8954305,12 12,12 Z"
                                                    fill="#000000" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>{{ $trainingCenter->zone->name . ' / ' . $trainingCenter->zone->region->name . ' / ' }}</a>
                            </div>
                            <!--end::Contacts-->
                        </div>
                        <div class="my-1 my-lg-0">
                            <div class="dropdown dropdown-inline">
                                <a href="#" class="px-5 btn btn-sm btn-primary font-weight-bolder dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Emport/Export Volunteers</a>
                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="">
                                    <!--begin::Navigation-->
                                    <ul class="navi navi-hover">
                                        <li class="navi-item">
                                            <a data-toggle="modal" data-target="#import"
                                                class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="fa fa-file-import"></i>
                                                </span>
                                                <span class="navi-text">Import</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="{{ route('session.volunteer.export', ['training_session' => Request::route('training_session')->id, 'training_center' => $trainingCenter->id]) }}"
                                                class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="fa fa-file-export"></i>
                                                </span>
                                                <span class="navi-text">Export</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!--end::Navigation-->
                                </div>
                            </div>
                        </div>
                        <div class="my-1 my-lg-0">
                            <div class="dropdown dropdown-inline">
                                <a href="#" class="px-5 btn btn-sm btn-primary font-weight-bolder dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</a>
                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="">
                                    <!--begin::Navigation-->
                                    <ul class="navi navi-hover">
                                        <li class="navi-item">
                                            <a href="{{ route('session.resource.assign.volunteer', ['training_session' => Request::route('training_session')->id, 'training_center_id' => $trainingCenter->id]) }}"
                                                class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="flaticon2-shopping-cart-1"></i>
                                                </span>
                                                <span class="navi-text">Resources</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="{{ route('session.training_center.checkedIn_list', ['training_session' => Request::route('training_session')->id, 'training_center' => $trainingCenter->id]) }}"
                                                class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="fa fa-users"></i>
                                                </span>
                                                <span class="navi-text">Checked In List</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="{{ route('session.training_center.trainer_list', ['training_session' => Request::route('training_session')->id, 'training_center' => $trainingCenter->id]) }}" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="flaticon2-shopping-cart-1"></i>
                                                </span>
                                                <span class="navi-text">Trainners List</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" onclick="confirmPlacment()" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="fal fa-map-marker-check"></i>
                                                </span>
                                                <span class="navi-text">Place Volunteers</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!--end::Navigation-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end: Title-->
                    <!--begin: Content-->
                    <div class="flex-wrap d-flex align-items-center justify-content-between">
                        <div class="py-5 mr-5 flex-grow-1 font-weight-bold text-dark-50 py-lg-2 w-100">
                            {{ $trainingCenter->description ?? 'There is no description of the center' }}
                            <br />
                        </div>
                        <div class="flex-wrap py-2 d-flex align-items-center">
                            <div class="mr-10 d-flex align-items-center">
                                <div class="mr-6">
                                    <div class="mb-2 font-weight-bold">Start Date</div>
                                    <span
                                        class="btn btn-sm btn-text btn-light-primary text-uppercase font-weight-bold">{{ Request::route('training_session')->startDateET() }}</span>
                                </div>
                                <div class="">
                                    <div class="mb-2 font-weight-bold">Due Date</div>
                                    <span
                                        class="btn btn-sm btn-text btn-light-primary text-uppercase font-weight-bold">{{ Request::route('training_session')->endDateET() }}</span>
                                </div>
                            </div>
                            {{-- <div class="flex-shrink-0 mt-4 flex-grow-1 w-150px w-xl-300px mt-sm-0">
                                <span class="font-weight-bold">Progress</span>
                                <div class="mt-2 mb-2 progress progress-xs">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 63%;"
                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="font-weight-bolder text-dark">78%</span>
                            </div> --}}
                        </div>
                    </div>
                    <!--end: Content-->
                </div>
                <!--end: Info-->
            </div>
            <div class="separator separator-solid my-7"></div>
            <!--begin: Items-->
            <div class="flex-wrap d-flex align-items-center">
                <!--begin: Item-->
                <div class="my-1 mr-5 d-flex align-items-center flex-lg-fill">
                    <span class="mr-4">
                        <i class="flaticon-piggy-bank icon-2x text-muted font-weight-bold"></i>
                    </span>
                    <div class="d-flex flex-column text-dark-75">
                        <span class="font-weight-bolder font-size-sm">Total Volunteers</span>
                        <span class="font-weight-bolder font-size-h5">
                            <span class="text-dark-50 font-weight-bold"></span>{{ $totalVolunteers }}</span>
                    </div>
                </div>
                <!--end: Item-->
                <!--begin: Item-->
                <div class="my-1 mr-5 d-flex align-items-center flex-lg-fill">
                    <span class="mr-4">
                        <i class="flaticon-confetti icon-2x text-muted font-weight-bold"></i>
                    </span>
                    <div class="d-flex flex-column text-dark-75">
                        <span class="font-weight-bolder font-size-sm">Checked In Volunteers</span>
                        <span class="font-weight-bolder font-size-h5">
                            <span class="text-dark-50 font-weight-bold"></span>{{ count($checkedInVolunteers) }}</span>
                    </div>

                </div>
                <!--end: Item-->
                <!--begin: Item-->
                <div class="my-1 mr-5 d-flex align-items-center flex-lg-fill">
                    <span class="mr-4">
                        <i class="flaticon-pie-chart icon-2x text-muted font-weight-bold"></i>
                    </span>
                    <div class="d-flex flex-column text-dark-75">
                        <span class="font-weight-bolder font-size-sm">Training Masters</span>
                        <span class="font-weight-bolder font-size-h5">
                            <span class="text-dark-50 font-weight-bold"></span>{{ $totalTrainingMasters }}</span>
                    </div>
                </div>
                <!--end: Item-->
                <!--begin: Item-->
                <div class="my-1 mr-5 d-flex align-items-center flex-lg-fill">
                    <span class="mr-4">
                        <i class="flaticon-file-2 icon-2x text-muted font-weight-bold"></i>
                    </span>
                    <div class="d-flex flex-column flex-lg-fill">
                        <span class="text-dark-75 font-weight-bolder font-size-sm">Total Resource</span>
                        <a href="#"
                            class="text-primary font-weight-bolder">{{ $trainingCenter->resources()->count() }}</a>
                    </div>
                </div>
                <!--end: Item-->
            </div>
            <!--begin: Items-->
        </div>
    </div>
    <!--end::Card-->



    <div class="modal fade" id="assignMasterModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST"
                    action="{{ route('session.training_master_placement.store', ['training_session' => Request::route('training_session')]) }}">
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
    <!--begin::Card-->
    <div class="row">
        <div class="col-md-8">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="py-5 border-0 card-header">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label font-weight-bolder text-dark">Cindication rooms</span>
                        <span class="mt-3 text-muted font-weight-bold font-size-sm">Total {{ count($cindicationRooms) }}
                            Cindication Rooms</span>
                    </h3>
                    <div class="card-toolbar">
                    </div>
                </div>
                <div class="pt-0 card-body">
                    <form class="row" method="POST"
                        action="{{ route('session.cindication_room.store', ['training_session' => Request::route('training_session')->id, 'training_center' => $trainingCenter->id]) }}">
                        @csrf
                        <div class="form-group col-md-4">
                            {{-- <label class="d-block">Room ID</label> --}}
                            <input type="text" class="@error('number') is-invalid @enderror form-control" name="number"
                                placeholder="Room ID"
                                value="{{ old('number') ?? (isset($user) ? $user->number : '') }}" />
                            @error('number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <span class="form-text text-muted">Please enter Room ID.</span>
                        </div>
                        <div class="form-group col-md-4">
                            {{-- <label class="d-block">Number of volunteers</label> --}}
                            <input type="text" class="@error('number_of_volunteers') is-invalid @enderror form-control"
                                name="number_of_volunteers" placeholder="Number of volunteers"
                                value="{{ old('number_of_volunteers') ?? (isset($user) ? $user->number_of_volunteers : '') }}" />
                            @error('number_of_volunteers')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <span class="form-text text-muted">Please enter Number of volunteers.</span>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Add Cindication rooms"
                                class="btn btn-success font-weight-bolder font-size-sm">
                        </div>
                    </form>
                    <form action="" method="POST" id="deleteRoomForm">
                        @csrf
                        @method('DELETE')
                    </form>
                    <table width="100%" class="table">
                        <thead>
                            </tr>
                            <th>Cindication Room Id </th>
                            <th>Volunteer Capacity</th>
                            <th>Placed Volunteer</th>
                            <th>Action</th>
                            {{-- <th><i class="menu-icon flaticon-list"></i> </th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cindicationRooms as $cindicationRoom)
                                <tr>
                                    <td>{{ $cindicationRoom->number }}</td>
                                    <td>{{ $cindicationRoom->number_of_volunteers }}</td>
                                    <td>{{ count($cindicationRoom->volunteers) }}</td>
                                    <td>
                                        <a href="#"
                                            onclick="confirmDeleteRoom('{{ route('session.cindication_room.destroy', ['training_session' => Request::route('training_session')->id, 'training_center' => $trainingCenter->id, 'cindication_room' => $cindicationRoom->id]) }}')">
                                            <i class="fal fa-trash"></i>
                                        </a>
                                        <a
                                            href="{{ route('session.cindication_room.show', ['training_session' => Request::route('training_session')->id, 'training_center' => $trainingCenter->id, 'cindication_room' => $cindicationRoom->id]) }}">
                                            <i class="fal fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            @if (count($cindicationRooms) <= 0)
                                <tr style="font-size: 13px;" class="text-center">
                                    <td colspan="3" style="">No cindication room</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <!--begin: Items-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <div class="col-md-4">
            <div class="card card-custom gutter-b">
                <div class="py-5 border-0 card-header">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label font-weight-bolder text-dark">Assign Other users</span>
                    </h3>
                </div>
                <div class="pt-1 card-body">
                    <form id="checkerForm"
                        action="{{ route('session.training_center.assign_checker', ['training_session' => Request::route('training_session')->id, 'training_center' => $trainingCenter->id]) }}"
                        method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
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
                            <div class="ml-auto form-group col-md-12">
                                <input type="submit" value="Assign checkers"
                                    class="float-right btn btn-success w-100 d-block font-weight-bolder font-size-sm">
                            </div>
                        </div>
                    </form>
                    <form id="centerCoordinatorForm"
                        action="{{ route('session.training_center_based_permission.store', ['training_session' => Request::route('training_session')->id]) }}"
                        method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
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
    <form id="placeVolunteerForm"
        action="{{ route('session.training_center.placement', ['training_session' => Request::route('training_session')->id, 'training_center' => $trainingCenter->id]) }}"
        method="post">
        @csrf
    </form>
    <!--end::Card-->
    <form id="removeCheckerForm"
        action="{{ route('session.training_center.assign_checker', ['training_session' => Request::route('training_session')->id, 'training_center' => $trainingCenter->id]) }}"
        method="POST">
        @csrf
        <input type="hidden" name="checkerUser" id="checkerUserRemove">
    </form>




    <div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="addCapacityLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" action="{{  route('session.volunteer.import',['training_session' => Request::route('training_session')->id, 'training_center'=> $trainingCenter])}}" enctype="multipart/form-data">
            <input type="hidden" name="trainingCenterId" value="{{ $trainingCenter->id }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCapacityLabel">importing Excell for Bank Account </h5>
                    <button type="button" class="close" data-dismiss="modal" -label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group d-flex">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label class="d-block">Select file</label>
                                    <div class="custom-file">
                                        <input type="file"
                                            class=" custom-file-input"
                                            name="file" id="ministry_document"  multiple/>
                                        <label class="custom-file-label" for="customFile">Choose
                                            file</label>
                                        @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
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
        $('.select2').select2({
            allowClear: true
        });

        @if (old('training') != null)
            $('#assignMasterModal').modal().show()
        @endif

        function confirmPlacment(){
            Swal.fire({
                title: "Are you sure?",
                text: "You are able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, place volunteers!"
            }).then(function(result) {
                if (result.value) {
                    $('#placeVolunteerForm').submit();
                }
            });
        }

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

        function confirmDeleteRoom(route) {
            $('#deleteRoomForm').attr('action', route);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $('#deleteRoomForm').submit();
                }
            });
        }
    </script>
@endpush
