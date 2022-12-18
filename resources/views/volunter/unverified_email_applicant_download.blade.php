@extends('layouts.app')
@section('title', 'Training Session Detail')
@section('breadcrumbTitle', 'Training Session Detail')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="{{ route('training_session.index', []) }}">All Training Sessions</a>
    </li>
    <li class="breadcrumb-item">Detail</li>

@endsection



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
                <h3 class="card-label">
                    <span>Total: {{ $volunters->total() }}</span>
                     Applicants

                        <div class="">


                        </div>
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
                                        class="badge badge-warning badge-pill">{{ $volunter->status?->acceptance_status == 0 ? 'pending' : 'decided' }}</span>
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
                    {{-- {!! $volunters->links() !!} --}}
                </div>
            </div>
            <!--end: Datatable-->
        </div>
    </div>

@endsection
