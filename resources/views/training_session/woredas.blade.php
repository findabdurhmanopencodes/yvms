@extends('layouts.app')
@section('title','Region list')
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
        $(function(){
            quillEditorSetup('contentQuill', 'content-textarea');
        });
    </script>
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
                        <input type="hidden" name="reportable_type" value="{{ \App\Models\Zone::class }}">
                        <input type="hidden" name="reportable_id" value="{{ $zone->id }}">
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
    <div class="card card-custom mb-2">
        <div class="card-header flex-wrap  pt-6 ">
            <div class="card-title mr-0">
                <h3 class="card-label">{{ $zone->name }} Hierarchila Reports</h3>
            </div>
            <div class="card-tool">
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
                                {{ \App\Constants::convertDateToEt($report->created_at)->format('d-m-Y') }}
                            </td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <a class="" href="{{ route('session.hierarchy.show', ['training_session'=>Request::route('training_session')->id,'hierarchy'=>$report->id]) }}">
                                        <i class="fa text-primary fa-eye">
                                        </i>
                                    </a>
                                    <a class="" href="{{ route('session.hierarchy.edit', ['training_session'=>Request::route('training_session')->id,'hierarchy'=>$report->id]) }}">
                                        <i class="fa text-primary fa-pen">
                                        </i>
                                    </a>
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

<div class="card card-custom">
    <div class="card-header flex-wrap  pt-6 ">
        <div class="card-title mr-0">
            <h3 class="card-label"><a href="{{ route('session.deployment.region.zones', ['training_session'=>Request::route('training_session')->id,'region'=>$zone->region]) }}">{{ $zone->region->name }}</a> - {{ $zone->name }} - woredas</h3>
        </div>
        <div class="card-tool">
        </div>
    </div>
    <div class="card-body">
        <table width="100%" class="table ">
            <thead>
                <tr style="font-size: 13px;">
                    <th> # </th>
                    <th> Name </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($woredas as $key => $woreda)
                    <tr style="font-size: 13px;">
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $woreda->name }}</td>
                        <td>
                            <a href="{{ route('session.deployment.woreda.detail', ['training_session'=>Request::route('training_session')->id,'woreda'=>$woreda->id]) }}" class="btn btn-icon">
                                <span class="fa fa-eye"></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="m-auto col-6 mt-3">
        {{-- {{ $masters->withQueryString()->links() }} --}}
    </div>
</div>

<form id="reportFormDelete" method="POST">
    @method('DELETE')
    @csrf
</form>
@endsection
