@extends('layouts.app')
@push('title', 'Edit Events')
@push('jsPage')
    <script>
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
                            ['bold', 'italic', 'underline'],
                            ['image', 'code-block']
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
            KTQuilDemos.init();
        });
    </script>
@endpush
@section('content')
    @csrf
    <div class="card card-custom">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-header">
            <h3 class="card-title">
                New Event
            </h3>
        </div>
        <div class="card-body">

            <form method="POST" action="{{ route('Events.update',['Event'=>$event->id]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <label class="text-right col-form-label ">Title</label>
                <div class="row">
                    <div class="col-md-12 form-group d-flex">
                        <div class="col-md-11">
                            <input class="form-control @error('title') is-invalid @enderror" type="text" placeholder="Title"
                                id="title" name="title" value="{{ old('title') ?? $event->title }}" />
                            @error('title')
                                <div class="fv-plugins-message-container">
                                    <div data-field="title" data-validator="stringLength" class="fv-help-block">
                                        {{ $message }}</div>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group d-flex">
                        <div class="col-md-11">
                            <div class="form-group">
                                <label class="d-block">Select Pictures</label>
                                <div class="custom-file">
                                    <input type="file"
                                        class="@error('pictures') is-invalid @enderror  custom-file-input"
                                        name="pictures[]" id="pictures" multiple />
                                    <label class="custom-file-label" for="customFile">Choose
                                        file</label>
                                    @error('pictures')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <label for="">Desription</label>
                    <div id="contentQuill" style="height: 325px">
                        {!! old('content') ?? $event->content!!}
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
        </div>
        <div class="card-footer">
            <div class="d-flex">
                <button type="submit" class="px-5 mr-2 btn btn-success">Update blog</button>
                <button type="reset" class="btn btn-secondary">Cancel</button>
            </div>
        </form>
        </div>
    </div>

@endsection
@push('js')
    <script>
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
                            ['bold', 'italic', 'underline'],
                            ['image', 'code-block']
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
            KTQuilDemos.init();
        });
    </script>
@endpush
