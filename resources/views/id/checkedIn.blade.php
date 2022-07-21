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
        @can('TraininingCenter.checkedInIDPrint')
            @if ($applicants)
                <div class="card-toolbar">
                    <button type="submit" class="btn btn-primary font-weight-bolder" >
                        <span class="svg-icon svg-icon-md" id="print_all">
                            <i class="flaticon2-print" id="i_text"></i>Print All ID
                        </span>
                    </button>
                </div>
            @endif
        @endcan

    </div>
        <div class="card-body" id="search_card">
            <table width="100%" class="table table" id="search_table">
                <thead>
                    </tr>
                        <th>#   </th>
                        <th> ID </th>
                        <th> Name </th>
                        <th>ID count</th>
                        <th> Training Center </th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($applicants) > 0)
                        @foreach ($applicants as $key => $applicant)
                            <tr>
                                <td><input type="checkbox" name="applicant[]" value="{{ $applicant->volunteer_id }}" id="checkbox"/></td>
                                <td>
                                    {{ $applicant->id_number }}
                                </td>
                                <td>
                                    {{ $applicant->first_name }} {{ $applicant->father_name }}
                                </td>
                                <td>
                                    {{-- @if ($applicant->idCount)
                                        {{ $applicant?->idCount?->count }}
                                    @else --}}
                                        0
                                    {{-- @endif --}}
                                </td>
                                {{-- <td>
                                    {{ $applicant?->idCount?->count }}
                                </td> --}}
                                <td>
                                    {{ $applicant->code }}
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
                url: '/'+{{ $training_center_id }}+"/search/applicant",
                data: {
                    'training_center_id': {{ $training_center_id }},
                    'search': $('#search').val(),
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(result){
                    var data = result.applicants.data;
                    if (data.length > 0) {
                        $('#search_table tbody').html('');
                        data.forEach(element => {
                            var count = element.idCount || 0;
                            var input = `<input type="checkbox" name="applicant[]" value="${element.id}" id="checkbox"/>`;
                            $('#search_table tbody').append("<tr>"+getTableCell(input)+getTableCell(element.id_number)+getTableCell(element.first_name+' ' +element.father_name)+getTableCell(count)+getTableCell(element.approved_applicant.training_placement.training_center_capacity.training_center.code)+"</tr>");
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
