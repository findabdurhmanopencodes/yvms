@extends('layouts.app')
@section('title', 'Screening Applicant')
@section('breadcrumb-list')
    <li class="active">Screening</li>
@endsection
@section('breadcrumbTitle', 'Applicant Detail')
@section('breadcrumbList')

    <li class="breadcrumb-item">
        <a href="" class="text-muted">Applicant Screening</a>
    </li>
    <li class="breadcrumb-item">
        <a href="" class="text-muted">{{ $applicant->first_name }} {{ $applicant->father_name }}</a>
    </li>
@endsection

@section('content')
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
                    <th>Email</th>
                    <th>Woreda</th>
                    <th>status</th>
                    <th> Actions</th>

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
                            {{ $volunter->email }}
                        </td>
                        <td>
                            {{ $volunter->woreda?->name }}
                        </td>
                        <td>
                            <span class="badge badge-warning badge-pill">Pending</span>
                        </td>

                        <td>
                            <div class="row">
                                <a class="btn btn-sm btn-info" href="{{ route('applicant.show', ['applicant'=>$volunter->id]) }}">
                                    <i class="fa fa-eye"></i> Detail</a>
                            </div>

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
</div>@endsection


