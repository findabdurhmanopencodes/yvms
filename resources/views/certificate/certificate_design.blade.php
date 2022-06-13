@extends('layouts.app')
@section('title', 'Certificate Design')
@section('breadcrumb-list')
    <li class="active">Certificate design</li>
@endsection
@section('breadcrumbTitle', 'ID-Design')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Certificate design</a>
    </li>
@endsection

@push('css')
<style>
    #myCanvas{
        border:1px solid #000000;
    }
</style>
@endpush

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">
                        <div>Certificate Design</div>
                        <small>Certificate Design for Volunteers</small>
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-custom card-fit card-border">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">Certificate Design
                                </div>
                                <div class="card-toolbar">
                                    <div class="form-group row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <select class="form-control select2" id="certificate">
                                                <option value="volunteers">Volunteers</option>
                                                <option value="coordinators">Coordinators</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-2">
                                <div>
                                    <div id="myDesign" style="width: 600px; height:400px; background-size:cover;background-image: url({{ asset('img/certificate_app.png') }});">
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="card-toolbar">
                                    <a id="print_btn" class="btn btn-sm btn-primary font-weight-bold" style="float: right; margin-right: 80px"><i class="flaticon2-print"></i>Print Certificate</a>
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
    <script>
        $('.select2').select2({});
    </script>
    <script>
        var date = new Date().toISOString().slice(0, 10);
        var mydes = document.getElementById('myDesign');

        $( "#certificate" ).change(function() {
            if ($('#certificate').val() == 'volunteers') {
                mydes.style.backgroundImage = "url({{ asset('img/certificate_app.png') }})";
            }else{
                mydes.style.backgroundImage = "url({{ asset('img/meti.jpg') }})";
            }
        });

        $('#print_btn').on('click', function(event){

            if ($('#certificate').val() == 'volunteers') {
                var DATAS = [];
                var myDesign;
                
            } else {
                var applicants = @json($applicants);
                var DATAS = [];
                var myDesign;

                applicants.forEach((applicant, key) => {
                    var div = document.createElement('div');
                    myDesign = document.createElement("div");
                    myDesign.setAttribute('id', 'myDesign'+key);
                    myDesign.style.width = "1180px";
                    myDesign.style.height = "836px";
                    myDesign.style.backgroundSize = "cover";
                    myDesign.style.backgroundImage = "url({{ asset('img/certificate_app.png') }})";
                    // myDesign.style.marginRight = "100px";

                    var p = document.createElement("p");
                    var s = document.createElement("strong");
                    var textToAdd = document.createTextNode(applicant.first_name);
                    s.appendChild(textToAdd);
                    p.appendChild(s);
                    p.style.position = "relative";
                    p.style.left = "127px";
                    p.style.top = "360px";
                    p.style.backgroundColor = "inherit";
                    p.style.fontSize = '26px';
                    p.style.color = 'rgb(162 128 67)';
                    myDesign.appendChild(p);

                    var p2 = document.createElement("p");
                    var s2 = document.createElement("strong");
                    var textToAdd2 = document.createTextNode(applicant.first_name);
                    s2.appendChild(textToAdd2);
                    p2.appendChild(s2);
                    p2.style.position = "relative";
                    p2.style.left = "693px";
                    p2.style.top = "272px";
                    p2.style.backgroundColor = "inherit";
                    p2.style.fontSize = '26px';
                    p2.style.color = 'rgb(162 128 67)';
                    myDesign.appendChild(p2);

                    var p3 = document.createElement("p");
                    var s3 = document.createElement("strong");
                    var textToAdd3 = document.createTextNode("{{ $curr_date_et }}");
                    s3.appendChild(textToAdd3);
                    p3.appendChild(s3);
                    p3.style.position = "relative";
                    p3.style.left = "211px";
                    p3.style.top = "527px";
                    p3.style.backgroundColor = "inherit";
                    p3.style.fontSize = '24px';
                    p3.style.color = 'rgb(162 128 67)';
                    myDesign.appendChild(p3);

                    var p4 = document.createElement("p");
                    var s4 = document.createElement("strong");
                    var textToAdd4 = document.createTextNode("{{ $curr_date_now }}");
                    s4.appendChild(textToAdd4);
                    p4.appendChild(s4);
                    p4.style.position = "relative";
                    p4.style.left = "927px";
                    p4.style.top = "487px";
                    p4.style.backgroundColor = "inherit";
                    p4.style.fontSize = '24px';
                    p4.style.color = 'rgb(162 128 67)';
                    myDesign.appendChild(p4);
                    myDesign.style.pageBreakAfter = "always";
                    
                    div.appendChild(myDesign.cloneNode(true));

                    DATAS.push(div);

                });   
            }

            generatePDF(DATAS, applicants);
        })

        function generatePDF(abc, applicants){
            var mywindow = window.open('', 'PRINT', 'height=2000,width=2000');

            mywindow.document.write('<html><head>');
            mywindow.document.write('</head><body >');
            // mywindow.document.write('<div style="">');
            abc.forEach(element => {
                mywindow.document.write(element.innerHTML);
            });
            // mywindow.document.write('<br>');
            // mywindow.document.write('</div>');
            mywindow.document.write('</body></html>');

            mywindow.document.close();
            mywindow.focus();

            setTimeout(() => {
                mywindow.print();
                // mywindow.close();
            }, 300);

            toastr.success('ID printed');
            return true;
        }
    </script>
@endpush
