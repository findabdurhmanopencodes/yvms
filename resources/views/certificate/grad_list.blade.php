@extends('layouts.app')
@section('title', 'Graduated Volunteer List')
@section('breadcrumb-list')
    <li class="active">Graduated Volunteer List</li>
@endsection
@section('breadcrumbTitle', 'ID-Design')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Certificate Design</a>
    </li>
@endsection

@section('content')
<form method="POST" action="{{ route('session.generate.certificate', ['training_session' => Request::route('training_session')]) }}">
    @csrf
    <div class="card card-custom">
        <div class="card-header flex-wrap  pt-6 ">
            <div class="card-title mr-0">

            </div>
            @if ($applicants)
                <div class="card-toolbar">
                    <button type="submit" class="btn btn-primary font-weight-bolder" >
                        <span class="svg-icon svg-icon-md" id="print_all">
                            <i class="flaticon2-print" id="i_text"></i>Print Certificate
                        </span>
                    </button>
                </div>
            @endif

        </div>
            <div class="card-body" id="search_card">
                <table width="100%" class="table table" id="search_table">
                    <thead>
                        </tr>
                            <th>#   </th>
                            <th> ID Number</th>
                            <th>First Name </th>
                            <th>Father Name </th>
                            <th>Deployed Center</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($applicants) > 0)
                            @foreach ($applicants as $key => $applicant)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        {{ $applicant->id_number }}
                                    </td>
                                    <td>
                                        {{ $applicant->first_name }}
                                    </td>
                                    <td>
                                        {{ $applicant->father_name }}
                                    </td>
                                    <td>
                                        {{ $applicant->approvedApplicant->trainingPlacement->deployment->woredaIntake->woreda->name }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td class="text text-danger text-center" colspan="5">
                                Volunteer not found
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        <div class="m-auto col-6 mt-3" id="paginate">
            {{ $applicants->withQueryString()->links() }}
        </div>
    </div>
</form>
@endsection

@push('js')

@endpush
