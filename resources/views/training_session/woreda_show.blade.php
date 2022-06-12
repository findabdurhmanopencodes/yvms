@extends('layouts.app')
@section('title', 'Center base detail')
@push('css')
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
    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        {{-- <div cl --}}
        <div class="card-body">
            <div class="d-flex">
                <!--begin: Pic-->
                <div class="flex-shrink-0 mt-3 mr-7 mt-lg-0">
                    <div class="symbol symbol-50 symbol-lg-120">
                        <h3>{{ $woreda->name }}</h3>
                        <a href="">
                            <i class="ml-2 flaticon2-location text-success icon-md"></i>
                            {{ $woreda->zone->name }} - {{ $woreda->zone->region->name }}
                        </a>
                    </div>
                </div>
                <!--end: Pic-->
                <!--begin: Info-->
                <div class="flex-grow-1">
                    <!--begin: Title-->
                    <div class="flex-wrap d-flex align-items-center justify-content-end">
                        <div class="my-1 my-lg-0">
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
                                    </ul>
                                    <!--end::Navigation-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end: Title-->
                </div>
                <!--end: Info-->
            </div>
            <div class="separator separator-solid my-7"></div>
            <!--begin: Items-->
            <div class="flex-wrap d-flex align-items-center">
                <!--begin: Item-->
                <div class="my-1 mr-5 d-flex align-items-center flex-lg-fill">
                    <span class="mr-4">
                        <i class="flaticon-piggy-bank icon-2x text-muted font-weight-bold"></i>
                    </span>
                    <div class="d-flex flex-column text-dark-75">
                        <span class="font-weight-bolder font-size-sm">Total Volunteers</span>
                        <span class="font-weight-bolder font-size-h5">
                            <span class="text-dark-50 font-weight-bold"></span>{{ '2' }}</span>
                    </div>
                </div>
                <!--end: Item-->
            </div>
        </div>
    </div>
    <form id="reportFormDelete" method="POST">
        @method('DELETE')
        @csrf
    </form>
    <!--end::Card-->
@endsection
@push('js')
    <script>
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
@endpush
