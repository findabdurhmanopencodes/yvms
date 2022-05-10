@extends('layouts.app')
@section('title', 'All Users')
@section('breadcrumbTitle', 'Register User')
@section('breadcrumbList')
    <li class="breadcrumb-item"><a href="{{ route('user.index', []) }}">Users</a></li>
    <li class="breadcrumb-item active">Add User</li>
@endsection
@push('css')
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
    <div class="card card-custom">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" class=""
                        action="{{ isset($user) ? route('user.update', ['user' => $user->id]) : route('user.store') }}">
                        @csrf
                        @isset($user)
                            @method('PATCH')
                        @endisset
                        <div class="row">
                            <!--begin::Input-->
                            <div class="form-group col-md-4">
                                <label class="d-block">First Name</label>
                                <input type="text"
                                    class="@error('first_name') is-invalid @enderror form-control  form-control-lg"
                                    name="first_name" placeholder="First Name"
                                    value="{{ old('first_name') ?? (isset($user) ? $user->first_name : '') }}" />
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <span class="form-text text-muted">Please enter first name.</span>
                            </div>
                            <!--end::Input-->
                            <div class="form-group col-md-4">
                                <x-jet-label for="father_name" class="d-block" value="{{ __('Father Name') }}" />
                                <input id="father_name"
                                    class="@error('father_name') is-invalid @enderror  form-control form-control-lg"
                                    type="text" name="father_name"
                                    value="{{ old('father_name') ?? (isset($user) ? $user->father_name : '') }}"
                                    placeholder="Father Name" requiredd autocomplete="father_name" />
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
                                    value="{{ old('grand_father_name') ?? (isset($user) ? $user->grand_father_name : '') }}"
                                    requiredd autocomplete="grand_father_name" />
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
                                    type="email" placeholder="Email" name="email"
                                    value="{{ old('email') ?? (isset($user) ? $user->email : '') }}" requiredd />
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
                                    <option
                                        {{ old('gender') != null ? (old('gender') == 'M' ? 'selected' : '') : (isset($user) ? ($user->gender == 'M' ? 'selected' : '') : '') }}
                                        value="M">Male</option>
                                    <option
                                        {{ old('gender') != null ? (old('gender') == 'F' ? 'selected' : '') : (isset($user) ? ($user->gender == 'F' ? 'selected' : '') : '') }}
                                        value="F">Female</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <span class="form-text text-muted">Please select gender.</span>
                            </div>

                            <div class="form-group col-md-4">
                                <x-jet-label for="dob" value="{{ __('Date of Birth') }}" />
                                <input id="dob" class="@error('dob') is-invalid @enderror form-control form-control-lg"
                                    type="text" placeholder="Date Of Birth" autocomplete="off" name="dob"
                                    value="{{ old('dob') ?? (isset($user) ? $user->dobET() : '') }}" requiredd />
                                @error('dob')
                                    <div class="help-block col-xs-12 col-sm-reset inline"> Invalid Date of Birth </div>
                                @enderror
                                <span class="form-text text-muted">Please enter date of birth.</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <x-jet-label for="role" value="{{ __('Role') }}" />
                                <select name="role"
                                    class="form-control form-control-lg @error('role') is-invalid @enderror select2"
                                    id="role">
                                    <option value="">Select</option>
                                    @foreach ($roles as $role)
                                        @if ($role->name != 'volunteer')
                                            <option value="{{ $role->id }}"
                                                {{ old('role') != null ? (old('role') == $role->id ? 'selected' : '') : (($user?->getRole()?->id == $role->id) ? 'selected' : '') }} >
                                                {{ Str::upper($role->name) }}</option>
                                            {{-- <option value="{{ $role->id }}"
                                                {{ old('role') != null ? (old('role') == $role->id ? 'selected' : '') : (isset($user) ? ($user->getRole()?->id == $role->id ? 'selected' : '') : '') }}>
                                                {{ Str::upper($role->name) }}</option> --}}
                                        @endif
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 form-group">
                                <x-jet-label for="password" value="{{ __('Password') }}" />
                                <input id="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    type="password" placeholder="Password" name="password" requiredd
                                    autocomplete="new-password" />
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 form-group">
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
                                {{ __(isset($user) ? 'Update User' : 'Register User') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
