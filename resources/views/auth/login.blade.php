@extends('layouts.auth')
@section('title','Login')
@section('content')
<div class="flex-row-fluid d-flex flex-column position-relative p-7 overflow-hidden cols-4">
    <!--begin::Content header-->
    <div class="position-absolute top-0 right-0 text-right mt-5 mb-15 mb-lg-0 flex-column-auto justify-content-center py-5 px-10">
        <span class="font-weight-bold text-dark-50">Do you want to go application page?</span>
        <a href="javascript:;" class="font-weight-bold ml-2" id="kt_login_signup">Click here!</a>
    </div>
    <!--end::Content header-->
    <!--begin::Content body-->
    <div class="d-flex flex-column-fluid flex-center mt-30 mt-lg-0">
        <!--begin::Signin-->

        <div class="login-form login-signin">
            <div class="text-center mb-10 mb-lg-20">
            	<a href="#" class="flex-column-auto mt-5">
                
                    <img  style="height:150px;" src="{{ asset('assets/media/logos/mop_logo.jpg') }}" /> 
                             

                </a>
            </div>
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <!--begin::Form-->


                <form class="form" novalidate="novalidate" method="post" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Email" name="email" autocomplete="off" />
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" placeholder="Password" name="password" autocomplete="off" />
                    </div>
                    <!--begin::Action-->
                    <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
                        <a href="javascript:;" class="text-dark-50 text-hover-primary my-3 mr-2" id="kt_login_forgot">Forgot Password ?</a>
                        <button  class="btn btn-primary font-weight-bold px-9 py-4 my-3" type="submit">Sign In</button>
                    </div>
                    <!--end::Action-->
                </form>


            <!--end::Form-->
        </div>

        <!--end::Signin-->
        <!--begin::Signup-->


        <div class="login-form login-signup">
            <div class="text-center mb-10 mb-lg-20">
                <h3 class="font-size-h1">Sign Up</h3>
                <p class="text-muted font-weight-bold">Enter your details to create your account</p>
            </div>
            <!--begin::Form-->
            <form class="form" novalidate="novalidate" action="{{ route('register')}}" method="POST">
                @csrf
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="First Name" name="first_name" autocomplete="off" />
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Middle Name" name="father_name" autocomplete="off" />
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Last Name" name="grand_father_name" autocomplete="off" />
                </div>
                <div class="form-group">
                    <input class="form-control" type="email" placeholder="Email" name="email" autocomplete="off" />
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" placeholder="Password" name="password" autocomplete="off" />
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" placeholder="Confirm password" name="password_confirmation" autocomplete="off" />
                </div>
                <div class="form-group">
                    <label class="checkbox">
                    <input type="checkbox" name="agree" />I Agree the
                    <a href="#">terms and conditions</a>.
                    <span></span></label>
                </div>
                <div class="form-group d-flex flex-wrap flex-center">
                    <button type="submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Submit</button>
                    <button  class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-4">Cancel</button>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Signup-->
        <!--begin::Forgot-->
        <div class="login-form login-forgot">
            <div class="text-center mb-10 mb-lg-20">
                <h3 class="font-size-h1">Forgotten Password ?</h3>
                <p class="text-muted font-weight-bold">Enter your email to reset your password</p>
            </div>
            <!--begin::Form-->
            <form class="form" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <input class="form-control form-control-solid h-auto py-5 px-6" type="email" placeholder="Email" name="email" autocomplete="off" />
                </div>
                <div class="form-group d-flex flex-wrap flex-center">
                    <button type="submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Submit</button>
                    <button id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-4">Cancel</button>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Forgot-->
    </div>
    <!--end::Content body-->
    <!--begin::Content footer for mobile-->
    <div class="d-flex d-lg-none flex-column-auto flex-column flex-sm-row justify-content-between align-items-center mt-5 p-5">
        <div class="text-dark-50 font-weight-bold order-2 order-sm-1 my-2">© 2020 Metronic</div>
        <div class="d-flex order-1 order-sm-2 my-2">
            <a href="#" class="text-dark-75 text-hover-primary">Privacy</a>
            <a href="#" class="text-dark-75 text-hover-primary ml-4">Legal</a>
            <a href="#" class="text-dark-75 text-hover-primary ml-4">Contact</a>
        </div>
    </div>
    <!--end::Content footer for mobile-->
</div>
@endsection
