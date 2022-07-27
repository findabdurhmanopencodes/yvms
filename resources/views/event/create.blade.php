@extends('layouts.app')
@push('title', 'Post Events')
@push('jsPage')
    <script>
        var avatar5 = new KTImageInput('featured_image');

        avatar5.on('cancel', function(imageInput) {
            swal.fire({
                title: 'Image successfully changed !',
                type: 'success',
                buttonsStyling: false,
                confirmButtonText: 'Awesome!',
                confirmButtonClass: 'btn btn-primary font-weight-bold'
            });
        });

        avatar5.on('change', function(imageInput) {
            swal.fire({
                title: 'Image successfully changed !',
                type: 'success',
                buttonsStyling: false,
                confirmButtonText: 'Awesome!',
                confirmButtonClass: 'btn btn-primary font-weight-bold'
            });
        });

        avatar5.on('remove', function(imageInput) {
            swal.fire({
                title: 'Image successfully removed !',
                type: 'error',
                buttonsStyling: false,
                confirmButtonText: 'Got it!',
                confirmButtonClass: 'btn btn-primary font-weight-bold'
            });
        });
    </script>
    <script>
        function validate() {
            FormValidation.formValidation(
                document.getElementById('blog-form'), {
                    fields: {
                        // content: {
                        //     validators: {
                        //         notEmpty: {
                        //             message: 'Content is required'
                        //         },
                        //         // emailAddress: {
                        //         //     message: 'The value is not a valid email address'
                        //         // }
                        //     }
                        // },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap(),
                        submitButton: new FormValidation.plugins.SubmitButton(),
                        defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                    }
                }
            );
        }
        $(function() {
            validate();
        })
    </script>
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

            <form method="POST" action="{{ route('Events.store') }}" enctype="multipart/form-data">
                @csrf
                <label class="text-right col-form-label ">Title</label>
                <div class="row">
                    <div class="col-md-12 form-group d-flex">


                        <div class="col-md-11">
                            <input class="form-control @error('title') is-invalid @enderror" type="text" placeholder="Title"
                                id="title" name="title" value="{{ old('title') }}" />
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
        </div>
        <div class="card-footer">
            <div class="d-flex">
                <button type="submit" class="px-5 mr-2 btn btn-success">Post Event</button>
                <a href="{{ route('Events.index') }}" class="btn btn-secondary">Cancel</a>
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
