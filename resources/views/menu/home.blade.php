@extends('layouts.guest')
@section('title', 'Home')
@section('content')
    <div class="mb-2">
        <div class="d-flex bg-white flex-row-fluid bgi-size-cover bgi-position-center" style="background-image: url('')">
            <div class="container">
                <div class="d-flex align-items-stretch text-center flex-column py-2">
                    <div class="row">
                       
                        <div class="col-md-4">
                            <img src="{{ asset('img/peace_logo_max.png') }}" class="mx-auto" width="300" alt="">
                        </div>

                        <div class="col-md-4 d-flex">
                            <h4 style='font-family:serif !important;padding: 0;margin: 0; line-height: 1; color: #01afee;font-family: "Mercury", Sans-serif; font-size: 25px;font-weight: 100; align-self:center;'>
                                National Volunteer Community  Service Program<br>
                                   ብሄራዊ የበጎ ፍቃድ የማህበረሰብ አገልግሎት ፕሮግራም
                            </h4>
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
            <div class="card card-custom mb-2 bg-diagonal bg-diagonal-light-success">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between p-4">
                        <!--begin::Content-->
                        <div class="d-flex flex-column mr-5">
                            <a href="{{ route('aplication.form', []) }}"
                                class="h4 text-dark text-hover-primary mb-5">Apply
                                to be volunteer</a>
                            <p class="text-dark-50"> Take part for Community 
                                 <br />Service Engagement</p>
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
                            <p class="text-dark-50"> Put your social media link here
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
