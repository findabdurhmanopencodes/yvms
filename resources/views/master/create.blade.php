@extends('layouts.app')
@section('title', 'Create Training Master')
@push('css')
    <style>
        .select2,
        .select2-container,
        .select2-container--default,
        .select2-container--below {
            width: 100% !important;
        }

    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('calendar/css/redmond.calendars.picker.css') }}">
@endpush
@push('js')
    <script src=" {{ asset('calendar/js/jquery.plugin.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.plus.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.picker.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.ethiopian.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.ethiopian-am.js') }}"></script>
    <script src=" {{ asset('calendar/js/jquery.calendars.picker-am.js') }}"></script>
    <script>
        $(function() {
            var calendar = $.calendars.instance('ethiopian', 'am');
            $('#dob').calendarsPicker({
                calendar: calendar
            });

            $('.select2').select2({
                allowClear: true
            })
        });
    </script>
@endpush
@section('content')
    <form method="POST"
        action="{{ $master ? route('training_master.update', ['training_master' => $master->id]) : route('training_master.store') }}">
        @csrf
        @if ($master)
            @method('PATCH')
        @endif
        <div class="card card-custom">
            <div class="card-header flex-wrap  pt-6 ">
                <div class="card-title mr-0">
                    <h3 class="card-label">Master Trainers</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!--begin::Input-->
                    <div class="form-group col-md-4">
                        <label class="d-block">First Name</label>
                        <input type="text" class="@error('first_name') is-invalid @enderror form-control" name="first_name"
                            placeholder="First Name"
                            value="{{ old('first_name') ?? (isset($master) ? $master->user->first_name : '') }}" />
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <span class="form-text text-muted">Please enter first name.</span>
                    </div>
                    <div class="form-group col-md-4">
                        <x-jet-label for="father_name" class="d-block" value="{{ __('Father Name') }}" />
                        <input id="father_name" class="@error('father_name') is-invalid @enderror  form-control "
                            type="text" name="father_name"
                            value="{{ old('father_name') ?? (isset($master) ? $master->user->father_name : '') }}"
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
                            class="@error('grand_father_name') is-invalid @enderror form-control  " type="text"
                            name="grand_father_name" placeholder="Grand Father Name"
                            value="{{ old('grand_father_name') ?? (isset($master) ? $master->user->grand_father_name : '') }}"
                            requiredd autocomplete="grand_father_name" />
                        @error('grand_father_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <span class="form-text text-muted">Please enter grand father name.</span>
                    </div>
                    <div class="form-group col-md-4">
                        <x-jet-label for="email" value="{{ __('Email') }}" />
                        <input id="email" class=" form-control @error('email') is-invalid @enderror" type="email"
                            placeholder="Email" name="email"
                            value="{{ old('email') ?? (isset($master) ? $master->user->email : '') }}" requiredd />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <span class="form-text text-muted">Please enter email.</span>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender"
                            class=" @error('gender') is-invalid @enderror select2 form-control  form-control select2">
                            <option value="">Select</option>
                            <option
                                {{ old('gender') != null ? (old('gender') == 'M' ? 'selected' : '') : (isset($master) ? ($master->user->gender == 'M' ? 'selected' : '') : '') }}
                                value="M">Male</option>
                            <option
                                {{ old('gender') != null ? (old('gender') == 'F' ? 'selected' : '') : (isset($master) ? ($master->user->gender == 'F' ? 'selected' : '') : '') }}
                                value="F">Female</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <span class="form-text text-muted">Please select gender.</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="d-block">Date Of Birth</label>
                        <input type="text" id="dob" class="@error('dob') is-invalid @enderror form-control" name="dob"
                            placeholder="Date of Birth" autocomplete="off"
                            value="{{ old('dob') ?? (isset($master) ? $master->user->dobET() : '') }}" />
                        @error('dob')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <span class="form-text text-muted">Please enter your date of
                            birth.</span>
                    </div>
                    <div class="form-group col-md-4">
                        <x-jet-label for="bank_account" value="{{ __('Bank Account') }}" />
                        <input id="bank_account" class=" form-control @error('bank_account') is-invalid @enderror"
                            type="text" placeholder="Bank Account" name="bank_account"
                            value="{{ old('bank_account') ?? (isset($master) ? $master->bank_account : '') }}"
                            requiredd />
                        @error('bank_account')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <span class="form-text text-muted">Please enter bank_account.</span>
                    </div>
                    <div class="col-md-12">
                        <input type="submit" class="btn btn-primary float-right"
                            value="{{ ($master) ? 'Update' : 'Add' }} Master Trainer">

                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
