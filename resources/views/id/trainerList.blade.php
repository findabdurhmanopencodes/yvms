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
<div id="master">
    <form method="POST" action="{{ route('session.training_center.generate', ['training_session' => Request::route('training_session'),'training_center'=>Request::route('training_center')]) }}">
        @csrf
        <input type="hidden" value="trainer" name="trainer_list_all">
        <div class="card card-custom">
        <div class="card-header flex-wrap  pt-6 ">
            <div class="card-title mr-0">
                <div class="form-group">
                    <h3 class="card-label">Trainer List</h3>
                </div>
            </div>
                <div class="card-toolbar">
                    @if (count($totalTrainingMasters) > 0)
                        <button type="submit" class="btn btn-primary font-weight-bolder" >
                            <span class="svg-icon svg-icon-md" id="print_all">
                                <i class="flaticon2-print" id="i_text"></i>Print ID
                            </span>
                        </button>
                    @endif
                </div>
        </div>
            <div class="card-body" id="search_card">
                <table width="100%" class="table table" id="search_table">
                    <thead>
                        </tr>
                            <th>#</th>
                            <th> ID </th>
                            <th> Name </th>
                            <th>User Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @if (count($totalTrainingMasters) > 0)
                            @foreach ($totalTrainingMasters as $key => $applicant)
                                <tr>
                                    <td><input type="checkbox" name="trainer_list[]" value="{{ $applicant->id }}" id="checkbox"/></td>
                                    <td>
                                        {{ $applicant->id }}
                                    </td>
                                    <td>
                                        {{ $applicant->master->user->first_name }} {{ $applicant->master->user->father_name }}
                                    </td>
                                    <td>
                                        Master Trainer
                                    </td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td class="text text-danger text-center" colspan="5">
                                Trainer not found
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
</div>

<div id="mop">
    <form method="POST" action="{{ route('session.training_center.generate', ['training_session' => Request::route('training_session'),'training_center'=>Request::route('training_center')]) }}">
        @csrf
        <input type="hidden" value="user" name="user_list_all">
        <div class="card card-custom">
        <div class="card-header flex-wrap  pt-6 ">
            <div class="card-title mr-0">
                <div class="form-group">
                    <h3 class="card-label">Mop Users List</h3>
                </div>
            </div>
                <div class="card-toolbar">
                    @if (count($mopUsers) > 0)
                        <button type="submit" class="btn btn-primary font-weight-bolder" >
                            <span class="svg-icon svg-icon-md" id="print_all">
                                <i class="flaticon2-print" id="i_text"></i>Print ID
                            </span>
                        </button>
                    @endif
                </div>
        </div>
            <div class="card-body" id="search_card">
                <table width="100%" class="table table" id="search_table">
                    <thead>
                        </tr>
                            <th>#</th>
                            <th> ID </th>
                            <th> Name </th>
                            <th>User Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @if (count($mopUsers) > 0)
                            @foreach ($mopUsers as $key => $applicant)
                                <tr>
                                    <td><input type="checkbox" name="mop_list[]" value="{{ $applicant->id }}" id="checkbox"/></td>
                                    <td>
                                        {{ $applicant->id }}
                                    </td>
                                    <td>
                                        {{ $applicant->user->first_name }} {{ $applicant->user->father_name }}
                                    </td>
                                    <td>
                                        Mop Users
                                    </td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td class="text text-danger text-center" colspan="5">
                                MoP user not found
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
</div>
@endsection

@push('js')

    <script>
        $( document ).ready(function() {
            $("#master :input").attr('disabled',true);
            $("#mop :input").attr('disabled',true);
        });

        $( "#master" ).click(function() {
            $("#master :input").attr('disabled',false);
            $("#mop :input").attr('disabled',true);
        });

        $( "#mop" ).click(function() {
            $("#mop :input").attr('disabled',false);
            $("#master :input").attr('disabled',true);  
        });    
    </script>    
@endpush