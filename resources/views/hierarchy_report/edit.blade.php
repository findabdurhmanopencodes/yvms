@extends('layouts.app')

@section('title', 'Edit Report')
@push('js')
    <script>
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
    <div class="card card-custom">
        <div class="card-header flex-wrap  pt-6 ">
            <div class="card-title align-items-start flex-column mr-0">
                <span class="card-label font-weight-bolder text-dark">Hierarchila Report Detail</span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm">Reported From :
                    {{ $hierarchy->reportable->name }}
                    <span class="label label-lg label-light-success label-inline">Reported date
                        :{{ \App\Constants::convertDateToEt($hierarchy->created_at)->format('d-m-Y') }} </span>
                </span>
            </div>

            <div class="card-tool">
                <button type="button" class="btn btn-danger" onclick="confirmDeleteReport()">
                    <i class="fal fa-trash"></i>
                    Delete
                </button>
            </div>
        </div>
        <div class="card-body">
            <form id="reportForm"
                action="{{ route('session.hierarchy.update', ['training_session' => Request::route('training_session')->id,'hierarchy'=>$hierarchy->id]) }}"
                method="POST">
                @method('PATCH')
                @csrf
                <div class="">
                    <label for="">Report Text</label>
                    <div id="contentQuill" style="height: 325px">
                        {!! old('content')??$hierarchy->content !!}
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
                <input type="hidden" name="reportable_type" value="{{ $reportableType }}">
                <input type="hidden" name="reportable_id" value="{{ $hierarchy->reportable->id }}">
                <input type="submit" value="Update Report" class="btn btn-primary">
            </form>
        </div>
    </div>
@endsection
