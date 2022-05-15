@extends('layouts.guest')
@section('title', 'Home')
@section('content')
    <div class="mb-2">
        <div class="bg-white d-flex flex-row-fluid bgi-size-cover bgi-position-center" style="background-image: url('')">
            <div class="container">
                <div class="py-2 text-center d-flex align-items-stretch flex-column">
                    <div class="row">
                       
                        <div class="col-md-4">
                            <img src="{{ asset('img/peace_logo_max.png') }}" class="mx-auto" width="300" alt="">
                            <h6 style="font-family:serif !important;padding: 0;font-size:25px;margin: 0; line-height: 1; color: #01afee;align-self:center;">በጎነት ለአብሮነት</h6>
                        </div>
                        <div class="col-md-6 d-flex">
                            <div style='font-family:serif !important;padding: 0;margin: 0; line-height: 1.5; color: #01afee; font-size: 30px; align-self:center;'>
                                <p style="font-weight: 100;">National Volunteer Community Development Service Program</p>
                                <p style="font-weight: 100;">ብሔራዊ የበጎ ፈቃድ ማህበረሰብ <br> አገልገሎት</p>
                            </div>
                        </div>


                        <div class="col-md-4 d-flex">
                            <img src="{{ asset('img/peace_logo_max.png') }}" class="mx-auto" width="300" alt="">
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
            <div class="mb-2 card card-custom bg-diagonal bg-diagonal-light-success">
                <div class="card-body">
                    <div class="p-4 d-flex align-items-center justify-content-between">
                        <!--begin::Content-->
                        <div class="mr-5 d-flex flex-column">
                            <a href="{{ route('aplication.form', []) }}"
                                class="mb-5 h4 text-dark text-hover-primary">Apply
                                to be volunteer</a>
                            <p class="text-dark-50"> Take part for Community
                                 <br />Service Engagement</p>
                        </div>
                        <!--end::Content-->
                        <!--begin::Button-->
                        <div class="flex-shrink-0 ml-6">
                            <a href="{{ route('aplication.form', []) }}"
                                class="px-6 py-3 btn font-weight-bolder text-uppercase font-size-lg btn-success">Apply
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
            <div class="mb-2 card card-custom bg-diagonal bg-diagonal-light-primary">
                <div class="card-body">
                    <div class="p-4 d-flex align-items-center justify-content-between">
                        <!--begin::Content-->
                        <div class="mr-5 d-flex flex-column">
                            <a href="#" class="mb-5 h4 text-dark text-hover-primary">Reach Us by Social Media</a>
                            <p class="text-dark-50"> Put your social media link here
                            </p>
                        </div>
                        <!--end::Content-->
                        <!--begin::Button-->
                        <div class="flex-shrink-0 ml-6">
                            <a href="{{ route('contactus', []) }}"
                                class="px-6 py-3 btn font-weight-bolder text-uppercase font-size-lg btn-primary">Contact
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
