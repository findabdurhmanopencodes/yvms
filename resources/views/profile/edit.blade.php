@extends('layouts.app')
@section('title', 'Profile')
@section('breadcrumbList')
    <li class="active">User Profile</li>
@endsection
@push('css')
    <style>
        .select2,
        .select2-container,
        .select2-container--default,
        .select2-container--below {
            width: 100% !important;
        }

    </style>
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-multiselect.min.css') }}" /> --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}" /> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('calendar/css/redmond.calendars.picker.css') }}">
@endpush

@push('js')
    {{-- <script src=" {{ asset('assets/js/select2.min.js') }}"></script> --}}
    <script src=" {{ asset('calendar/js/jquery.plugin.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.plus.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.picker.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.ethiopian.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.ethiopian-am.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.picker-am.js') }}"></script>
@endpush
@section('content')
    <div class="card card-custom">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" id="profile_update"
                        action="{{ route('profile.update', [])  }}">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6 form-group">
                                <x-jet-label for="password" value="{{ __('Password') }}" />
                                <input id="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    type="password" placeholder="Password" name="password" requiredd
                                    autocomplete="new-password" />
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-xl-6 form-group">
                                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                <input id="password_confirmation"
                                    class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                                    type="password" placeholder="Confirm Password" name="password_confirmation" requiredd
                                    autocomplete="new-password" />
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top:5px;">
                            <button class="float-right btn  btn-primary">
                                {{ __('Update Profile' ) }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
