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
    <div class="card-header flex-wrap  pt-6 ">
        <div class="card-title mr-0">
            {{-- <h3 class="card-label">Checked In Applicant List</h3> --}}
            <div class="form-group">
                <h3 class="card-label">Checked In Applicant List</h3>
                <br>
                <input type="text" id="search" class="form-control" placeholder="search by ID..." />
            </div>
        </div>
        <div class="card-toolbar">
            <button type="submit" class="btn btn-primary font-weight-bolder" >
                <span class="svg-icon svg-icon-md">
                    <i class="flaticon2-print"></i>Print ID
                </span>
            </button>
        </div>
    </div>
        <div class="card-body" id="search_card">
            <table width="100%" class="table table-striped" id="search_table">
                <thead>
                    </tr>
                        <th>#   </th>
                        <th> ID </th>
                        <th> Name </th>
                        <th> Training Center </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applicants as $key => $applicant)
                        <tr>
                            <td><input type="checkbox" name="applicant[]" value="{{ $applicant->id }}"/></td>
                            <td>
                                {{ $applicant->id }}
                            </td>
                            <td>
                                {{$applicant->first_name}}
                            </td>
                            <td>
                                {{ $applicant->approvedApplicant->trainingPlacement->trainingCenterCapacity->trainingCenter->code }}
                            </td>
                        </tr>
                    @endforeach
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
    <script>
        var body = $('#search_table tbody').html();
        var table = $("#search_card").html();
        function getTableCell(c){
            return `<td>${c}</td>`;
        }
        $('#search').on('input', function(){
            if ($('#search').val()) {
                $.ajax({
                type: "POST",
                url: "/search/applicant",
                data: {
                    'search': $('#search').val(),
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(result){
                    if (result.applicants.data) {
                        var data = result.applicants.data;
                        $('#search_table tbody').html('');
                        data.forEach(element => {
                            var input = `<input type="checkbox" name="applicant[]" value="${element.id}"/>`;
                            $('#search_table tbody').append("<tr>"+getTableCell(input)+getTableCell(element.id)+getTableCell(element.first_name)+getTableCell(element.approved_applicant.training_placement.training_center_capacity.training_center.code)+"</tr>");
                        });
                        $("#paginate").hide();
                    }
                },
                });
            }else{
                $('#search_table tbody').html('');
                $('#search_table tbody').append(body);
            }
        });
    </script>
@endpush