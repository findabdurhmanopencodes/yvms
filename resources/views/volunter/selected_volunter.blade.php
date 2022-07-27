@extends('layouts.app')
@section('action_title', 'Selected Applicants')
@section('title', 'Selected Applicants')
@section('breadcrumbTitle', 'Selected Applicants')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="{{ route('training_session.index', []) }}">All Program</a>
    </li>
    <li class="active">Selected Applicants</li>
@endsection
@push('js')
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('assets/js/pages/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/pages/custom/profile/profile.js') }}"></script>
    <!--end::Page Scripts-->
@endpush

@section('content')

    <div class="modal fade" id="trainingCenterEdit" tabindex="-1" role="dialog" aria-labelledby="trainingCenterEdit"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                {{-- <form action="/trh" method="POST"> --}}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Assign Training Center</h5>
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
                                @foreach ($trainingCenterCapacities as $trainingCenterCapacity)
                                    <option value="{{ $trainingCenterCapacity->id }}">
                                        {{ $trainingCenterCapacity->trainingCenter->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Assign" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card card-custom">

        @if ($errors->any())
            <div class="alert alert-danger">
                <p><strong>Oops Something went wrong</strong></p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Selected Applicants
                    <span class="d-block text-muted pt-2 font-size-sm">All Selected Applicants
                        {{ $trainingSession?->moto }}</span>
                </h3>


            </div>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-3 ml-auto">
                    @if ($trainingSession->status == \App\Constants::TRAINING_SESSION_STARTED)
                        <form method="POST"
                            action="{{ route('session.applicant.place', [request()->route('training_session')]) }}">
                            @csrf
                            <button class="btn btn-primary">Place All Volunteers</button>
                        </form>
                    @endif
                </div>
            </div>
            <!--begin: Datatable-->
            <div class="datatable datatable-default datatable-bordered datatable-loaded">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Woreda</th>
                            <th>status</th>
                            @if ($trainingSession->status == \App\Constants::TRAINING_SESSION_STARTED)
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody style="" class="datatable-body">

                        @foreach ($volunters as $volunter)
                            <tr data-row="0" style="font-size: 13px;" class="datatable-row" style="left: 0px;">
                                <td>
                                    {{ $volunters->perPage() * $volunters->currentPage() - ($volunters->perPage() - ($loop->index + 1)) }}
                                </td>
                                <td>
                                    {{ $volunter->first_name }} {{ $volunter->father_name }}
                                </td>
                                <td>
                                    {{ $volunter->gender }}
                                </td>
                                <td>
                                    {{ $volunter->phone }}
                                </td>

                                <td>
                                    {{ $volunter->woreda?->name }}
                                </td>
                                <td>
                                    <span
                                        class="badge badge-success badge-pill">{{ $volunter->status?->acceptance_status == 3 ? 'Accepted' : 'pending' }}</span>
                                </td>
                                @if ($trainingSession->status == \App\Constants::TRAINING_SESSION_STARTED)
                                    <td>
                                        <a href="#"
                                            data-action="{{ route('session.placement.manual', [request()->route('training_session'), $volunter->approvedApplicant->id]) }}"
                                            class="btn btn-icon"
                                            onclick="$('#changePlacementForm').attr('action',this.dataset.action);onSubmit();">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        @if (count($volunters) < 1)
                            <tr>
                                <td class="text-capitalize text-danger font-size-h4">No Applicants Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {!! $volunters->links() !!}
                </div>
            </div>
            <!--end: Datatable-->
        </div>
    </div>

@endsection
@push('js')
    <script>
        $('.select2').select2({});
    </script>

    <script>
        function onSubmit() {
            event.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "This Will Place the Volunteer to a training center!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Place it!"
            }).then(function(result) {
                if (result.value) {
                    $('#trainingCenterEdit').modal();
                }
            });
        }
    </script>
@endpush
