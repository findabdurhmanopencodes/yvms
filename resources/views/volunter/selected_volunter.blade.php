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
    <!--end::Page Scripts-->~
@endpush

@section('content')

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
                <h3 class="card-label">Selected Applicants
                    <span class="d-block text-muted pt-2 font-size-sm">All Selected Applicants
                        {{ $trainingSession?->moto }}</span>
                </h3>


            </div>

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
                                        class="badge badge-success badge-pill">{{ $volunter->status?->acceptance_status == 3 ? 'Accepted' : 'pendind' }}</span>
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
