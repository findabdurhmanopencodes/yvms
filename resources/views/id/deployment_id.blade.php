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
    #myCanvas{
        border:1px solid #000000;
        /* height: 300px;
        width: 250px; */
    }
    /* img {
        border-radius: 50%;
    } */
</style>
@endpush

@section('content')
<form method="POST" id="myForm" action="{{ route('id.download') }}">
    @csrf
    <input type="hidden" name="center" value="{{ $center }}">
    <input type="hidden" name="checkVal" value="deployment">
    <input type="hidden" id="htmlValue" value="{{ $graduated_volunteers }}" name="htmlVal">
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
                    <div class="col-lg-1">
                    </div>
                    <div class="col-lg-11">
                        <div class="row">
                            <div class="col-lg-6">
                                <p id="ptag" style="color: red">{{ count($graduated_volunteers) > 600 ? 'ID will be print 600 at once': '' }}</p>
                                <div class="card card-custom card-fit card-border">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h3 class="card-label">Front Design ID
                                        </div>
                                    </div>
                                    <div class="card-body pt-2">
                                        <div id="myDesign" style="border: #000000 solid 1px; width: 220px; height:339px;background-size:cover;background-image: url({{ asset('img/id_page_1.jpg') }});">
                                        </div>
                                    </div>

                                    {{-- <div class="card-footer">
                                        <div class="card-toolbar">
                                            <a id="print_btn" class="btn btn-sm btn-primary font-weight-bold" style="float: right; margin-right: 80px"><i class="flaticon2-print"></i>Print ID</a>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card card-custom card-fit card-border">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h3 class="card-label">Back Design ID
                                        </div>
                                    </div>
                                    <div class="card-body pt-2">
                                        <div id="myDesign" style="border: #000000 solid 1px; width: 339px; height:220px;background-size:cover;background-image: url({{ asset('img/ID_mopBack.jpg') }});">
                                            <p style="color: white; left: 61px; top: 30px; font-size: 10px; position: relative;">web: www.mop.gov.et</p>
                                            <p style="color: white; left: 184px; top: 3px; font-size: 10px; position: relative;">mail: mop@gmail.com</p>
                                            <p style="color: white; left: 64px; top: -10px; font-size: 10px; position: relative;">+251(0)471117588</p>
                                            <p style="font-style: italic; color: black; left: 16px; top: -13px; font-size: 10px; position: relative;">Full name</p>
                                            <p style="font-style: italic; color: black; left: 16px; top: 3px; font-size: 10px; position: relative;">Nationality</p>
                                            <p style="font-style: italic; color: black; left: 16px; top: 23px; font-size: 10px; position: relative;">Date of Issue</p>
                                            <p style="font-style: italic; color: black; left: 202px; top: -50px; font-size: 10px; position: relative;">Deployment place</p>
                                            <p style="font-style: italic; color: black; left: 202px; top: -47px; font-size: 10px; position: relative;">Exp. date</p>
                                        </div>
                                    </div>
                                    

                                    {{-- <div class="card-footer">
                                        <div class="card-toolbar">
                                            <a id="print_btn" class="btn btn-sm btn-primary font-weight-bold" style="float: right; margin-right: 80px"><i class="flaticon2-print"></i>Print ID</a>
                                        </div>
                                    </div> --}}
                                </div>
                                <br>
                                    <p>ID printed so far in (%)</p>
                                    <div class="progress">
                                        <div id="progressBar" class="progress-bar progress-bar-lg progress-bar-striped progress-bar-animated bg-danger " role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100">0%</div>
                                    </div>
                            </div>
                        </div>
                        <a id="print_btn" class="btn btn-sm btn-primary font-weight-bold" style="float: right; margin-right: 80px"><i class="flaticon2-print"></i>Print ID</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('js/qrcode.min.js') }}"></script>
    <script src="{{ asset('js/JsBarcode.all.min.js') }}"></script>
    <script>
        var DATAS = [];
        var obj = [];
        var objBarCode = [];
        var applicants = @json($graduated_volunteers);
        var start = 0;
        var end = 300;
        var len = Object.keys(applicants).length;
        $('#print_btn').on('click', function(){
            // var applicants = @json($graduated_volunteers);
            // Object.keys(applicants).forEach(key => {
            var items = applicants.slice(start, end).map(i => {
                return i;
            });
            var progressBarold = parseFloat(document.getElementById('progressBar').style.width);
            if (Object.keys(items).length != 0) {
                var a = (Object.keys(items).length/len)*100;
                if (a > 100) {
                    var b = a - 100;
                    a = a - b;
                }
                document.getElementById('progressBar').style.width = parseInt((a + progressBarold))+'%';
                document.getElementById('progressBar').innerHTML = parseInt((a + progressBarold))+'%';
                start=end;
                end+=300;
                document.getElementById('htmlValue').value = JSON.stringify(items);
                document.getElementById("myForm").submit();
                
            }else{
                document.getElementById('print_btn').style.visibility = 'hidden';
                document.getElementById('progressBar').style.width = '100%';
                document.getElementById('progressBar').innerHTML = '100%';
            }
        });

        function generatePDF(div){
            var mywindow = window.open('', 'PRINT', 'height=1000,width=1000');

            mywindow.document.write('<html><head>');
            mywindow.document.write('</head><body >');
            div.forEach(element => {
                mywindow.document.write(element.innerHTML);
            });

            console.log(mywindow.document.body);
            mywindow.document.write('</body></html>');

            var allDocument = mywindow.document.body.innerHTML;

            // document.getElementById('htmlValue').value = allDocument;

            // document.getElementById("myForm").submit();
            // mywindow.document.close();
            

            mywindow.focus();

            setTimeout(() => {
                mywindow.print();
            }, 300);
        }
    </script>
@endpush
