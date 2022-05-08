@extends('layouts.app')
@section('title', 'Volunteer Program')
@section('breadcrumb-list')
    <li class="active">{{ isset($training_session) ? 'Update Program' : 'Add Program' }}</li>
@endsection
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('calendar/css/redmond.calendars.picker.css') }}">
@endpush
@section('breadcrumbTitle', 'Program')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Program</a>
    </li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            {{-- @if (session('status'))
                <h6 class="alert alert-success">{{ session('status') }}</h6>
            @endif --}}

            <div class="card">
                {{-- <div class="card-header">
                    <h4>Edit & Update Student
                        <a href="{{ url('students') }}" class="btn btn-danger float-end">BACK</a>
                    </h4>
                </div> --}}
                <div class="card-body">

                    <form method="POST" action="{{ isset($training_session) ? route('training_session.update', ['training_session' => $training_session->id]) : route('training_session.store', []) }}">
                        @csrf
                        @isset($training_session)
                            @method('PATCH')
                        @endisset
                        <div class="form-group row">
                            <div class="col-lg-7">
                                <label>Program Name:</label>
                                <input style="height: 50px;" type="text" class="@error('name') is-invalid @enderror form-control " placeholder="program name" name="name" value="{{ old('moto') ?? (isset($training_session) ? $training_session->moto : 'Youth Volunteer Program '.$last_data_id + 1) }}" required/>
                                @error('name')
                                    <small class="text-danger"><b>{{ $message }}</b></small>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-lg-5">
                                <label>Start Date:</label>
                                <input style="height: 50px;" type="text" id="start_date"
                                class="@error('start_date') is-invalid @enderror form-control " name="start_date"
                                placeholder="start date" autocomplete="off" 
                                value="{{ old('start_date') ?? (isset($training_session) ? $training_session->start_date : '') }}" required/>
                                @error('start_date')
                                    <small class="text-danger"><b>{{ $message }}</b></small>
                                @enderror
                            </div>
                            <div class="col-lg-5">
                                <label>End Date:</label>
                                <input style="height: 50px;" type="text" id="end_date"
                                class="@error('end_date') is-invalid @enderror form-control " name="end_date"
                                placeholder="end date" autocomplete="off" 
                                value="{{ old('end_date') ?? (isset($training_session) ? $training_session->end_date : '') }}" required/>
                                @error('end_date')
                                <small class="text-danger"><b>{{ $message }}</b></small>
                            @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-5">
                                <label>Registration start date:</label>
                                <input style="height: 50px;" type="text" id="registration_start_date"
                                class="@error('registration_start_date') is-invalid @enderror form-control " name="registration_start_date"
                                placeholder="registration start date" autocomplete="off" 
                                value="{{ old('registration_start_date') ?? (isset($training_session) ? $training_session->registration_start_date : '') }}" required/>
                                @error('registration_start_date')
                                    <small class="text-danger"><b>{{ $message }}</b></small>
                                @enderror
                            </div>
                            <div class="col-lg-5">
                                <label>Registration end date:</label>
                                <input style="height: 50px;" type="text" id="registration_dead_line"
                                class="@error('registration_dead_line') is-invalid @enderror form-control " name="registration_dead_line"
                                placeholder="registration end date" autocomplete="off" 
                                value="{{ old('registration_dead_line') ?? (isset($training_session) ? $training_session->registration_dead_line : '') }}" required/>
                                @error('registration_dead_line')
                                    <small class="text-danger"><b>{{ $message }}</b></small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-5">
                                <label>number of volunteers:</label>
                                <input style="height: 50px;" type="number" class="form-control" 
                                placeholder="number of volunteers" name="quantity" 
                                value="{{ old('quantity') ?? (isset($training_session) ? $training_session->quantity : '') }}" required/>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-plus"></i>
                                {{ isset($training_session) ? 'Update Program' : 'Add Program' }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('calendar/js/jquery.plugin.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.plus.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.picker.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.ethiopian.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.ethiopian-am.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.picker-am.js') }}"></script>
<script>
    $(function() {
        var calendar = $.calendars.instance('ethiopian', 'am');
        $('#start_date').calendarsPicker({
            calendar: calendar
        });

        $('#end_date').calendarsPicker({
            calendar: calendar
        });

        $('#registration_start_date').calendarsPicker({
            calendar: calendar
        });

        $('#registration_dead_line').calendarsPicker({
            calendar: calendar
        });
    })
</script>
@endpush