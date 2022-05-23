@extends('layouts.app')
@section('title', 'Applicant Atendance List')
@section('breadcrumb-list')
    <li class="active">attendance</li>
@endsection
@section('breadcrumbTitle', 'Attendance')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Attendance List</a>
    </li>
@endsection

@section('content')
{{-- <form method="POST" action="{{ route('session.training.attendance', ['training_session' => $trainingSession->id,'training_center'=>$trainingCenter->id, 'training'=>$training->id]) }}"> --}}
    @csrf
    <div class="card card-custom">
    <div class="card-header flex-wrap  pt-6 ">
        <div class="card-title mr-0">
            <div class="form-group">
                <h3 class="card-label">{{ $training->name }}</h3>
            </div>
            
        </div>

        <div class="card-toolbar">
            <button type="submit" class="btn btn-primary font-weight-bolder"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="svg-icon svg-icon-md" id="print_all">
                    <i class="flaticon2-print" id="i_text"></i>Import/Export
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                <!--begin::Navigation-->
                <ul class="navi navi-hover">
                    <li class="navi-header pb-1">
                        <span class="text-primary text-uppercase font-weight-bold font-size-sm">Import/Export:</span>
                    </li>
                    <li class="navi-item">
                        <a href="{{ route('attendance.export') }}" class="navi-link">
                            <span class="navi-icon">
                                <i class="flaticon2-shopping-cart-1"></i>
                            </span>
                            <span class="navi-text">Export Data</span>
                        </a>
                    </li>
                    <li class="navi-item">
                        <a href="#" class="navi-link">
                            <span class="navi-icon">
                                <i class="flaticon2-calendar-8"></i>
                            </span>
                            <span class="navi-text">Import Data</span>
                        </a>
                    </li>
                    </li>
                </ul>
                <!--end::Navigation-->
            </div>
        </div>
        
    </div>
        <div class="card-body pl-0" id="search_card" style="overflow: scroll;">
            <table width="100%" class="table" id="search_table">
                <thead>
                    </tr>
                        {{-- <th> ID </th> --}}
                        <th style="background-color:white;font-size:13px;width: 250px !important;position: sticky;left: 0;z-index: 999999;"> Name </th>
                        @foreach ($trainingSchedules as $trainingSchedule)
                            <th style="font-size: 13px;">{{ $trainingSchedule->schedule->dateET() }} {{ ($trainingSchedule->schedule->shift == 0)? "Morning" : "Afternoon"  }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @if (count($applicants) > 1)
                        @foreach ($applicants as $key => $applicant)
                            <tr style="font-size: 13px;">
                                {{-- <td>
                                    {{ $applicant->id }}
                                </td> --}}
                                <td style="background-color:white;width: 250px !important;position: sticky;left: 0;z-index: 999999;">
                                    {{$applicant->first_name}}
                                </td>
                                @foreach ($trainingSchedules as $trainingSchedule)
                                    @if (!$trainingSchedule->schedule->checkDateAtt())
                                        @if (in_array($trainingSchedule->id.','.$applicant->id, $att_history))  
                                            <td><input type="checkbox" name="applicant" class="checkbox" value="{{ $trainingSchedule->id }} ,{{ $applicant->id }}" checked disabled/></td>
                                        @else
                                            <td><input type="checkbox" name="applicant" class="checkbox" value="{{ $trainingSchedule->id }} ,{{ $applicant->id }}" disabled/></td>
                                        @endif
                                    @else 
                                        @if (in_array($trainingSchedule->id.','.$applicant->id, $att_history))  
                                            <td><input type="checkbox" name="applicant" class="checkbox" value="{{ $trainingSchedule->id }} ,{{ $applicant->id }}" checked/></td>
                                        @else
                                            <td><input type="checkbox" name="applicant" class="checkbox" value="{{ $trainingSchedule->id }} ,{{ $applicant->id }}"/></td>
                                        @endif
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td class="text text-danger text-center" colspan="4">
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
{{-- </form> --}}
@endsection

@push('js')
    <script>
        var myCheckboxes = new Array();
        $('input').change(function() {
            
            if(this.checked) {
                $.ajax({
                    type: "POST",
                    url: "/"+{{ $training->id }}+"/training/schedule",
                    data: {
                        'check': $(this).val(),
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(result){
                        console.log(result);
                    },
                });
            }else{
                console.log('sfdf');
                $.ajax({
                    type: "POST",
                    url: "/"+{{ $training->id }}+"/training/schedule/remove",
                    data: {
                        'check': $(this).val(),
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(result){
                        console.log(result);
                    },
                });
            }
        });
    </script>
@endpush