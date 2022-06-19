@extends('layouts.app')
@section('title', 'Center base detail')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('calendar/css/redmond.calendars.picker.css') }}">
    <style>
        .select2,
        .select2-container,
        .select2-container--default,
        .select2-container--below {
            width: 100% !important;
        }
    </style>
@endpush
@section('content')
<form method="POST" action="{{ route('session.deployment_graduate.volunteers', ['training_session'=>$trainingSession->id, 'woreda'=>$woreda->id]) }}">
    @csrf
    {{-- <input type="hidden" name="max_attendance" value="{{ count($arr_unique) }}"> --}}
    {{-- <input type="hidden" name="training_center" value="{{ $trainingCenter->id }}"> --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modalx-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Graduate Volunteers</h5>
                    <button type="button" class="close" data-dismiss="modal" -label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-lg-9">
                                    <label>Attendace amount</label>
                                    <input type="number" id="att_amount" class="form-control" name="att_amount" max=""/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label>Pass All</label>
                                    <input type="checkbox" id="gc_vol" name="gc_vol" class="checkbox"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
    <!-- Modal-->
    <div class="modal fade" id="writeReportModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Report Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="reportForm"
                        action="{{ route('session.hierarchy.store', ['training_session' => Request::route('training_session')->id]) }}"
                        method="POST">
                        @csrf
                        <div class="">
                            <label for="">Report Text</label>
                            <div id="contentQuill" style="height: 325px">
                                {!! old('content') !!}
                            </div>
                            <textarea name="content" id="content-textarea" class="d-none">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="fv-plugins-message-container">
                                    <div data-field="content" data-validator="stringLength" class="fv-help-block">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                        </div>
                        <input type="hidden" name="reporter_type" value="{{ \App\Models\Woreda::class }}">
                        <input type="hidden" name="reporter_id" value="{{ $woreda->id }}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="button" onclick="$('#reportForm').submit()" class="btn btn-primary font-weight-bold">Write
                        Report</button>
                </div>
            </div>
        </div>
    </div>
    <!--view report modal-->
    <div class="modal fade" id="viewReportModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Report View Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="reportViewDiv"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editReportModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Report Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="reportEditForm" action="" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="">
                            <label for="">Report Text</label>
                            <div id="contentQuill1" style="height: 325px">
                            </div>
                            <textarea name="content" id="content-textarea1" class="d-none">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="fv-plugins-message-container">
                                    <div data-field="content" data-validator="stringLength" class="fv-help-block">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                        </div>
                        <input type="hidden" name="reporter_type" value="{{ \App\Models\Woreda::class }}">
                        <input type="hidden" name="reporter_id" value="{{ $woreda->id }}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="button" onclick="$('#reportForm').submit()"
                        class="btn btn-primary font-weight-bold">Update
                        Report</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-custom mb-2">
        <div class="card-header flex-wrap  pt-6 ">
            <div class="card-title mr-0">
                <h3 class="card-label">{{ $woreda->name }} Hierarchila Reports</h3>
            </div>
            <div class="card-tool">

                {{-- <a href="#" data-toggle="modal" data-target="#writeReportModal" class="btn btn-primary">

        </a> --}}
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#writeReportModal">
                    <i class="fal fa-plus "></i>
                    Write hierarchial report
                </button>
            </div>
        </div>
        <div class="card-body">
            <table width="100%" class="table">
                <thead>
                    </tr>
                    <th>#</th>
                    <th>Report Date</th>
                    <th width="100">Action</th>
                    {{-- <th><i class="menu-icon flaticon-list"></i> </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse  ($reports as $key=>$report)
                        <tr>
                            <td>
                                {{ $key + 1 }}
                            </td>
                            <td>
                                {{ $report->created_at->diffForHumans() }}
                            </td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    {{-- <a class="" href="#"
                                onclick="$('#reportViewDiv').html('{!! $report->content !!}');" data-toggle="modal"
                                data-target="#viewReportModal">
                                <i class="fa text-primary fa-eye">
                                </i>
                            </a> --}}
                                    {{-- <a class="" href="#" onclick="$('#reportEditForm').attr('action','{{ route('session.hierarchy.update',['training_session'=>Request::route('training_session')->id,'hierarchy'=>$report->id]) }}');$('#contentQuill1 .ql-editor').html('{!! $report->content !!}')" data-toggle="modal" data-target="#editReportModal">
                                <i class="fa text-primary fa-pen">
                                </i>
                            </a> --}}
                                    <a class="" href="#"
                                        onclick="confirmDeleteReport('{{ route('session.hierarchy.destroy', ['training_session' => Request::route('training_session')->id, 'hierarchy' => $report->id]) }}')">
                                        <i class="fa text-danger fa-trash">
                                        </i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr style="font-size: 13px;" class="text-center">
                            <td colspan='2'>No reports found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <form method="POST"
        action="{{ route('session.import.deployment_attendance', ['training_session' => Request::route('training_session')->id, 'woreda' => Request::route('woreda')->id]) }}"
        enctype="multipart/form-data">
        @csrf
        <div style="z-index: 9999999;" class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import File</h5>
                        <button type="button" class="close" data-dismiss="modal" -label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Attendance File: </label>
                                        <input type="file" name="attendance" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="card card-custom card-body mb-1">
        <form action="" method="GET">
            <div class=" ml-0 col-12 p-0">
                <div class="row">
                    <div class="form-group col-5">
                        <input style="height: 40px;" type="text" id="start_date" class="form-control " name="date_att" placeholder="Search..." autocomplete="off" value=""/>
                    </div>
                    <div class="form-group col-2">
                        <button class="btn btn-primary btn-block"> Filter</button>
                    </div>
                </div>

                <h3>{{ ($date!='') ?$date.' Attendance ('.count($volunteers).')':'Today Attendance ('.count($volunteers).')' }}</h3>
            </div>
        </form>
    </div>
    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap pt-6 ">
            <div class="card-title mr-0">
                <h3>{{ $woreda->name }}</h3>
                <a href="">
                    <i class="ml-2 flaticon2-location text-success icon-md"></i>
                    {{ $woreda->zone->name }} - {{ $woreda->zone->region->name }}
                </a>
            </div>
            <div class="card-tool">
                <div class="dropdown dropdown-inline">
                    <a href="#" class="px-5 btn btn-sm btn-primary font-weight-bolder dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="">
                        <!--begin::Navigation-->
                        <ul class="navi navi-hover">
                            <li class="navi-item">
                                <a href="{{ route('session.deployment_attendance.export', ['training_session' => Request::route('training_session')->id, 'woreda' => Request::route('woreda')->id]) }}"
                                    class="navi-link">
                                    <span class="navi-icon">
                                        <i class="flaticon2-shopping-cart-1"></i>
                                    </span>
                                    <span class="navi-text">Export Attendance</span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="" class="navi-link" data-toggle="modal"
                                    data-target="#exampleModal">
                                    <span class="navi-icon">
                                        <i class="fa fa-users"></i>
                                    </span>
                                    <span class="navi-text">Import Attendance</span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link" data-toggle="modal" data-target="#exampleModal">
                                    <span class="svg-icon svg-icon-md">
                                        <i class="flaticon-medal" id="i_text"></i>
                                    </span>
                                    Graduate Volunteers
                                </a>
                            </li>
                        </ul>
                        <!--end::Navigation-->
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table width="100%" class="table">
                <thead>
                    </tr>
                    <th>#</th>
                    <th>Volunteer ID</th>
                    <th>Full Name</th>
                    <th>Attendance Count</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse  ($volunteers as $key=>$volunteer)
                        <tr>
                            <td>
                                {{ $key + 1 }}
                            </td>
                            <td>
                                {{ $volunteer->id_number }}
                            </td>
                            <td>
                                {{ $volunteer->first_name }} {{ $volunteer->father_name }}
                            </td>
                            <td>
                                {{ $att_count[$volunteer->id_number] }}
                            </td>
                        </tr>
                    @empty
                        <tr style="font-size: 13px;" class="text-center">
                            <td colspan='2'>No attendance found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <form id="reportFormDelete" method="POST">
        @method('DELETE')
        @csrf
    </form>
    <!--end::Card-->
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

        
        $('.select2').select2({
            allowClear: true
        });

        @if (old('training') != null)
            $('#assignMasterModal').modal().show()
        @endif

        function confirmPlacment() {
            Swal.fire({
                title: "Are you sure?",
                text: "You are able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, place volunteers!"
            }).then(function(result) {
                if (result.value) {
                    $('#placeVolunteerForm').submit();
                }
            });
        }

        function confirmDeleteMasterPlacement(masterId) {
            var sessionId = '{{ Request::route('training_session')->id }}';
            $('#deleteForm').attr('action', '/' + sessionId + '/training_master_placement/' + masterId);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $('#deleteForm').submit();
                }
            });
        }

        function confirmDeleteCoordinator(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $("#centerCoordinator").html(`<option value="${id}"></option>`);
                    $('#centerCoordinatorForm').submit();
                }
            });
        }

        function confirmDeleteChecker(checkerId) {
            $('#checkerUserRemove').val(checkerId);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $('#removeCheckerForm').submit();
                }
            });
        }

        function confirmDeleteRoom(route) {
            $('#deleteRoomForm').attr('action', route);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $('#deleteRoomForm').submit();
                }
            });
        }
    </script>
@endpush
@push('js')
    <script>
        function confirmDeleteReport(url) {
            event.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "danger",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $('#reportFormDelete').attr('action', url);
                    $('#reportFormDelete').submit();
                }
            });
        }

        function quillEditorSetup(quillId, areaId) {
            var quill = new Quill('#' + quillId, {
                modules: {
                    toolbar: [
                        [{
                            header: [1, 2, false]
                        }],
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote'],
                        [{
                            'header': 1
                        }, {
                            'header': 2
                        }], // custom button values
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        [{
                            'script': 'sub'
                        }, {
                            'script': 'super'
                        }], // superscript/subscript
                        [{
                            'indent': '-1'
                        }, {
                            'indent': '+1'
                        }], // outdent/indent
                        [{
                            'direction': 'rtl'
                        }], // text direction
                        ['link'],
                        ['clean'],
                        [{
                            'color': []
                        }, {
                            'background': []
                        }], // dropdown with defaults from theme
                        [{
                            'font': []
                        }],
                        [{
                            'align': []
                        }], // remove formatting button
                    ]
                },
                placeholder: 'Type your text here...',
                theme: 'snow' // or 'bubble'
            });
            var editorId = '#' + quillId;
            var textAreaId = '#' + areaId;
            quill.on('text-change', function(delta, oldDelta, source) {
                if ($(editorId + " .ql-editor").html() != '<p><br></p>') {
                    var content = $(editorId + " .ql-editor").html();
                    $(textAreaId).text(content);
                }
                if ($(editorId + " .ql-editor").html() == '<p><br></p>')
                    $(textAreaId).text('');
            });
        }
        // Class definition
        var KTQuilDemos = function() {

            // Private functions
            var demo1 = function() {
                var quill = new Quill('#contentQuill', {
                    modules: {
                        toolbar: [
                            [{
                                header: [1, 2, false]
                            }],
                            ['bold', 'italic', 'underline', 'strike'],
                            ['blockquote'],
                            [{
                                'header': 1
                            }, {
                                'header': 2
                            }], // custom button values
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }],
                            [{
                                'script': 'sub'
                            }, {
                                'script': 'super'
                            }], // superscript/subscript
                            [{
                                'indent': '-1'
                            }, {
                                'indent': '+1'
                            }], // outdent/indent
                            [{
                                'direction': 'rtl'
                            }], // text direction
                            ['link'],
                            ['clean'],
                            [{
                                'color': []
                            }, {
                                'background': []
                            }], // dropdown with defaults from theme
                            [{
                                'font': []
                            }],
                            [{
                                'align': []
                            }], // remove formatting button
                        ]
                    },
                    placeholder: 'Type your text here...',
                    theme: 'snow' // or 'bubble'
                });
                var editorId = '#contentQuill';
                var textAreaId = '#content-textarea'
                quill.on('text-change', function(delta, oldDelta, source) {
                    if ($(editorId + " .ql-editor").html() != '<p><br></p>') {
                        var content = $(editorId + " .ql-editor").html();
                        $(textAreaId).text(content);
                    }
                    if ($(editorId + " .ql-editor").html() == '<p><br></p>')
                        $(textAreaId).text('');
                });
            }
            return {
                // public functions
                init: function() {
                    demo1();
                }
            };
        }();

        jQuery(document).ready(function() {
            var reports = @json($reports->toJson());
            console.log(reports[0]);
            KTQuilDemos.init();
            quillEditorSetup('contentQuill1', 'content-textarea');
        });
    </script>
    <script>
        $('#att_amount').on('input', function(){
            if ($('#att_amount').val()) {
                $('#gc_vol').attr('disabled',true);
            }else{
                $('#gc_vol').attr('disabled',false);
            }
        });

        $('#att_amount').on('input', function(){
            if ($('#att_amount').val()) {
                $('#gc_vol').attr('disabled',true);
            }else{
                $('#gc_vol').attr('disabled',false);
            }
        });

        $('#gc_vol').change(function() {
            if(this.checked) {
                $('#att_amount').attr('disabled',true);
            }else{
                $('#att_amount').attr('disabled',false);
            }
        });
    </script>
@endpush
