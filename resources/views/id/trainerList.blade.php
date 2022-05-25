@extends('layouts.app')
@section('title', 'Applicant Checked In List')
@section('breadcrumb-list')
    <li class="active">checked In list</li>
@endsection
@section('breadcrumbTitle', 'ID-Design')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">ID design</a>
    </li>
@endsection

@section('content')
<form method="POST" action="{{ route('session.training_center.generate', ['training_session' => Request::route('training_session'),'training_center'=>Request::route('training_center')]) }}">
    @csrf
    <div class="card card-custom">
    <input type="hidden" value="{{ $training_center_id }}" id="training_center_id">
    <div class="card-header flex-wrap  pt-6 ">
        <div class="card-title mr-0">
            <div class="form-group">
                <h3 class="card-label">Checked In Applicant List</h3>
                <br>
                <input type="text" id="search" class="form-control" placeholder="search by ID..." />
            </div>
        </div>
            <div class="card-toolbar">
                <button type="submit" class="btn btn-primary font-weight-bolder" >
                    <span class="svg-icon svg-icon-md" id="print_all">
                        <i class="flaticon2-print" id="i_text"></i>Print ID
                    </span>
                </button>
            </div>
    </div>
        <div class="card-body" id="search_card">
            <table width="100%" class="table table" id="search_table">
                <thead>
                    </tr>
                        <th>#   </th>
                        <th> ID </th>
                        <th> Name </th>
                        {{-- <th>ID count</th>
                        <th> Training Center </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @if (count($totalTrainingMasters) > 0)
                        @foreach ($totalTrainingMasters as $key => $applicant)
                            <tr>
                                <td><input type="checkbox" name="applicant[]" value="{{ $applicant->id }}" id="checkbox"/></td>
                                <td>
                                    {{ $applicant->id }}
                                </td>
                                <td>
                                    {{ $applicant->master->user->first_name }}
                                </td>
                                <td>
                                    {{-- @if ($applicant->idCount)
                                        {{ $applicant?->idCount?->count }}
                                    @else
                                        0
                                    @endif --}}
                                </td>
                                {{-- <td>
                                    {{ $applicant?->idCount?->count }}
                                </td> --}}
                                {{-- <td>
                                    {{ $applicant->approvedApplicant?->trainingPlacement?->trainingCenterCapacity?->trainingCenter?->code }}
                                </td> --}}
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
    {{-- <div class="m-auto col-6 mt-3" id="paginate">
        {{ $totalTrainingMasters->withQueryString()->links() }}
    </div> --}}
    </div>
</form>
@endsection

