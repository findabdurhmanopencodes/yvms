@extends('layouts.app')
@section('title', 'Volunteer List')
@section('breadcrumb-list')
    <li class="active">{{ $trainingCenter->code }} volunteer List</li>
@endsection
@section('breadcrumbTitle', 'ID-Design')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">{{ $trainingCenter->code }} volunteer List</a>
    </li>
@endsection

@section('content')
<form method="POST" action="{{ route('session.graduate.volunteers', ['training_session'=>$trainingSession, 'training_center'=>$trainingCenter]) }}">
    @csrf
    <input type="hidden" name="max_attendance" value="{{ count($arr_unique) }}">
    <input type="hidden" name="training_center" value="{{ $trainingCenter->id }}">
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modalx-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Graduate Volunteers</h5>
                    <button type="button" class="close" data-dismiss="modal" -label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-lg-9">
                                    <label>Attendace amount</label>
                                    <input type="number" id="att_amount" class="form-control" name="att_amount" max="{{ count($arr_unique) }}"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label>Pass All</label>
                                    <input type="checkbox" id="gc_vol" name="gc_vol" class="checkbox"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
{{-- <form method="POST" action="{{ route('session.training_center.generate', ['training_session' => Request::route('training_session'),'training_center'=>$trainingCenter->id]) }}"> --}}
    {{-- @csrf --}}
    <div class="card card-custom">
    <input type="hidden" value="{{ $trainingCenter->id }}" id="training_center_id">
    <div class="card-header flex-wrap  pt-6 ">
        <div class="card-title mr-0">
            <div class="form-group">
                <h3 class="card-label">{{ $trainingCenter->code }} volunteer List</h3>
                <br>
                <input type="text" id="search" class="form-control" placeholder="search by ID..." />
            </div>
        </div>
        @if ($applicants)
            <div class="card-toolbar">
                <a href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#exampleModal">
                    <span class="svg-icon svg-icon-md">
                        <i class="flaticon-medal" id="i_text"></i>
                 </span>
                 Graduate Volunteers</a>
            </div>
        @endif

    </div>
        <div class="card-body" id="search_card">
            <table width="100%" class="table table" id="search_table">
                <thead>
                    </tr>
                        <th> ID Number</th>
                        <th> Name </th>
                        <th>Attendance Count({{ count($arr_unique) }})</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody> 
                    @if (count($applicants) > 0)
                        @foreach ($applicants as $key => $applicant)
                            <tr>
                                <td>
                                    {{ $applicant->id_number }}
                                </td>
                                <td>
                                    {{ $applicant->first_name }}
                                </td>
                                <td>
                                    {{ $userAttendance->where('user_id', $applicant->user->id)->count() }}
                                </td>
                                <td>
                                    @if ($applicant->status->acceptance_status == 6)
                                        <a href="#" class="btn btn-success">
                                            <span class="svg-icon svg-icon-md">
                                                <i class="flaticon-medal" id="i_text"></i>
                                        </span>
                                        Graduated</a>
                                    @else
                                    <a href="#" class="btn btn-danger">
                                        <span class="svg-icon svg-icon-md">
                                            <i class="flaticon-medal" id="i_text"></i>
                                    </span>
                                    Graduate</a>
                                    @endif
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
{{-- </form> --}}
@endsection

@push('js')
    <script>
        var body = $('#search_table tbody').html();
        var table = $("#search_card").html();
        var i = document.createElement('i');
        i.classList.add("flaticon2-print");

        function getTableCell(c){
            return `<td>${c}</td>`;
        }
        $('#search').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
        $('#search').on('input', function(){
            if ($('#search').val()) {
                $.ajax({
                type: "POST",
                url: '/'+{{ $trainingCenter->id }}+"/search/applicant",
                data: {
                    'training_center_id': {{ $trainingCenter->id }},
                    'search': $('#search').val(),
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(result){
                    var data = result.applicants.data;
                    if (data.length > 0) {
                        $('#search_table tbody').html('');
                        data.forEach(element => {
                            var input = `<input type="checkbox" name="applicant[]" value="${element.id}" id="checkbox"/>`;
                            $('#search_table tbody').append("<tr>"+getTableCell(input)+getTableCell(element.id)+getTableCell(element.first_name)+getTableCell(element.approved_applicant.training_placement.training_center_capacity.training_center.code)+"</tr>");
                        });
                        $("#paginate").hide();
                    }else{
                        // $('#search_table tbody').html('');
                        $('#search_table tbody').html("<tr><td class='text text-danger text-center' colspan='4'>Volunteer not found</td> </tr>");
                    }
                },
                });
            }else{
                $('#search_table tbody').html(body);
            }
        });

        $('#att_amount').on('input', function(){
            if ($('#att_amount').val()) {
                $('#gc_vol').attr('disabled',true);
            }else{
                $('#gc_vol').attr('disabled',false);
            }
        });

        $('#att_amount').on('input', function(){
            if ($('#att_amount').val()) {
                $('#gc_vol').attr('disabled',true);
            }else{
                $('#gc_vol').attr('disabled',false);
            }
        });

        $('#gc_vol').change(function() {
            if(this.checked) {
                $('#att_amount').attr('disabled',true);
            }else{
                $('#att_amount').attr('disabled',false);
            }
        });

        // $('#att_amount').on('keydown', function() {
        //     var key = event.keyCode || event.charCode;

        //     if( key == 8 || key == 46 ){
        //         if ($('#att_amount').val() == '') {
        //             $('#gc_vol').attr('enabled',true);
        //         }
        //     }
        // });
        $('#checkbox').change(function() {
            if(this.checked) {
                $('#print_all').html('');
                $('#print_all').append(i);
                $('#print_all').append('Print ID')
            }else{
                $('#print_all').html('');
                $('#print_all').append(i);
                $('#print_all').append('Print All ID')
            }
        });
    </script>
@endpush
