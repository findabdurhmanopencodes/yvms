@extends('layouts.guest')
@section('title','Form Page')
@push('css')
    <link href="{{ asset('assets/css/pages/error/error-3.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <div class="card card-custome">
        <div class="card-body">
            <div
                class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
                <!--begin::Main-->
                <div class="d-flex flex-column flex-root">
                    <!--begin::Error-->
                    <div class="error error-3 d-flex flex-row-fluid bgi-size-cover bgi-position-center">
                        <!--begin::Content-->
                        <div class="px-10 px-md-30 py-10 py-md-0 d-flex flex-column justify-content-md-center">
                            <div class="d-flex mb-2">
                                <img src="{{ asset('img/logo_peace.png') }}" class="mx-auto" width="150" alt="">
                            </div>
                            {{-- <h1 class="error-title text-stroke text-primary">Sorry</h1> --}}
                            <p class="mt-5 display-4 text-center font-weight-boldest  text-dark-75 mb-12" style="text-transform: uppercase">Currently we have no  volunteer program
                            </p>
                            <p class="font-size-h4 line-height-md"></p>
                            <h3 class="text-center">
                                <a class="btn btn-primary" href="{{ route('home', []) }}">Goto Home</a>
                            </h3>
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Error-->
                </div>
                <!--end::Main-->
            </div>
        </div>
    </div>
@endsection
