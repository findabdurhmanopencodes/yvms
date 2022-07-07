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
    <input type="hidden" name="checkVal" value="checkedIn">
    <input type="hidden" name="end_date" value="{{ $train_end_date }}">
    <input type="hidden" name="center" value="{{ $center_code }}">
    <input type="hidden" name="userType" value="{{ $userType }}">
    <input type="hidden" name="trainer" value="{{ $trainer }}">
    <input type="hidden" id="htmlValue" value="{{ $applicants }}" name="htmlVal">
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
                            <table width="100%" class="table table-striped ">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> Name </th>
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
                                                @if ($applicant->getTable() == 'volunteers')
                                                    {{ $applicant->first_name }}
                                                @elseif ($userType == 'mop user')
                                                    {{ $applicant->user->first_name.' '.$applicant->user->father_name }}
                                                @else
                                                    {{ $applicant->master->user->first_name.' '.$applicant->master->user->father_name }}
                                                @endif
                                                {{-- {{($applicant->getTable() == 'volunteers'? $applicant->first_name:($userType == 'mop user'))? $applicant->user->first_name.' '.$applicant->user->father_name : $applicant->master->user->first_name.' '.$applicant->master->user->father_name}} --}}
                                            </td>
                                            <td>
                                                {{ $trainingCenter->code }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                                    <div id="myDesign" style="width: 220px; height:339px;background-size:cover;background-image: url({{ asset('img/id_page_1.jpg') }});">
                                        {{-- <img src="{{ asset('img/id_page_1.jpg') }}" alt="background image" style="width: 100%;"> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="card-toolbar">
                                    {{-- <a id="print_btn2" class="btn btn-sm btn-primary font-weight-bold" style="float: right; margin-right: 80px"><i class="flaticon2-print"></i>Print Check ID</a> --}}

                                    <a id="print_btn" class="btn btn-sm btn-primary font-weight-bold" style="float: right; margin-right: 80px"><i class="flaticon2-print"></i>Print ID</a>
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
        var paginate_apps = @json($applicant_count);
        $('#print_btn').on('click', function(event){
            if ('{{ $trainer }}' == 'trainer') {
                applicants.forEach((applicant, key) => {
                    var div = document.createElement('div');
                    div.setAttribute('id', 'div_cont'+key);
                    myDesign = document.createElement("div");
                    myDesign.setAttribute('id', 'myDesign'+key);
                    myDesign.style.width = "220";
                    myDesign.style.height = "339";
                    myDesign.style.backgroundSize = "cover";
                    myDesign.style.backgroundImage = "url({{ asset('img/id_page_1.jpg') }})";
                    myDesign.style.margin = "2vh";

                    var blank_img = document.createElement('img');
                    var div_blank = document.createElement('div');
                    blank_img.src = '{{ asset("img/blank.png") }}';
                    blank_img.style.width = '206px';
                    blank_img.style.height = '257.7px';

                    div_blank.appendChild(blank_img);
                    div_blank.style.position = "relative";
                    div_blank.style.left = '7';
                    div_blank.style.top = '75.123';
                    myDesign.appendChild(div_blank);

                    var p = document.createElement("p");
                    var s = document.createElement("strong");
                    var textToAdd = document.createTextNode("Ethiopian National Volunteer Community");
                    s.appendChild(textToAdd);
                    p.appendChild(s);
                    p.style.position = "relative";
                    p.style.left = "12px";
                    p.style.top = "-195px";
                    p.style.backgroundColor = "inherit";
                    p.style.fontSize = '11px';
                    p.style.color = '#01b1f2';
                    myDesign.appendChild(p);

                    var p2 = document.createElement("p");
                    var s2 = document.createElement("strong");
                    var textToAdd2 = document.createTextNode("Development Service Program");
                    s2.appendChild(textToAdd2);
                    p2.appendChild(s2);
                    p2.style.position = "relative";
                    p2.style.left = "37px";
                    p2.style.top = "-207px";
                    p2.style.backgroundColor = "inherit";
                    p2.style.fontSize = '11px';
                    p2.style.color = '#01b1f2';
                    myDesign.appendChild(p2);

                    var p4 = document.createElement("p");
                    var s4 = document.createElement("strong");
                    var textToAdd4 = document.createTextNode('{{ $userType }}' == 'mop user' ? 'Mop User' : 'Master Trainer');
                    s4.appendChild(textToAdd4);
                    p4.appendChild(s4);
                    p4.style.position = "relative";
                    p4.style.left = "39px";
                    p4.style.top = "-211px";
                    p4.style.backgroundColor = "inherit";
                    p4.style.fontSize = '18px';
                    p4.style.color = '#01b1f2';
                    myDesign.appendChild(p4);

                    var p5 = document.createElement("p");
                    var s5 = document.createElement("strong");
                    var textToAdd5 = document.createTextNode("Full Name: ");
                    s5.appendChild(textToAdd5);
                    p5.appendChild(s5);
                    p5.style.position = "relative";
                    p5.style.left = "18px";
                    p5.style.top = "-211px";
                    p5.style.backgroundColor = "inherit";
                    p5.style.fontSize = '12.5px';
                    p5.style.color = '#000000';
                    myDesign.appendChild(p5);

                    var p6 = document.createElement("p");
                    var s6 = document.createElement("strong");

                    var textToAdd6 = document.createTextNode("{{ $userType }}" == 'mop user' ? applicant.user.first_name+' '+applicant.user.father_name : applicant.master.user.first_name+' '+applicant.master.user.father_name);
                    s6.appendChild(textToAdd6);
                    p6.appendChild(s6);
                    p6.style.position = "relative";
                    p6.style.left = "87px";
                    p6.style.top = "-237px";
                    p6.style.marginRight = "45px";
                    p6.style.backgroundColor = "inherit";
                    p6.style.fontSize = '11px';
                    p6.style.color = '#000000';
                    myDesign.appendChild(p6);
                    myDesign.marginRight = "100px";
                    
                    var p7 = document.createElement("p");
                    var s7 = document.createElement("strong");
                    var textToAdd7 = document.createTextNode("Training Center: ");
                    s7.appendChild(textToAdd7);
                    p7.appendChild(s7);
                    p7.style.position = "relative";
                    p7.style.left = "18px";
                    p7.style.top = "-242px";
                    p7.style.backgroundColor = "inherit";
                    p7.style.fontSize = '12.5px';
                    p7.style.color = '#000000';
                    myDesign.appendChild(p7);

                    var p8 = document.createElement("p");
                    var s8 = document.createElement("strong");
                    var textToAdd8 = document.createTextNode('{{ $center_code }}'.toUpperCase());
                    s8.appendChild(textToAdd8);
                    p8.appendChild(s8);
                    p8.style.position = "relative";
                    p8.style.left = "117px";
                    p8.style.top = "-267px";
                    p8.style.backgroundColor = "inherit";
                    p8.style.fontSize = '11px';
                    p8.style.color = '##000000';
                    myDesign.appendChild(p8);

                    var p9 = document.createElement("p");
                    var s9 = document.createElement("strong");
                    var textToAdd9 = document.createTextNode("Exp.Date: ");
                    s9.appendChild(textToAdd9);
                    p9.appendChild(s9);
                    p9.style.position = "relative";
                    p9.style.left = "18px";
                    p9.style.top = "-271px";
                    p9.style.backgroundColor = "inherit";
                    p9.style.fontSize = '12.5px';
                    p9.style.color = '#000000';
                    myDesign.appendChild(p9);

                    var p10 = document.createElement("p");
                    var s10 = document.createElement("strong");
                    var textToAdd10 = document.createTextNode("{{ $train_end_date }}");
                    s10.appendChild(textToAdd10);
                    p10.appendChild(s10);
                    p10.style.position = "relative";
                    p10.style.left = "79px";
                    p10.style.top = "-297px";
                    p10.style.backgroundColor = "inherit";
                    p10.style.fontSize = '11px';
                    p10.style.color = '#000000';
                    myDesign.appendChild(p10);

                    var p11 = document.createElement("p");
                    var s11 = document.createElement("strong");
                    var textToAdd11 = document.createTextNode("ብሔራዊ የበጎ ፈቃድ ማህበረሰብ አገልገሎት");
                    s11.appendChild(textToAdd11);
                    p11.appendChild(s11);
                    p11.style.position = "relative";
                    p11.style.left = "2px";
                    p11.style.top = "-287px";
                    p11.style.backgroundColor = "inherit";
                    p11.style.fontSize = '13px';
                    p11.style.color = '#01b1f2';
                    p11.style.textAlign = 'center';
                    myDesign.appendChild(p11);

                    var p3 = document.createElement("p");
                    var s3 = document.createElement("strong");
                    var textToAdd3 = document.createTextNode("\"በጎነት ለአብሮነት!\"");
                    s3.appendChild(textToAdd3);
                    p3.appendChild(s3);
                    p3.style.position = "relative";
                    p3.style.left = "51px";
                    p3.style.top = "-279px";
                    p3.style.backgroundColor = "inherit";
                    p3.style.fontSize = '19px';
                    p3.style.color = '#01b1f2';
                    myDesign.appendChild(p3);

                    myDesign.style.pageBreakAfter = "always";
                    myDesign.style.pageBreakBefore = "always";
                    div.appendChild(myDesign.cloneNode(true))

                    DATAS.push(div);
                    
                });
            } else {
                applicants.forEach((applicant, key) => {
                    myDesign = document.createElement("div");
                    myDesign.setAttribute('id', 'myDesign'+key);
                    myDesign.style.width = "220";
                    myDesign.style.height = "339";
                    myDesign.style.backgroundSize = "cover";
                    myDesign.style.backgroundImage = "url({{ asset('img/id_page_1.jpg') }})";
                    myDesign.style.margin = "4vh";
                    
                    var p = document.createElement("p");
                    var s = document.createElement("strong");
                    var textToAdd = document.createTextNode(applicant.id_number);
                    s.appendChild(textToAdd);
                    p.appendChild(s);
                    p.style.position = "relative";
                    p.style.left = "92px";
                    p.style.top = "204px";
                    p.style.backgroundColor = "inherit";
                    p.style.fontSize = '10px';
                    p.style.color = 'blue';
                    myDesign.appendChild(p);

                    var p2 = document.createElement("p");
                    var s2 = document.createElement("strong");
                    var textToAdd2 = document. createTextNode(applicant.first_name+' '+applicant.father_name);
                    s2.appendChild(textToAdd2);
                    p2.appendChild(s2);
                    p2.style.position = "relative";
                    p2.style.left = '92';
                    p2.style.top = '198';
                    p2.style.backgroundColor = "inherit";
                    p2.style.fontSize = '10px';
                    p2.style.color = 'blue';
                    myDesign.appendChild(p2);

                    var p = document.createElement("p");
                    var s = document.createElement("strong");
                    var textToAdd = document. createTextNode(applicant.approved_applicant.training_placement.training_center_capacity.training_center.code);
                    s.appendChild(textToAdd);
                    p.appendChild(s);
                    p.style.position = "relative";
                    p.style.left = '126';
                    p.style.top = '194';
                    p.style.backgroundColor = "inherit";
                    p.style.fontSize = '10px';
                    p.style.color = 'blue';
                    myDesign.appendChild(p);

                    var profile_img = document.createElement('img');
                    var div = document.createElement('div');
                    div.setAttribute('id', 'div_cont'+key);
                    var div_img = document.createElement('div');
                    profile_img.src = '{{ asset("img/meti.jpg") }}';
                    profile_img.style.width = '92px';
                    profile_img.style.height = '86.7px';
                    profile_img.style.borderRadius = "50%";

                    div_img.appendChild(profile_img);
                    div_img.style.position = "relative";
                    div_img.style.left = '62';
                    div_img.style.top = '54';
                    myDesign.appendChild(div_img);

                    var blank_img = document.createElement('img');
                    var div_blank = document.createElement('div');
                    blank_img.src = '{{ asset("img/blank.png") }}';
                    blank_img.style.width = '49px';
                    blank_img.style.height = '50.7px';

                    div_blank.appendChild(blank_img);
                    div_blank.style.position = "relative";
                    div_blank.style.left = '81';
                    div_blank.style.top = '122.123';
                    myDesign.appendChild(div_blank);

                    var e_date = document.createElement("p");
                    var se_date = document.createElement("strong");
                    var setextToAdd = document. createTextNode('Exp. Date: ');
                    se_date.appendChild(setextToAdd);
                    e_date.appendChild(se_date);
                    e_date.style.position = "relative";
                    e_date.style.left = '12';
                    e_date.style.top = '68';
                    e_date.style.backgroundColor = "inherit";
                    e_date.style.fontSize = '10px';
                    e_date.style.color = 'blue';
                    myDesign.appendChild(e_date);

                    var e_date_text = document.createElement("p");
                    var se_date_text = document.createElement("strong");
                    var setextToAddText = document. createTextNode('{{ $train_end_date }}');
                    se_date_text.appendChild(setextToAddText);
                    e_date_text.appendChild(se_date_text);
                    e_date_text.style.position = "relative";
                    e_date_text.style.left = '59';
                    e_date_text.style.top = '47';
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
                    r_date.style.left = '12';
                    r_date.style.top = '42';
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
                    r_date_text.style.left = '38';
                    r_date_text.style.top = '21';
                    r_date_text.style.backgroundColor = "inherit";
                    r_date_text.style.fontSize = '10px';
                    r_date_text.style.color = 'blue';
                    myDesign.appendChild(r_date_text);

            //         // generateQR(applicant);
                    var div__qr_img = document.createElement("div");

                    var div__qr_img_2 = document.createElement("div");

                    div__qr_img.setAttribute('id', 'qrcode'+key);
                    
            //         // myDesign.appendChild(div__qr_img);

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

                    obj.push(src);

                    qrf_img.src = src;
                    div__qr_img_2.style.position = "relative";
                    div__qr_img_2.style.left = '140';
                    div__qr_img_2.style.top = '-20';
                    div__qr_img_2.appendChild(qrf_img.cloneNode(true));
                    myDesign.appendChild(div__qr_img_2.cloneNode(true));

                    // myDesign.style.pageBreakAfter = "always";
                    div.appendChild(myDesign.cloneNode(true));

                    DATAS.push(div);

                });
            }
            document.getElementById('qrValue').value = obj;
            document.getElementById("myForm").submit();
            // generatePDF(DATAS, paginate_apps);
        })

        function generatePDF(abc, applicants){
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
                    url: "/"+{{ $training_center_id }}+"/id/count",
                    data: {
                        'applicants': applicants,
                        'training_session_id': {{ $training_session_id }},
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(result){
                        console.log(result.message);
                    },
                });
            }, 200);
            return true;
        }

    </script>
@endpush
