@extends('layouts.auth')
@section('title', 'Verification Email')
@section('content')
    <div class="d-flex justify-items-center">

            <img alt="Logo" src="{{ asset('assets/media/logos/mop_logo.png') }}" class="h-40px mb-5">

        <div class="pt-lg-10 mb-10">
            <h1 class="fw-bolder fs-2qx text-gray-800 mb-7">Verify Your Email</h1>


            <div class="fs-3 fw-bold text-muted mb-10">We have sent an email to
                <a>
                    Thanks for signing up! Before getting started, could you verify your email address by clicking on the
                    link we just emailed to you? If you didn\'t receive the email, we will gladly send you another
                   </a>
                <br>pelase follow a link to verify your email.
            </div>


            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <div class="fs-5">
                    <span class="fw-bold text-gray-700">Did’t receive an email?</span>
                    <button type="submit" class="link-primary fw-bolder">Resend</button>
                </div>
            </form>

            <!--end::Action-->
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <div class="text-center mb-10">
                <button class="btn btn-lg btn-primary fw-bolder float-right" type="submit">Sigin Out</button>
            </div>
        </form>
        <!--end::Wrapper-->
        <!--begin::Illustration-->
        <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px"
            style="background-image: url(/metronic8/demo4/assets/media/illustrations/dozzy-1/17.png"></div>
        <!--end::Illustration-->
    </div>
@endsection
