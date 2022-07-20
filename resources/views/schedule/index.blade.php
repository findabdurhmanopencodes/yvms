@extends('layouts.app')
@section('title', 'All Schedules')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('calendar/css/redmond.calendars.picker.css') }}">
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
@endpush
@push('js')
    <script src="{{ asset('calendar/js/jquery.plugin.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.plus.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.picker.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.ethiopian.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.ethiopian-am.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.picker-am.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script>
        "use strict";
        var KTCalendarListView = function() {
            return {
                //main function to initiate the module
                init: function() {
                    var todayDate = moment().startOf('day');
                    var YM = todayDate.format('YYYY-MM');
                    var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
                    var TODAY = todayDate.format('YYYY-MM-DD');
                    var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

                    var calendarEl = document.getElementById('trainingCalendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],

                        isRTL: KTUtil.isRTL(),
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,listWeek'
                        },

                        height: 800,
                        contentHeight: 750,
                        aspectRatio: 3, // see: https://fullcalendar.io/docs/aspectRatio
                        views: {
                            dayGridMonth: {
                                buttonText: 'month'
                            },
                            timeGridWeek: {
                                buttonText: 'week'
                            },
                            timeGridDay: {
                                buttonText: 'day'
                            },
                            listDay: {
                                buttonText: 'list'
                            },
                            listWeek: {
                                buttonText: 'list'
                            }
                        },

                        defaultView: 'dayGridMonth',
                        defaultDate: TODAY,
                        editable: false,
                        eventLimit: true, // allow "more" link when too many events
                        navLinks: true,
                        events: @json($events),
                        eventRender: function(info) {
                            var element = $(info.el);
                            element.click(function(e){
                                e.preventDefault();
                            });
                            element.dblclick(function() {
                                Swal.fire({
                                    title: "Are you sure?",
                                    text: "You won't be able to revert this!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonText: "Yes, delete it!"
                                }).then(function(result) {
                                    if (result.value) {
                                        var elementId = element.attr('href');
                                        $('#deleteScheduleForm').attr('action','/{{$trainingSession->id}}/training_schedule/'+elementId);
                                        $('#deleteScheduleForm').submit();
                                    }
                                });
                            });
                            if (info.event.extendedProps && info.event.extendedProps.description) {
                                if (element.hasClass('fc-day-grid-event')) {
                                    element.data('content', info.event.extendedProps.description);
                                    element.data('placement', 'top');
                                    KTApp.initPopover(element);
                                } else if (element.hasClass('fc-time-grid-event')) {
                                    element.find('.fc-title').append('<div class="fc-description">' +
                                        info.event.extendedProps.description + '</div>');
                                } else if (element.find('.fc-list-item-title').lenght !== 0) {
                                    element.find('.fc-list-item-title').append(
                                        '<div class="fc-description">' + info.event.extendedProps
                                        .description + '</div>');
                                }
                            }
                        }
                    });
                    calendar.render();
                }
            };
        }();

        jQuery(document).ready(function() {
            KTCalendarListView.init();
        });
    </script>


    <script>
        var calendar = $.calendars.instance('ethiopian', 'am');
        $('#training_start_date').calendarsPicker({
            calendar: calendar
        });
        $('#schedule_start_date').calendarsPicker({
            calendar: calendar
        });
        $('#schedule_end_date').calendarsPicker({
            calendar: calendar
        });

        $('#training_end_date').calendarsPicker({
            calendar: calendar
        });
        $(function() {
            $('#formToggler').on('click', function() {
                $('#mainRow').toggleClass('d-flex');
            });
        });
        $('#allTrainings').select2({
            placeholder: "Select a Training",
        });
        $('#shift').select2({
            placeholder: "Select a Shift",
        });
    </script>
@endpush
@section('content')

    <form action="" method="POST" id="deleteScheduleForm">
        @csrf
        @method('DELETE')
    </form>

    <div class="card card-custom card-body mb-3">
        @if ($trainingSession->training_start_date != null)
            <div class="card-header">
                <div class="card-title">
                    <div class="d-flex flex-wrap">
                        <div class="mr-12 d-flex flex-column">
                            {{-- <span class="d-block font-weight-bold mb-4">Start Date</span> --}}
                            <span class="btn btn-light-primary btn-sm font-weight-bold btn-upper btn-text">
                                {{ \Andegna\DateTimeFactory::fromDateTime($trainingSession->training_start_date)->format('d/m/Y') }}
                            </span>
                        </div>
                        <div class="mr-12 d-flex flex-column">
                            {{-- <span class="d-block font-weight-bold mb-4">Due Date</span> --}}
                            <span class="btn btn-light-danger btn-sm font-weight-bold btn-upper btn-text">
                                {{ \Andegna\DateTimeFactory::fromDateTime($trainingSession->training_end_date)->format('d/m/Y') }}
                            </span>
                        </div>
                        <div>
                            <input type="submit" id="formToggler" value="Change training dates"
                                class="btn d-block ml-auto btn-primary ml-auto">
                        </div>

                    </div>
                </div>
            </div>
        @endif
        @can('TrainingSchedule.store')
        <form action="{{ route('session.schedule.set', ['training_session' => Request::route('training_session')]) }}"
            method="POST">
            @csrf
            <div class="pt-2 {{ $trainingSession->training_start_date != null ? 'd-none' : '' }} row" id="mainRow">
                <div class="form-group col-md-6">
                    <label class="d-block">Training start date</label>
                    <input type="text" id="training_start_date"
                        class="@error('training_start_date') is-invalid @enderror form-control " name="training_start_date"
                        placeholder="Training start date" autocomplete="off"
                        value="{{ old('training_start_date') ?? (isset($trainingSession->training_start_date) ? \Andegna\DateTimeFactory::fromDateTime($trainingSession->training_start_date)->format('d/m/Y') : '') }}" />
                    @error('training_start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label class="d-block">Training end date</label>
                    <input type="text" id="training_end_date"
                        class="@error('training_end_date') is-invalid @enderror form-control " name="training_end_date"
                        placeholder="Training end date" autocomplete="off"
                        value="{{ old('training_end_date') ?? (isset($trainingSession->training_end_date) ? \Andegna\DateTimeFactory::fromDateTime($trainingSession->training_end_date)->format('d/m/Y') : '') }}" />
                    @error('training_end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <input type="submit"
                        value="{{ isset($trainingSession->training_end_date) || isset($trainingSession->training_start_date) ? 'Update Training' : 'Start Training' }}"
                        class="btn d-block ml-auto btn-primary">
                </div>
            </div>
        </form>
        @endcan
    </div>
    @if ($trainingSession->training_start_date != null)
        <div class="card card-custom">
            <div class="card-body">
                <form action="{{ route('session.schedule.add', ['training_session' => $trainingSession->id]) }}"
                    method="POST" id="trainingScheduleForm">
                    @csrf
                    <div class="mb-2 row">
                        <div class="form-group col-md-3">
                            <label class="d-block">Select Training</label>
                            <select id="allTrainings" class="form-control" name="training" id="">
                                @foreach ($trainings as $training)
                                    <option {{ old('training') == $training->id ? 'selected' : '' }}
                                        value="{{ $training->id }}">
                                        {{ $training->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('training')
                                <div class="invalid-feedback" style="display:block!important;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label class="d-block">Schedule start date</label>
                            <input type="text" id="schedule_start_date"
                                class="@error('schedule_start_date') is-invalid @enderror form-control "
                                name="schedule_start_date" placeholder="Training start date" autocomplete="off"
                                value="{{ old('schedule_start_date') ?? (isset($trainingSession->schedule_start_date) ? \Andegna\DateTimeFactory::fromDateTime($trainingSession->schedule_start_date)->format('d/m/Y') : '') }}" />
                            @error('schedule_start_date')
                                <div class=" invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label class="d-block">Schedule end date</label>
                            <input type="text" id="schedule_end_date"
                                class="@error('schedule_end_date') is-invalid @enderror form-control "
                                name="schedule_end_date" placeholder="Training start date" autocomplete="off"
                                value="{{ old('schedule_end_date') ?? (isset($trainingSession->schedule_end_date) ? \Andegna\DateTimeFactory::fromDateTime($trainingSession->schedule_end_date)->format('d/m/Y') : '') }}" />
                            @error('schedule_end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="" class="d-block">Shift</label>
                            <select name="shift" class="@error('shift') is-invalid @enderror form-control" id="shift">
                                <option {{ old('shift') == 0 ? 'selected' : '' }} value="0">Morining</option>
                                <option {{ old('shift') == 1 ? 'selected' : '' }} value="1">Afternoon</option>
                                <option {{ old('shift') == 2 ? 'selected' : '' }} value="2">Both</option>
                            </select>
                            @error('shift')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <input type="submit" value="Add Schedule"
                                class="btn my-auto float-right btn-light-primary btn-sm font-weight-bold">
                        </div>
                    </div>
                </form>
                <div id="trainingCalendar"></div>
            </div>
        </div>
    @endif
@endsection
