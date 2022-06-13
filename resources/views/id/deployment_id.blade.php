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
        $('#print_btn').on('click', function(){
            var applicants = @json($graduated_volunteers);
            applicants.forEach(applicant => {
                myDesign = document.createElement("div");
                // myDesign.setAttribute('id', 'myDesign'+key);
                myDesign.style.width = "210px";
                myDesign.style.height = "324px";
                myDesign.style.backgroundSize = "cover";
                myDesign.style.backgroundImage = "url({{ asset('img/id_page_1.jpg') }})";

                var profile_img = document.createElement('img');
                var div = document.createElement('div');
                // div.setAttribute('id', 'div_cont'+key);
                var div_img = document.createElement('div');
                profile_img.src = '{{ asset("img/meti.jpg") }}';
                profile_img.style.width = '89px';
                profile_img.style.height = '86.7px';
                profile_img.style.borderRadius = "50%";

                div_img.appendChild(profile_img);
                div_img.style.position = "relative";
                div_img.style.left = '60px';
                div_img.style.top = '119px';
                myDesign.appendChild(div_img);

                var blank_img = document.createElement('img');
                var div_blank = document.createElement('div');
                blank_img.src = '{{ asset("img/blank.png") }}';
                blank_img.style.width = '66px';
                blank_img.style.height = '39.7px';

                div_blank.appendChild(blank_img);
                div_blank.style.position = "relative";
                div_blank.style.left = '54px';
                div_blank.style.top = '119.123px';
                myDesign.appendChild(div_blank);

                var p = document.createElement("p");
                var s = document.createElement("strong");
                var textToAdd = document.createTextNode('ID: ');
                s.appendChild(textToAdd);
                p.appendChild(s);
                p.style.position = "relative";
                p.style.left = "61px";
                p.style.top = "71px";
                p.style.backgroundColor = "inherit";
                p.style.fontSize = '10px';
                p.style.color = 'blue';
                myDesign.appendChild(p);

                var p = document.createElement("p");
                var s = document.createElement("strong");
                var textToAdd = document.createTextNode(applicant.id_number);
                s.appendChild(textToAdd);
                p.appendChild(s);
                p.style.position = "relative";
                p.style.left = "81px";
                p.style.top = "50px";
                p.style.backgroundColor = "inherit";
                p.style.fontSize = '10px';
                p.style.color = 'blue';
                myDesign.appendChild(p);

                var p = document.createElement("p");
                var s = document.createElement("strong");
                var textToAdd = document.createTextNode('Name: ');
                s.appendChild(textToAdd);
                p.appendChild(s);
                p.style.position = "relative";
                p.style.left = "47px";
                p.style.top = "44px";
                p.style.backgroundColor = "inherit";
                p.style.fontSize = '10px';
                p.style.color = 'blue';
                myDesign.appendChild(p);

                var p2 = document.createElement("p");
                var s2 = document.createElement("strong");
                var textToAdd2 = document. createTextNode(applicant.first_name);
                s2.appendChild(textToAdd2);
                p2.appendChild(s2);
                p2.style.position = "relative";
                p2.style.left = '81px';
                p2.style.top = '24px';
                p2.style.backgroundColor = "inherit";
                p2.style.fontSize = '10px';
                p2.style.color = 'blue';
                myDesign.appendChild(p2);

                var p = document.createElement("p");
                var s = document.createElement("strong");
                var textToAdd = document.createTextNode('Training Center: ');
                s.appendChild(textToAdd);
                p.appendChild(s);
                p.style.position = "relative";
                p.style.left = "39px";
                p.style.top = "17px";
                p.style.backgroundColor = "inherit";
                p.style.fontSize = '10px';
                p.style.color = 'blue';
                myDesign.appendChild(p);

                var p = document.createElement("p");
                var s = document.createElement("strong");
                var textToAdd = document. createTextNode(applicant.approved_applicant.training_placement.deployment.woreda_intake.woreda.name);
                s.appendChild(textToAdd);
                p.appendChild(s);
                p.style.position = "relative";
                p.style.left = '115px';
                p.style.top = '-3px';
                p.style.backgroundColor = "inherit";
                p.style.fontSize = '10px';
                p.style.color = 'blue';
                myDesign.appendChild(p);

                var blank_img = document.createElement('img');
                var div_blank = document.createElement('div');
                blank_img.src = '{{ asset("img/blank.png") }}';
                blank_img.style.width = '109px';
                blank_img.style.height = '13.7px';

                div_blank.appendChild(blank_img);
                div_blank.style.position = "relative";
                div_blank.style.left = '46px';
                div_blank.style.top = '-12.123px';
                myDesign.appendChild(div_blank);

                var p = document.createElement("p");
                var s = document.createElement("strong");
                var textToAdd = document. createTextNode("\"በጎነት ለአብሮነት!\"");
                s.appendChild(textToAdd);
                p.appendChild(s);
                p.style.position = "relative";
                p.style.left = '48px';
                p.style.top = '-38px';
                p.style.backgroundColor = "inherit";
                p.style.fontSize = '13px';
                p.style.color = 'blue';
                myDesign.appendChild(p);

                var blank_img = document.createElement('img');
                var div_blank = document.createElement('div');
                blank_img.src = '{{ asset("img/blank.png") }}';
                blank_img.style.width = '49px';
                blank_img.style.height = '46.7px';

                div_blank.appendChild(blank_img);
                div_blank.style.position = "relative";
                div_blank.style.left = '77px';
                div_blank.style.top = '-48px';
                myDesign.appendChild(div_blank);

                var e_date = document.createElement("p");
                var se_date = document.createElement("strong");
                var setextToAdd = document. createTextNode('Exp. Date:');
                se_date.appendChild(setextToAdd);
                e_date.appendChild(se_date);
                e_date.style.position = "relative";
                e_date.style.left = '12px';
                e_date.style.top = '-101px';
                e_date.style.backgroundColor = "inherit";
                e_date.style.fontSize = '10px';
                e_date.style.color = 'blue';
                myDesign.appendChild(e_date);

                var e_date_text = document.createElement("p");
                var se_date_text = document.createElement("strong");
                var setextToAddText = document. createTextNode(applicant.session.end_date_am);
                se_date_text.appendChild(setextToAddText);
                e_date_text.appendChild(se_date_text);
                e_date_text.style.position = "relative";
                e_date_text.style.left = '61px';
                e_date_text.style.top = '-122px';
                e_date_text.style.backgroundColor = "inherit";
                e_date_text.style.fontSize = '10px';
                e_date_text.style.color = 'blue';
                myDesign.appendChild(e_date_text);

                var r_date = document.createElement("p");
                var sr_date = document.createElement("strong");
                var srtextToAdd = document. createTextNode('Role: ');
                sr_date.appendChild(srtextToAdd);
                r_date.appendChild(sr_date);
                r_date.style.position = "relative";
                r_date.style.left = '12px';
                r_date.style.top = '-125px';
                r_date.style.backgroundColor = "inherit";
                r_date.style.fontSize = '10px';
                r_date.style.color = 'blue';
                myDesign.appendChild(r_date);

                var r_date_text = document.createElement("p");
                var sr_date_text = document.createElement("strong");
                var srtextToAddText = document. createTextNode('Volunteer');
                sr_date_text.appendChild(srtextToAddText);
                r_date_text.appendChild(sr_date_text);
                r_date_text.style.position = "relative";
                r_date_text.style.left = '38px';
                r_date_text.style.top = '-146px';
                r_date_text.style.backgroundColor = "inherit";
                r_date_text.style.fontSize = '10px';
                r_date_text.style.color = 'blue';
                myDesign.appendChild(r_date_text);

                // // generateQR(applicant);
                var div__qr_img = document.createElement("div");

                var div__qr_img_2 = document.createElement("div");

                // div__qr_img.setAttribute('id', 'qrcode'+key);
                
                // myDesign.appendChild(div__qr_img);

                var qrcode = new QRCode(div__qr_img, {
                    text: applicant.id_number,
                    width: 50,
                    height: 44.7,
                    colorDark : "#000000",
                    colorLight : "#ffffff",
                    correctLevel : QRCode.CorrectLevel.H,
                });
                
                var img = qrcode._el.children[1];
                var src = div__qr_img.children[0].toDataURL("image/png");
                var qrf_img = document.createElement('img');

                qrf_img.src = src;
                div__qr_img_2.style.position = "relative";
                div__qr_img_2.style.left = '150px';
                div__qr_img_2.style.top = '-189px';
                div__qr_img_2.appendChild(qrf_img.cloneNode(true));
                myDesign.appendChild(div__qr_img_2.cloneNode(true));
                
                myDesignBack = document.createElement("div");
                myDesignBack.style.width = "324px";
                myDesignBack.style.height = "210px";
                myDesignBack.style.backgroundSize = "cover";
                myDesignBack.style.backgroundImage = "url({{ asset('img/ID_mopBack.jpg') }})";

                var pback = document.createElement("p");
                var sback = document.createElement("strong");
                var textToAddback = document.createTextNode('web: www.mop.gov.et');
                sback.appendChild(textToAddback);
                pback.appendChild(textToAddback);
                pback.style.position = "relative";
                pback.style.left = "60px";
                pback.style.top = "32px";
                pback.style.backgroundColor = "inherit";
                pback.style.fontSize = '10px';
                pback.style.color = 'white';
                pback.style.letterSpacing = "0.5px";
                myDesignBack.appendChild(pback);

                var pback2 = document.createElement("p");
                // var sback2 = document.createElement("strong");
                var textToAddback2 = document.createTextNode('+251(0)471117588');
                // sback.appendChild(textToAddback);
                pback2.appendChild(textToAddback2);
                pback2.style.position = "relative";
                pback2.style.left = "63px";
                pback2.style.top = "24px";
                pback2.style.backgroundColor = "inherit";
                pback2.style.fontSize = '10px';
                pback2.style.color = 'white';
                pback2.style.letterSpacing = "0.5px";
                myDesignBack.appendChild(pback2);

                var pback3 = document.createElement("p");
                // var sback2 = document.createElement("strong");
                var textToAddback3 = document.createTextNode('mail: mop@gmail.com');
                // sback.appendChild(textToAddback);
                pback3.appendChild(textToAddback3);
                pback3.style.position = "relative";
                pback3.style.left = "168px";
                pback3.style.top = "-10px";
                pback3.style.backgroundColor = "inherit";
                pback3.style.fontSize = '10px';
                pback3.style.color = 'white';
                pback3.style.letterSpacing = "0.5px";
                myDesignBack.appendChild(pback3);

                var pback4 = document.createElement("p");
                var sback4 = document.createElement("strong");
                var textToAddback4 = document.createTextNode('Full Name');
                sback4.appendChild(textToAddback4);
                pback4.appendChild(sback4);
                pback4.style.position = "relative";
                pback4.style.left = "8px";
                pback4.style.top = "6px";
                pback4.style.backgroundColor = "inherit";
                pback4.style.fontSize = '10px';
                pback4.style.color = 'black';
                pback4.style.fontStyle = "italic";
                pback4.style.letterSpacing = "0.5px";
                myDesignBack.appendChild(pback4);

                var pback5 = document.createElement("p");
                var sback5 = document.createElement("strong");
                var textToAddback5 = document.createTextNode(applicant.first_name);
                sback5.appendChild(textToAddback5);
                pback5.appendChild(sback5);
                pback5.style.position = "relative";
                pback5.style.left = "8px";
                pback5.style.top = "-1px";
                pback5.style.backgroundColor = "inherit";
                pback5.style.fontSize = '10px';
                pback5.style.color = 'black';
                pback5.style.letterSpacing = "0.5px";
                myDesignBack.appendChild(pback5);

                var pback6 = document.createElement("p");
                var sback6 = document.createElement("strong");
                var textToAddback6 = document.createTextNode('Nationality');
                sback6.appendChild(textToAddback6);
                pback6.appendChild(sback6);
                pback6.style.position = "relative";
                pback6.style.left = "8px";
                pback6.style.top = "6px";
                pback6.style.backgroundColor = "inherit";
                pback6.style.fontSize = '10px';
                pback6.style.color = 'black';
                pback6.style.fontStyle = "italic";
                pback6.style.letterSpacing = "0.5px";
                myDesignBack.appendChild(pback6);

                var pback7 = document.createElement("p");
                var sback7 = document.createElement("strong");
                var textToAddback7 = document.createTextNode('Ethiopian');
                sback7.appendChild(textToAddback7);
                pback7.appendChild(sback7);
                pback7.style.position = "relative";
                pback7.style.left = "8px";
                pback7.style.top = "-1px";
                pback7.style.backgroundColor = "inherit";
                pback7.style.fontSize = '10px';
                pback7.style.color = 'black';
                pback7.style.letterSpacing = "0.5px";
                myDesignBack.appendChild(pback7);

                var pback8 = document.createElement("p");
                var sback8 = document.createElement("strong");
                var textToAddback8 = document.createTextNode('Date of Issue');
                sback8.appendChild(textToAddback8);
                pback8.appendChild(sback8);
                pback8.style.position = "relative";
                pback8.style.left = "8px";
                pback8.style.top = "6px";
                pback8.style.backgroundColor = "inherit";
                pback8.style.fontSize = '10px';
                pback8.style.color = 'black';
                pback8.style.fontStyle = "italic";
                pback8.style.letterSpacing = "0.5px";
                myDesignBack.appendChild(pback8);

                var pback9 = document.createElement("p");
                var sback9 = document.createElement("strong");
                var textToAddback9 = document.createTextNode(applicant.approved_applicant.training_placement.deployment.issued_date_am);
                sback9.appendChild(textToAddback9);
                pback9.appendChild(sback9);
                pback9.style.position = "relative";
                pback9.style.left = "8px";
                pback9.style.top = "-1px";
                pback9.style.backgroundColor = "inherit";
                pback9.style.fontSize = '10px';
                pback9.style.color = 'black';
                pback9.style.letterSpacing = "0.5px";
                myDesignBack.appendChild(pback9);

                var pback10 = document.createElement("p");
                var sback10 = document.createElement("strong");
                var textToAddback10 = document.createTextNode('Deployment place');
                sback10.appendChild(textToAddback10);
                pback10.appendChild(sback10);
                pback10.style.position = "relative";
                pback10.style.left = "221px";
                pback10.style.top = "-71px";
                pback10.style.backgroundColor = "inherit";
                pback10.style.fontSize = '10px';
                pback10.style.color = 'black';
                pback10.style.fontStyle = "italic";
                pback10.style.letterSpacing = "0.5px";
                myDesignBack.appendChild(pback10);

                var pback11 = document.createElement("p");
                var sback11 = document.createElement("strong");
                var textToAddback11 = document.createTextNode(applicant.approved_applicant.training_placement.deployment.woreda_intake.woreda.name);
                sback11.appendChild(textToAddback11);
                pback11.appendChild(sback11);
                pback11.style.position = "relative";
                pback11.style.left = "221px";
                pback11.style.top = "-78px";
                pback11.style.backgroundColor = "inherit";
                pback11.style.fontSize = '10px';
                pback11.style.color = 'black';
                pback11.style.letterSpacing = "0.5px";
                myDesignBack.appendChild(pback11);

                var pback12 = document.createElement("p");
                var sback12 = document.createElement("strong");
                var textToAddback12 = document.createTextNode('Exp. Date');
                sback12.appendChild(textToAddback12);
                pback12.appendChild(sback12);
                pback12.style.position = "relative";
                pback12.style.left = "221px";
                pback12.style.top = "-81px";
                pback12.style.backgroundColor = "inherit";
                pback12.style.fontSize = '10px';
                pback12.style.color = 'black';
                pback12.style.fontStyle = "italic";
                pback12.style.letterSpacing = "0.5px";
                myDesignBack.appendChild(pback12);

                var pback13 = document.createElement("p");
                var sback13 = document.createElement("strong");
                var textToAddback13 = document.createTextNode(applicant.session.end_date_am);
                sback13.appendChild(textToAddback13);
                pback13.appendChild(sback13);
                pback13.style.position = "relative";
                pback13.style.left = "221px";
                pback13.style.top = "-88px";
                pback13.style.backgroundColor = "inherit";
                pback13.style.fontSize = '10px';
                pback13.style.color = 'black';
                pback13.style.letterSpacing = "0.5px";
                myDesignBack.appendChild(pback13);

                var div__bar_img_2 = document.createElement("div");
                var div__bar_img = document.createElement("img");
                
                JsBarcode(div__bar_img)
                    .options({font: "OCR-B", displayValue: true, width:0.9, height: 15, background: "white"})
                    .CODE128(applicant.id_number, {fontSize: 11, textMargin: 2, textPosition: "top", color:'inherit'})
                    .render();

                div__bar_img_2.style.position = "relative";
                // div__bar_img_2.style.float = "right";
                div__bar_img_2.style.left = '142px';
                div__bar_img_2.style.top = '-216px';
                div__bar_img.style.color = "black";

                div__bar_img_2.appendChild(div__bar_img.cloneNode(true));
                myDesignBack.appendChild(div__bar_img_2.cloneNode(true));

                var pbackdiv = document.createElement("div");
                var pback14 = document.createElement("p");
                var textToAddback14 = document.createTextNode('I certify that bearer of this Id card is an employee of Jimma University');
                pbackdiv.style.left = "37px";
                pbackdiv.style.top = "-150px";
                pbackdiv.style.width = "180px";
                pbackdiv.style.backgroundColor = "inherit";
                pbackdiv.style.position = "relative";
                var sback14 = document.createElement("strong");
                sback14.appendChild(textToAddback14);
                pback14.appendChild(sback14);
                pbackdiv.appendChild(pback14);
                pback14.style.textAlign = "center";
                pback14.style.fontSize = '9px';
                pback14.style.position = "relative";
                pback14.style.color = '#83dad1';
                pback14.style.letterSpacing = " .5px";
                myDesignBack.appendChild(pbackdiv);

                var profile_img = document.createElement('img');
                var div_img = document.createElement('div') 
                profile_img.src = '{{ asset("img/meti.jpg") }}';
                profile_img.style.width = '67px';
                profile_img.style.height = '61px';
                profile_img.style.borderRadius = "5%";

                div_img.appendChild(profile_img);
                div_img.style.position = "relative";
                div_img.style.left = '273px';
                div_img.style.top = '-361px';
                myDesignBack.appendChild(div_img);

                myDesign.style.pageBreakAfter = "always";
                myDesignBack.style.pageBreakAfter = "always";

                myDesign.style.transform = 'rotate(270deg)';
                myDesign.style.transformOrigin = "105px 106px";

                div.appendChild(myDesign.cloneNode(true));
                div.appendChild(myDesignBack.cloneNode(true));

                DATAS.push(div);
            });
            
            generatePDF(DATAS);
        });

        function generatePDF(div){
            var mywindow = window.open('', 'PRINT', 'height=1000,width=1000');

            mywindow.document.write('<html><head>');
            mywindow.document.write('</head><body >');
            div.forEach(element => {
                mywindow.document.write(element.innerHTML); 
            });
            mywindow.document.write('</body></html>');

            mywindow.document.close();
            mywindow.focus();

            setTimeout(() => {
                mywindow.print();
            }, 300);
        }
    </script>
@endpush