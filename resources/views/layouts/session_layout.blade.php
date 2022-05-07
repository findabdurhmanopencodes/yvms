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
                        <a href="{{ route('training_session.quota', ['training_session'=>$trainingSession->id]) }}" class="navi-link py-4">
                            <span class="navi-icon mr-2">
                                <span class="svg-icon">
                                    <i class="fa fa-user"></i>
                                </span>
                            </span>
                            <span class="navi-text font-size-lg">Quota Allocation</span>
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
