@extends('layouts.app')
@section('title', 'All Users')
@section('breadcrumbList')
    <li class=""><a href="{{ route('user.index', []) }}">Users</a></li>
    <li class="active">Add User</li>
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

            <form method="POST" class="row"
                action="{{ isset($user) ? route('user.update') : route('user.store') }}">
                @csrf
                @isset($user)
                    @method('PATCH')
                @endisset
                <div>
                    <div class="col-md-4 @error('first_name') has-error @enderror">
                        <x-jet-label for="first_name" value="{{ __('First Name') }}" />
                        <x-jet-input id="first_name" class="form-control" type="text" name="first_name" :value="old('first_name')"
                            required autofocus autocomplete="first_name" />
                        @error('first_name')
                            <span class="help-block col-xs-12 col-sm-reset inline"> {{ $message }} </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 @error('father_name') has-error @enderror">
                    <x-jet-label for="father_name" value="{{ __('Father Name') }}" />
                    <x-jet-input id="father_name" class="form-control has-error" type="text" name="father_name"
                        :value="old('father_name')" required autofocus autocomplete="father_name" />
                    @error('father_name')
                        <div class="help-block col-xs-12 col-sm-reset inline"> {{ $message }} </div>
                    @enderror
                </div>
                <div class="col-md-4 @error('grand_father_name') has-error @enderror">
                    <x-jet-label for="grand_father_name" value="{{ __('Grand Father Name') }}" />
                    <x-jet-input id="grand_father_name" class="form-control" type="text" name="grand_father_name"
                        :value="old('grand_father_name')" required autofocus autocomplete="grand_father_name" />
                    @error('grand_father_name')
                        <div class="help-block col-xs-12 col-sm-reset inline"> {{ $message }} </div>
                    @enderror
                </div>

                <div class="col-md-4 @error('email') has-error @enderror">
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <x-jet-input id="email" class="form-control" type="email" name="email" :value="old('email')" required />
                    @error('email')
                        <div class="help-block col-xs-12 col-sm-reset inline"> {{ $message }} </div>
                    @enderror
                </div>


                <div class="col-md-4 @error('gender') has-error @enderror">
                    <x-jet-label for="gender" value="{{ __('Gender') }}" />
                    <select name="gender" id="gender" class="form-control select2">
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                    @error('gender')
                        <div class="help-block col-xs-12 col-sm-reset inline"> {{ $message }} </div>
                    @enderror
                </div>

                <div class="col-md-4 @error('dob') has-error @enderror">
                    <x-jet-label for="dob" value="{{ __('Date of Birth') }}" />
                    <x-jet-input id="dob" class="form-control is-invalid" type="text" autocomplete="off" name="dob"
                        :value="old('dob')" required />
                    @error('dob')
                        <div class="help-block col-xs-12 col-sm-reset inline"> Invalid Date of Birth </div>
                    @enderror
                </div>
                <div class="col-md-4 @error('roles') has-error @enderror">
                    <x-jet-label for="roles" value="{{ __('Roles') }}" />
                    <select name="roles" class="form-control select2" id="roles">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ Str::upper($role->name) }}</option>
                        @endforeach
                    </select>
                    @error('roles')
                        <div class="help-block col-xs-12 col-sm-reset inline"> {{ $message }} </div>
                    @enderror
                </div>

                <div class="col-md-4 @error('password') has-error @enderror">
                    <x-jet-label for="password" value="{{ __('Password') }}" />
                    <x-jet-input id="password" class="form-control" type="password" name="password" required
                        autocomplete="new-password" />
                    @error('password')
                        <div class="help-block col-xs-12 col-sm-reset inline"> {{ $message }} </div>
                    @enderror
                </div>

                <div class="col-md-4 @error('password_confirmation') has-error @enderror">
                    <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-jet-input id="password_confirmation" class="form-control" type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                    @error('password_confirmation')
                        <div class="help-block col-xs-12 col-sm-reset inline"> {{ $message }} </div>
                    @enderror
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
