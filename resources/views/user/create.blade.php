@extends('layouts.app')
@section('title', 'All Users')
@section('breadcrumbList')
    <li class="breadcrumb-item"><a href="{{ route('user.index', []) }}">Users</a></li>
    <li class="breadcrumb-item active">Add User</li>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-multiselect.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('calendar/css/redmond.calendars.picker.css') }}">
@endpush

@push('js')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.plugin.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.plus.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.picker.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.ethiopian.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.ethiopian-am.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.picker-am.js') }}"></script>
    <script>
        $('.select2').select2({
            allowClear: true
        })
        var calendar = $.calendars.instance('ethiopian', 'am');
        $('#dob').calendarsPicker({
            calendar: calendar
        });
    </script>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">

            <form method="POST" class=""
                action="{{ isset($user) ? route('user.update') : route('user.store') }}">
                @csrf
                @isset($user)
                    @method('PATCH')
                @endisset
                <div class="row">
                    <!--begin::Input-->
                    <div class="form-group col-md-4">
                        <label class="d-block">First Name</label>
                        <input type="text" class="@error('first_name') is-invalid @enderror form-control  form-control-lg"
                            name="first_name" placeholder="First Name" value="{{ old('first_name') }}" />
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <span class="form-text text-muted">Please enter first name.</span>
                    </div>
                    <!--end::Input-->
                    <div class="form-group col-md-4">
                        <x-jet-label for="father_name" class="d-block" value="{{ __('Father Name') }}" />
                        <input id="father_name"
                            class="@error('father_name') is-invalid @enderror  form-control form-control-lg" type="text"
                            name="father_name" value="{{ old('father_name') }}" placeholder="Father Name" requiredd
                            autocomplete="father_name" />
                        @error('father_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <span class="form-text text-muted">Please enter father name.</span>
                    </div>
                    <div class="form-group col-md-4">
                        <x-jet-label for="grand_father_name" class="d-block"
                            value="{{ __('Grand Father Name') }}" />
                        <input id="grand_father_name"
                            class="@error('grand_father_name') is-invalid @enderror form-control  form-control-lg"
                            type="text" name="grand_father_name" placeholder="Grand Father Name"
                            value="{{ old('grand_father_name') }}" requiredd autocomplete="grand_father_name" />
                        @error('grand_father_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <span class="form-text text-muted">Please enter grand father name.</span>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <x-jet-label for="email" value="{{ __('Email') }}" />
                        <input id="email" class=" form-control form-control-lg @error('email') is-invalid @enderror"
                            type="email" placeholder="Email" name="email" value="{{ old('email') }}" requiredd />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <span class="form-text text-muted">Please enter email.</span>
                    </div>
                    <div class="col-md-4">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender"
                            class=" @error('gender') is-invalid @enderror form-control  form-control form-control-lg select2">
                            <option value="">Select</option>
                            <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Male</option>
                            <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <span class="form-text text-muted">Please select gender.</span>
                    </div>

                    <div class="form-group col-md-4">
                        <x-jet-label for="dob" value="{{ __('Date of Birth') }}" />
                        <input id="dob" class="@error('dob') is-invalid @enderror form-control form-control-lg" type="text"
                            autocomplete="off" name="dob" value="{{ old('dob') }}" requiredd />
                        @error('dob')
                            <div class="help-block col-xs-12 col-sm-reset inline"> Invalid Date of Birth </div>
                        @enderror
                        <span class="form-text text-muted">Please enter date of birth.</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <x-jet-label for="role" value="{{ __('role') }}" />
                        <select name="role"
                            class="form-control form-control-lg @error('role') is-invalid @enderror select2" id="role">
                            <option value="">Select</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ Str::upper($role->name) }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <x-jet-label for="password" value="{{ __('Password') }}" />
                        <input id="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                            type="password" placeholder="Password" name="password" requiredd autocomplete="new-password" />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <input id="password_confirmation"
                            class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                            type="password" placeholder="Confirm Password" name="password_confirmation" requiredd autocomplete="new-password" />
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12" style="margin-top:5px;">
                    <x-jet-button class="pull-right btn-round btn btn-sm btn-primary">
                        {{ __('Register User') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </div>
@endsection
