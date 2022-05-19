@extends('layouts.app')
@section('title', 'Training master detail')

@section('content')
    <!--begin::Card-->
    <div class="card card-custom gutter-b col-md-6 mx-auto">
        <!--begin::Body-->
        <div class="card-body pt-4">
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end">

            </div>
            <!--end::Toolbar-->
            <!--begin::User-->
            <div class="d-flex align-items-center">
                {{-- <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                    <div class="symbol-label" style="background-image:url('assets/media/users/300_13.jpg')"></div>
                    <i class="symbol-badge bg-success"></i>
                </div> --}}
                <div>
                    <a href="#"
                        class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">{{ $trainingMaster->user->name() }}</a>
                    <div class="text-muted">{{ $trainingMaster->user->email }}</div>

                </div>
            </div>
            <!--end::User-->
            <!--begin::Contact-->
            <div class="pt-8 pb-6">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="font-weight-bold mr-2">Email:</span>
                    <a href="#" class="text-muted text-hover-primary">{{ $trainingMaster->user->email }}</a>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="font-weight-bold mr-2">Bank Account:</span>
                    <span class="text-muted">{{ $trainingMaster->bank_account }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="font-weight-bold mr-2">Gender:</span>
                    <span class="text-muted">{{ $trainingMaster->user->gender == 'M' ? 'Male' : 'Female' }}</span>
                </div>
            </div>
            <!--end::Contact-->
            <!--begin::Contact-->
            <!--end::Contact-->
            <a href="#" class="btn btn-light-success font-weight-bold py-3 px-6 mb-2 text-center btn-block">Profile
                Overview</a>
        </div>
        <!--end::Body-->
    </div>
    <!--end::Card-->
@endsection
