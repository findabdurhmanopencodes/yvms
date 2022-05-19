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
                        ID design
                        <small>Design id for volunteers</small>
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>ID no: </label>
                            <input type="text" class="form-control" id="id_text" name="id" value="JU3767/09"/>
                        </div>
                        <div class="form-group">
                            <label>X:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <a href="#" id="value_x_minus">-</a>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="id_x" value="105.859375" name="id_x"/>
                                <div class="input-group-postpend">
                                    <span class="input-group-text">
                                        <a href="#" id="value_x_plus">+</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Y:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <a href="#" id="value_y_minus">-</a>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="id_y" name="id_y" value="213.25"/>
                                <div class="input-group-postpend">
                                    <span class="input-group-text">
                                        <a href="#" id="value_y_plus">
                                            +
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        {{-- <a href="#" id="id_btn" class="btn btn-primary mr-2">Add ID</a> --}}
                    </div>
                    <div class="col-lg-2">
                        {{-- <div class="col-lg-4"> --}}
                        <div class="form-group">
                            <label>Name: </label>
                            <input type="text" class="form-control" name="name" value="Milky Seifu" id="name_text"/>
                        </div>
                        <div class="form-group">
                            <label>X:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <a href="#" id="value_x_minus">-</a>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="name_x" name="name_x" value="92"/>
                                <div class="input-group-postpend">
                                    <span class="input-group-text">
                                        <a href="#" id="value_x_plus">+</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Y:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <a href="#" id="value_y_minus">-</a>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="name_y" name="name_y" value="212"/>
                                <div class="input-group-postpend">
                                    <span class="input-group-text">
                                        <a href="#" id="value_y_plus">
                                            +
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        {{-- <a href="#" id="name_btn" class="btn btn-primary mr-2">Add name</a> --}}
                    </div>
                    <div class="col-lg-2">
                        {{-- <div class="col-lg-4"> --}}
                        <div class="form-group">
                            <label>Training center: </label>
                            <input type="text" class="form-control" id="center_text" name="center" value="JU"/>
                        </div>
                        <div class="form-group">
                            <label>X:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <a href="#" id="value_x_minus">-</a>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="center_x" name="center_x" value="141.859375"/>
                                <div class="input-group-postpend">
                                    <span class="input-group-text">
                                        <a href="#" id="value_x_plus">+</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Y:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <a href="#" id="value_y_minus">-</a>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="center_y" name="center_y" value="244.7"/>
                                <div class="input-group-postpend">
                                    <span class="input-group-text">
                                        <a href="#" id="value_y_plus">
                                            +
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        {{-- <a href="#" id="center_btn" class="btn btn-primary mr-2">Add center</a> --}}
                    </div>
                    <div class="col-lg-1">
                    </div>
                    <div class="col-lg-5">
                        <div>
                            <div id="myDesign" style=" width: 220px; height:339px;background-size:cover;background-image: url({{ asset('img/id_page_1.jpg') }})">
                                {{-- <img src="{{ asset('img/id_page_1.jpg') }}" alt="background image" style="width: 100%;"> --}}
                            </div>
                        </div>
                        <a id="print_btn" class="btn btn-primary mt-5" style="float: right; margin-right: 150px">Print ID</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
    <script>
        var DATAS = [];
        var div = document.createElement('div');
        var myDesign;
        $('#print_btn').on('click', function(event){
            var applicants = @json($applicants);
            applicants.forEach((applicant, key) => {
                myDesign = document.createElement("div");
                myDesign.setAttribute('id', 'myDesign'+key);
                myDesign.style.width = "220";
                myDesign.style.height = "339";
                myDesign.style.backgroundSize = "cover";
                myDesign.style.backgroundImage = "url({{ asset('img/id_page_1.jpg') }})";
                myDesign.style.marginRight = "100px";
                myDesign.style.marginBottom = "5vh";
                var p = document.createElement("p");
                var s = document.createElement("strong");
                var textToAdd = document.createTextNode(applicant.id);
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
                var textToAdd2 = document. createTextNode(applicant.first_name);
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
                // div.style.flexWrap = 'wrap';
                div.appendChild(myDesign.cloneNode(true))

                DATAS.push(div);
            });

            generatePDF(DATAS);
        })

        function generatePDF(abc){
            var mywindow = window.open('', 'PRINT', 'height=100%,width=100%');

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

            document.getElementById('print_btn').style.visibility = 'hidden';
            // location.reload();
            return true;
        }
        

    </script>
@endpush