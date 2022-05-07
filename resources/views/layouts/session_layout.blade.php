@extends('layouts.app')
@section('content')
<!--begin::Profile Account Information-->
<div class="d-flex flex-row">
    <!--begin::Aside-->
    <div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
        <!--begin::Profile Card-->
        <div class="card card-custom card-stretch">
            <!--begin::Body-->
            <div class="card-body pt-4">
                <!--begin::User-->
                <div class="d-flex align-items-center mb-2">
                    <img src="{{ asset('img/logo_peace.png') }}" width="110" class="mx-auto" alt="">
                </div>
                <hr>
                <!--end::User-->
                <!--begin::Nav-->
                <div class="navi navi-bold navi-hover navi-active navi-link-rounded">
                    <div class="navi-item mb-2">
                        <a href="{{ route('training_session.show', ['training_session'=>$trainingSession->id]) }}" class="navi-link py-4">
                            <span class="navi-icon mr-2">
                                <span class="svg-icon">
                                    <i class="fa fa-user"></i>
                                </span>
                            </span>
                            <span class="navi-text font-size-lg">Training Session Detail</span>
                        </a>
                    </div>
                    <div class="navi-item mb-2">
                        <a href="#" class="navi-link py-4">
                            <span class="navi-icon mr-2">
                                <span class="svg-icon">
                                    <i class="fa fa-user"></i>
                                </span>
                            </span>
                            <span class="navi-text font-size-lg">Screening</span>
                        </a>
                    </div>
                    <div class="navi-item mb-2">
                        <a href="custom/apps/profile/profile-1/personal-information.html" class="navi-link py-4">
                            <span class="navi-icon mr-2">
                                <span class="svg-icon">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                            <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </span>
                            <span class="navi-text font-size-lg">Personal Information</span>
                        </a>
                    </div>
                    <div class="navi-item mb-2">
                        <a href="custom/apps/profile/profile-1/email-settings.html" class="navi-link py-4">
                            <span class="navi-icon mr-2">
                                <span class="svg-icon">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-opened.svg-->
                                    <i class="fa fa-sms"></i>
                                    <!--end::Svg Icon-->
                                </span>
                            </span>
                            <span class="navi-text font-size-lg">Email settings</span>
                        </a>
                    </div>
                </div>
                <!--end::Nav-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Profile Card-->
    </div>
    <!--end::Aside-->
    <!--begin::Content-->
    <div class="flex-row-fluid ml-lg-8">
        <!--begin::Card-->
        <div class="card card-custom">
            <!--begin::Header-->
            <div class="card-header py-3">
                <div class="card-title align-items-start flex-column">
                    <h3 class="card-label font-weight-bolder text-dark">@yield('action_title')</h3>
                    <span class="text-muted font-weight-bold font-size-sm mt-1">@yield('action_sub_title')</span>
                </div>
            </div>
            <!--end::Header-->
            @yield('action_content')
        </div>
        <!--end::Card-->
    </div>
    <!--end::Content-->
</div>
<!--end::Profile Account Information-->
@endsection
