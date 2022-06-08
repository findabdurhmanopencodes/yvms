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
                    <div class="col-lg-6">
                        <div class="card card-custom card-fit card-border">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">Design ID
                                </div>
                            </div>
                            <div class="card-body pt-2">
                                <div id="myDesign" style="width: 220px; height:339px;background-size:cover;background-image: url({{ asset('img/id_page_1.jpg') }});">
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="card-toolbar">
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
        $('#print_btn').on('click', function(){

            var mywindow = window.open('', 'PRINT', 'height=1000,width=1000');

            mywindow.document.write('<html><head>');
            mywindow.document.write('</head><body >');
            // mywindow.document.write('<div style="display:flex; flex-wrap: wrap">');
            // abc.forEach(element => {
                mywindow.document.write(div.innerHTML);
            // });

            // mywindow.document.write('</div>');
            mywindow.document.write('</body></html>');

            mywindow.document.close();
            mywindow.focus();

            setTimeout(() => {
                mywindow.print();
                // mywindow.close();
            }, 300);

        });
    </script>
@endpush