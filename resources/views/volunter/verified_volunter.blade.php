@extends('layouts.app')
@section('action_title', 'Screeing Applicants')
@section('title', 'Screeing Applicants')
@section('breadcrumbTitle', 'Screeing Applicants')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="{{ route('training_session.index', []) }}">All Program</a>
    </li>
    <li class="active">Screeing Applicants</li>
@endsection
@push('js')
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('assets/js/pages/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/pages/custom/profile/profile.js') }}"></script>
    <!--end::Page Scripts-->~
@endpush

@section('content')
    <div class="accordion accordion-solid accordion-toggle-plus " id="accordionExample6">

        <div class="card ">
            <div id="headingThree6" class="card-header text-white" style="background-color: rgba(15, 69, 105, 0.6);">
                <div class="card-title collapsed text-white" data-toggle="collapse" data-target="#collapseThree6"
                    style="background-color: rgba(15, 69, 105, 0.6);">
                    <i class="flaticon2-search fa-2x text-white"></i> Screen requirments
                </div>
            </div>
            <div id="collapseThree6" class="collapse" data-parent="#accordionExample6">
                <div class="card-body">
                    @csrf
                    {{-- <div class="row"> --}}
                    <form class="form">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Age</label>
                                <div class="radio-list">
                                    <label class="radio">
                                        <input type="radio" name="age" />18 - 25
                                        <span></span></label>
                                    <label class="radio">
                                        <input type="radio" name="age" />26 - 35
                                        <span></span></label>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label>Graduation Year</label>
                                <div class="radio-list">
                                    <label class="radio">
                                        <input type="radio" name="year" />last year
                                        <span></span></label>
                                    <label class="radio">
                                        <input type="radio" name="year" />last two year
                                        <span></span></label>
                                </div>
                            </div>
                        </div>
                    </form>
                    {{-- </div> --}}
                </div>

            </div>
        </div>
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
                        {{ $trainingSession->moto }}</span>
                </h3>
            </div>
            @if (count($volunters) > 0)
                <div>

                    <a class="btn btn-sm btn-info"
                        href="{{ route('aplication.screen_out', ['training_session' => $trainingSession->id]) }}">
                        <i class="fa fa-eye"></i> Screen</a>
                </div>
            @else
                <div>
                    <a class="btn btn-sm btn-info"
                        href="{{ route('session.aplication.resetScreen', ['training_session' => $trainingSession->id]) }}">
                        <i class="fa fa-recycle"></i> Reset </a>
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
