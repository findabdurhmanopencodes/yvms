@extends('layouts.app')
@section('title', 'Id Design')
@section('breadcrumb-list')
    <li class="active">ID design</li>
@endsection
@section('breadcrumbTitle', 'ID-Design')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">ID design</a>
    </li>
@endsection

@push('css')
    <style>
        #myCanvas {
            border: 1px solid #000000;
            /* height: 300px;
            width: 250px; */
        }

        /* img {
            border-radius: 50%;
        } */
    </style>
@endpush

@section('content')

    <form method="POST" id="myForm" action="{{ route('session.id.download', ['training_session' => $training_session_id]) }}">
        @csrf
        <input type="hidden" name="checkVal" value="checkedIn">
        <input type="hidden" name="end_date" value="{{ $train_end_date }}">
        <input type="hidden" name="center" value="{{ $center_code }}">
        <input type="hidden" name="userType" value="{{ $userType }}">
        <input type="hidden" name="trainer" value="{{ $trainer }}">
        <input type="hidden" id="htmlValue" value="{{ $applicants }}" name="htmlVal">
        {{-- <input type="hidden" id="htmlValue" name="htmlVal"> --}}
        <input type="hidden" id="qrValue" name="qrValue">
        <input type="hidden" id="barValue" name="barValue">
    </form>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">
                            <div>ID design</div>
                            <small>Design id for volunteers</small>
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="card-body">
                                <p id="ptag" style="color: red">
                                    {{ count($applicants) > 600 ? 'ID will be printed 600 at once' : '' }}</p>
                                <table width="100%" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> Name </th>
                                            <th>ID number</th>
                                            <th> Center </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($paginate_apps as $key => $applicant)
                                            <tr>
                                                <td>
                                                    {{ $key + 1 }}
                                                </td>
                                                <td>
                                                    @if ($table_name == 'volunteers')
                                                        {{ $applicant->first_name }} {{ $applicant->father_name }}
                                                    @elseif ($userType == 'mop user')
                                                        {{ $applicant->user->first_name . ' ' . $applicant->user->father_name }}
                                                    @else
                                                        {{ $applicant->master->user->first_name . ' ' . $applicant->master->user->father_name }}
                                                    @endif
                                                    {{-- {{($applicant->getTable() == 'volunteers'? $applicant->first_name:($userType == 'mop user'))? $applicant->user->first_name.' '.$applicant->user->father_name : $applicant->master->user->first_name.' '.$applicant->master->user->father_name}} --}}
                                                </td>
                                                <td>{{ $applicant->id_number }}</td>
                                                <td>
                                                    {{ $trainingCenter->code }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <p>ID printed so far in (%)</p>
                            <div class="progress">
                                <div id="progressBar"
                                    class="progress-bar progress-bar-lg progress-bar-striped progress-bar-animated bg-danger "
                                    role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                            {{-- <div class="m-auto col-6 mt-3">
                            {{ $paginate_apps->withQueryString()->links() }}
                        </div> --}}
                        </div>
                        <div class="col-lg-1">
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-custom card-fit card-border">
                                <div class="card-header">
                                    <div class="card-title">
                                        {{-- <span class="card-icon">
                                        <i class="flaticon2-pin text-primary"></i>
                                    </span> --}}
                                        <h3 class="card-label">ID Design
                                    </div>
                                </div>
                                <div class="card-body pt-2">
                                    <div>
                                        {{-- <div id="qrcode"></div> --}}
                                        <div id="myDesign"
                                            style="width: 220px; height:339px;background-size:cover;background-image: url({{ asset('img/id_page_1.jpg') }});">
                                            {{-- <img src="{{ asset('img/id_page_1.jpg') }}" alt="background image" style="width: 100%;"> --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="card-toolbar" id="idPrint">
                                        {{-- <a id="print_btn2" class="btn btn-sm btn-primary font-weight-bold" style="float: right; margin-right: 80px"><i class="flaticon2-print"></i>Print Check ID</a> --}}

                                        <a id="print_btn" class="btn btn-sm btn-primary font-weight-bold"
                                            style="float: right; margin-right: 80px"><i class="flaticon2-print"></i>Print
                                            ID</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('js/qrcode.min.js') }}"></script>
    <script>
        var DATAS = [];
        var obj = [];
        var div = document.createElement('div');
        var myDesign;
        var applicants = @json($applicants);
        // var paginate_apps = @json($applicants);
        // console.log(paginate_apps);
        var start = 0;
        var end = 600;
        var len = Object.keys(applicants).length;

        $('#print_btn').on('click', function(event) {

            if ('{{ $trainer }}' == 'trainer') {
                applicants.forEach((applicant, key) => {
                    document.getElementById("myForm").submit();
                    document.getElementById('print_btn').style.visibility = 'hidden';
                    document.getElementById('progressBar').style.width = '100%';
                    document.getElementById('progressBar').innerHTML = '100%';
                });
            } else {
                var items = applicants.slice(start, end).map(i => {
                    return i;
                });
                var progressBarold = parseFloat(document.getElementById('progressBar').style.width);
                if (Object.keys(items).length != 0) {
                    var a = (Object.keys(items).length / len) * 100;
                    if (a > 100) {
                        var b = a - 100;
                        a = a - b;
                    }
                    document.getElementById('progressBar').style.width = parseInt((a + progressBarold)) + '%';
                    document.getElementById('progressBar').innerHTML = parseInt((a + progressBarold)) + '%';
                    start = end;
                    end += 600;
                    document.getElementById('htmlValue').value = JSON.stringify(items);
                    document.getElementById("myForm").submit();
                } else {
                    document.getElementById('print_btn').style.visibility = 'hidden';
                    document.getElementById('progressBar').style.width = '100%';
                    document.getElementById('progressBar').innerHTML = '100%';
                }
            }
            // document.getElementById('qrValue').value = obj;
            // document.getElementById("myForm").submit();
            // generatePDF(DATAS, paginate_apps);
        })

        function generatePDF(abc, applicants) {
            var mywindow = window.open('', 'PRINT', 'height=1000,width=1000');

            mywindow.document.write('<html><head>');
            mywindow.document.write('</head><body >');
            mywindow.document.write('<div style="display:flex; flex-wrap: wrap">');
            abc.forEach(element => {
                mywindow.document.write(element.innerHTML);
            });

            mywindow.document.write('</div>');
            mywindow.document.write('</body></html>');

            mywindow.document.close();
            mywindow.focus();

            setTimeout(() => {
                mywindow.print();
                // mywindow.close();
            }, 300);

            toastr.success('ID printed');

            document.getElementById('print_btn').style.visibility = 'hidden';

            setTimeout(() => {
                $.ajax({
                    type: "POST",
                    url: "/" + {{ $training_center_id }} + "/id/count",
                    data: {
                        'applicants': applicants,
                        'training_session_id': {{ $training_session_id }},
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(result) {
                        console.log(result.message);
                    },
                });
            }, 200);
            return true;
        }
    </script>
@endpush
