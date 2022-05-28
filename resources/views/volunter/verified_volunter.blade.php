@extends('layouts.app')
@section('action_title', 'Screeing Applicants')
@section('title', 'Screeing Applicants')
@section('breadcrumbTitle', 'Screeing Applicants')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="{{ route('training_session.index', []) }}">All Program</a>
    </li>
    <li class="active">Screening Applicants</li>
@endsection
@push('js')
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('assets/js/pages/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/pages/custom/profile/profile.js') }}"></script>
    <!--end::Page Scripts-->~
@endpush

@section('content')
    <div class="modal fade" id="trainingCenterEdit" tabindex="-1" role="dialog" aria-labelledby="trainingCenterEdit"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                {{-- <form action="/trh" method="POST"> --}}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Replace Applicant</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="changePlacementForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="font-weight-bolder mb-3">Applicant Info:</div>
                        <div class="line-height-xl">
                            <strong>Applicant Full Name:</strong> <span id="applicant_full_name"></span>
                            <br />
                            <strong>Applicant E-mail:</strong>
                            <span id="applicant_email"></span>
                            <br />
                            <strong>Applicant Phone no.:</strong> <span id="applicant_phone"></span>
                            <br />
                            <strong>Applicant Woreda:</strong> <span id="applicant_woreda"></span>
                        </div>
                        {{-- <div class="border-bottom mb-5 pb-5">

                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Replace" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="accordion accordion-solid accordion-toggle-plus " id="accordionExample6">

    </div>
    <div class="card card-custom">
        @if ($errors->any())
            <div class="alert alert-danger">
                <p><strong>Opps Something went wrong</strong></p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Applicants
                    <span class="d-block text-muted pt-2 font-size-sm">All Applicants In
                        {{ $trainingSession?->moto }}</span>
                </h3>
            </div>
            @if (count($approve) < 1)
                <div>

                    <a class="btn btn-sm btn-info"
                        href="{{ route('aplication.screen_out', ['training_session' => $trainingSession->id]) }}">
                        <i class="fa fa-eye"></i> Screen</a>
                </div>
            @else
                <div>
                    @if ($trainingSession->status == \App\Constants::TRAINING_SESSION_STARTED)
                        <a class="btn btn-sm btn-info"
                            href="{{ route('session.aplication.resetScreen', ['training_session' => $trainingSession->id]) }}">
                            <i class="fa fa-recycle"></i> Reset </a>
                    @endif
                </div>
            @endif
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <div class="datatable datatable-default datatable-bordered datatable-loaded">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Woreda</th>
                            <th>status</th>
                            @if (count($approve) > 0)
                                <th>Action</th>
                            @endif

                        </tr>
                    </thead>
                    <tbody style="" class="datatable-body">

                        @foreach ($volunters as $volunter)
                            <tr data-row="0" class="datatable-row" style="left: 0px;">
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
                                        class="badge badge-warning badge-pill">{{ $volunter->status?->acceptance_status == 0 ? 'pending' : 'Document Verified' }}</span>
                                </td>
                                @if (count($approve) > 0)
                                    <td>
                                        <a href="#"
                                            data-action="{{ route('session.screen.manual', [request()->route('training_session'), $volunter->id]) }}"
                                            class="btn btn-icon"
                                            onclick="$('#changePlacementForm').attr('action',this.dataset.action);onSubmit({{ $volunter->id }}, {{ $traininig_session }});">
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
        function onSubmit(volunter, traininig_session_id) {
            event.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "This applicant will replace other applicant!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, replace it!"
            }).then(function(result) {
                if (result.value) {
                    $('#trainingCenterEdit').modal();
                    $.ajax({
                        type: "POST",
                        url: "/applicant/infromation",
                        //   method: 'post',
                        data: {
                            'applicant_id': volunter,
                            'training_session_id': traininig_session_id,
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function(result) {
                            $('#applicant_full_name').html('  ' + result.applicant.first_name + ' ' +
                                result.applicant.father_name);
                            $('#applicant_email').html(result.applicant.email);
                            $('#applicant_phone').html(result.applicant.phone);
                            $('#applicant_woreda').html(result.applicant_woreda);
                        },
                    });
                }
            });
        }
    </script>
@endpush
