@extends('layouts.guest')
@section('title', 'Home')

@section('content')
    <div class="mb-2">
        <div class="d-flex bg-white flex-row-fluid bgi-size-cover bgi-position-center" style="background-image: url('')">
            <div class="container">
                <div class="d-flex align-items-stretch text-center flex-column py-2">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{ asset('img/peace_logo_max.png') }}" class="mx-auto" width="300" alt="">
                        </div>
                        <div class="col-md-6 d-flex">
                            <div style='font-family:serif !important;padding: 0;margin: 0; line-height: 1.5; color: #01afee; font-size: 30px; align-self:center;'>
                                <p style="font-weight: 100;">State Minister for Peacebuilding and National Reconciliation</p>
                                <p style="font-weight: 100;">ብሔራዊ የበጎ ፈቃድ ማህበረሰብ <br> አገልገሎት</p>
                                <h6 style="font-family:serif !important;padding: 0;font-size:25px;margin: 0; line-height: 1; color: #01afee;align-self:center;">በጎነት ለአብሮነት</h6>
                            </div>

                        </div>
                    </div>
                    <!--begin::Heading-->
                </div>
            </div>
        </div>
        {{-- <img src="{{ asset('assets/media/logos/header.jpg') }}" class="col-md-10"/> --}}
    </div>
    <div class="row bg-blend-lighten">
        <div class="col-lg-6">
            <!--begin::Callout-->
            <div class="card card-custom mb-2 bg-diagonal bg-diagonal-light-success">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between p-4">
                        <!--begin::Content-->
                        <div class="d-flex flex-column mr-5">
                            <a href="{{ route('aplication.form', []) }}"
                                class="h4 text-dark text-hover-primary mb-5">Apply
                                to be volunteer</a>
                            <p class="text-dark-50">Windows 10 automatically installs updates <br />to make for sure</p>
                        </div>
                        <!--end::Content-->
                        <!--begin::Button-->
                        <div class="ml-6 flex-shrink-0">
                            <a href="{{ route('aplication.form', []) }}"
                                class="btn font-weight-bolder text-uppercase font-size-lg btn-success py-3 px-6">Apply
                                Now</a>
                        </div>
                        <!--end::Button-->
                    </div>
                </div>
            </div>
            <!--end::Callout-->
        </div>
        <div class="col-lg-6">
            <!--begin::Callout-->
            <div class="card card-custom mb-2 bg-diagonal bg-diagonal-light-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between p-4">
                        <!--begin::Content-->
                        <div class="d-flex flex-column mr-5">
                            <a href="#" class="h4 text-dark text-hover-primary mb-5">Reach Us by Social Media</a>
                            <p class="text-dark-50">Windows 10 automatically installs updates
                                <br />to make for sure
                            </p>
                        </div>
                        <!--end::Content-->
                        <!--begin::Button-->
                        <div class="ml-6 flex-shrink-0">
                            <a href="{{ route('contactus', []) }}"
                                class="btn font-weight-bolder text-uppercase font-size-lg btn-primary py-3 px-6">Contact
                                Us</a>
                        </div>
                        <!--end::Button-->
                    </div>
                </div>
            </div>
            <!--end::Callout-->
        </div>
    </div>
    <!--end::Row-->

    @endsection
