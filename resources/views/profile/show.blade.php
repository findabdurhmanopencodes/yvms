@extends('layouts.app')
@section('title', 'Profile')
@section('breadcrumbList')
    <li class="active">User Profile</li>
@endsection
@section('content')
    <div class="card card-custom gutter-b col-md-8 mx-auto">
        <!--begin::Body-->
        <div class="card-body pt-4">
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end">
                <div class="dropdown dropdown-inline">
                    <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon">
                        <i class="fad fa-edit"></i>
                        Edit
                    </a>
                </div>
            </div>
            <!--end::Toolbar-->
            <!--begin::User-->
            <div class="d-flex align-items-center">
                <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                    <div class="symbol-label" style="background-image:url({{Auth::user()->getProfilePhoto()}})"></div>
                    <i class="symbol-badge bg-success"></i>
                </div>
                <div>
                    <a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">{{ Auth::user()->name() }}</a>
                    <div class="text-muted">{{ Auth::user()->roles()->first()?->name}}</div>
                    <div class="mt-2">
                    </div>
                </div>
            </div>
            <!--end::User-->
            <!--begin::Contact-->
            <div class="pt-8 pb-6">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="font-weight-bold mr-2">Email:</span>
                    <a href="#" class="text-muted text-hover-primary">{{ Auth::user()->email }}</a>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="font-weight-bold mr-2">Date of Birth:</span>
                    <span class="text-muted">{{ Auth::user()->dobEt() }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="font-weight-bold mr-2">Gender:</span>
                    <span class="text-muted">{{ Auth::user()->gender=='M'?'Male':'Female' }}</span>
                </div>
            </div>
            <!--end::Contact-->
            <!--begin::Contact-->
            <!--end::Contact-->
            <a href="{{ route('profile.edit') }}" class="btn btn-light-success font-weight-bold py-3 px-6 mb-2 text-center btn-block">Edit Profile</a>
        </div>
        <!--end::Body-->
    </div>
    <!--end::Card-->
@endsection
