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
        /* height: 300px;
        width: 250px; */
    }
    /* img {
        border-radius: 50%;
    } */
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
                                    {{-- <span class="card-icon">
                                        <i class="flaticon2-pin text-primary"></i>
                                    </span> --}}
                                    <h3 class="card-label">Certificate Design
                                </div>
                            </div>
                            <div class="card-body pt-2">
                                <div>
                                    <div id="myDesign" style="width: 600px; height:400px; background-size:cover;background-image: url({{ asset('img/certificate.jpeg') }});">
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
        var date = new Date().toISOString().slice(0, 10);
        var myDesign;

        var statDesign = document.getElementById('myDesign');

        var blank_img = document.createElement('img');
        var div_blank = document.createElement('div');
        blank_img.src = '{{ asset("img/blank.png") }}';
        blank_img.style.width = '134px';
        blank_img.style.height = '21.7px';

        div_blank.appendChild(blank_img);
        div_blank.style.position = "relative";
        div_blank.style.left = '54';
        div_blank.style.top = '170.123';
        statDesign.appendChild(div_blank);

        var blank_img = document.createElement('img');
        var div_blank = document.createElement('div');
        blank_img.src = '{{ asset("img/blank.png") }}';
        blank_img.style.width = '134px';
        blank_img.style.height = '21.7px';

        div_blank.appendChild(blank_img);
        div_blank.style.position = "relative";
        div_blank.style.left = '338';
        div_blank.style.top = '134.123';
        statDesign.appendChild(div_blank);

        var DATAS = [];
        $('#print_btn').on('click', function(event){
            var applicants = @json($applicants);

            applicants.forEach((applicant, key) => {
                var div = document.createElement('div');
                myDesign = document.createElement("div");
                myDesign.setAttribute('id', 'myDesign'+key);
                myDesign.style.width = "1180px";
                myDesign.style.height = "836px";
                myDesign.style.backgroundSize = "cover";
                myDesign.style.backgroundImage = "url({{ asset('img/certificate.jpeg') }})";
                myDesign.style.marginRight = "100px";
                myDesign.style.marginBottom = "5vh";

                var blank_img = document.createElement('img');
                var div_blank = document.createElement('div');
                blank_img.src = '{{ asset("img/blank.png") }}';
                blank_img.style.width = '141px';
                blank_img.style.height = '23.7px';

                div_blank.appendChild(blank_img);
                div_blank.style.position = "relative";
                div_blank.style.left = '123';
                div_blank.style.top = '356.123';
                myDesign.appendChild(div_blank);

                var p = document.createElement("p");
                var s = document.createElement("strong");
                var textToAdd = document.createTextNode(applicant.first_name);
                s.appendChild(textToAdd);
                p.appendChild(s);
                p.style.position = "relative";
                p.style.left = "119";
                p.style.top = "309";
                p.style.backgroundColor = "inherit";
                p.style.fontSize = '26px';
                p.style.color = 'rgb(162 128 67)';
                myDesign.appendChild(p);

                var blank_img2 = document.createElement('img');
                var div_blank2 = document.createElement('div');
                blank_img2.src = '{{ asset("img/blank.png") }}';
                blank_img2.style.width = '205px';
                blank_img2.style.height = '25.7px';

                div_blank2.appendChild(blank_img2);
                div_blank2.style.position = "relative";
                div_blank2.style.left = '687';
                div_blank2.style.top = '221.123';
                myDesign.appendChild(div_blank2);

                var p2 = document.createElement("p");
                var s2 = document.createElement("strong");
                var textToAdd2 = document.createTextNode(applicant.first_name);
                s2.appendChild(textToAdd2);
                p2.appendChild(s2);
                p2.style.position = "relative";
                p2.style.left = "700";
                p2.style.top = "168";
                p2.style.backgroundColor = "inherit";
                p2.style.fontSize = '26px';
                p2.style.color = 'rgb(162 128 67)';
                myDesign.appendChild(p2);

                var blank_img3 = document.createElement('img');
                var div_blank3 = document.createElement('div');
                blank_img3.src = '{{ asset("img/blank.png") }}';
                blank_img3.style.width = '193px';
                blank_img3.style.height = '25.7px';

                div_blank3.appendChild(blank_img3);
                div_blank3.style.position = "relative";
                div_blank3.style.left = '863';
                div_blank3.style.top = '440.123';
                myDesign.appendChild(div_blank3);

                var blank_img4 = document.createElement('img');
                var div_blank4 = document.createElement('div');
                blank_img4.src = '{{ asset("img/blank.png") }}';
                blank_img4.style.width = '216px';
                blank_img4.style.height = '25.7px';

                div_blank4.appendChild(blank_img4);
                div_blank4.style.position = "relative";
                div_blank4.style.left = '163';
                div_blank4.style.top = '405.123';
                myDesign.appendChild(div_blank4);

                var p3 = document.createElement("p");
                var s3 = document.createElement("strong");
                var textToAdd3 = document.createTextNode("{{ $curr_date_et }}");
                s3.appendChild(textToAdd3);
                p3.appendChild(s3);
                p3.style.position = "relative";
                p3.style.left = "226";
                p3.style.top = "356";
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
                p4.style.left = "921";
                p4.style.top = "310.123";
                p4.style.backgroundColor = "inherit";
                p4.style.fontSize = '24px';
                p4.style.color = 'rgb(162 128 67)';
                myDesign.appendChild(p4);
                myDesign.style.pageBreakAfter = "always";
                
                div.appendChild(myDesign.cloneNode(true));

                DATAS.push(div);

            });

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
