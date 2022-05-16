@extends('layouts.app')
@section('title', 'Unverified  Volunteers Email')
@section('breadcrumb-list')
    <li class="active">Unverified  Volunteers Email</li>
@endsection
@section('breadcrumbTitle', 'Applicant Detail')
@section('breadcrumbList')

    <li class="breadcrumb-item">
        <a href="" class="text-muted">Unverified  Volunteers Email</a>
    </li>

@endsection
@section('content')
<div class="card-body">
.<div class="card">
    <div class="card-header">
        <a class="btn btn-primary float-right" href="{{ route('applicant.unverified-email-download','1') }}">Export To Pdf</a>
    </div>
    <div class="card-body">
        <h5 class="card-title">Title</h5>
          <!--begin: Datatable-->
    <div class="datatable datatable-default datatable-bordered datatable-loaded">
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
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
                            {{ $volunter->phone }}
                        </td>
                        <td>
                            {{ $volunter->email }}
                        </td>
                        <td>
                            {{ $volunter->woreda?->name }}
                        </td>
                        <td>
                            <span class="badge badge-warning badge-pill">Email Unverified </span>
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
</div>@endsection


