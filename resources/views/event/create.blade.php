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
    <form action="{{ route('event.store', []) }}" enctype="multipart/form-data" id="blog-form" method="POST">
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
                <div>
                    <label class="text-right col-form-label ">Event Image</label>
                    <div class="image-input image-input-empty image-input-outline" id="featured_image"
                        style="background-image: url('{{ asset('assets/media/bg/bg-5.jpg') }}')">
                        <div class="image-input-wrapper"></div>
                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                            data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                            <i class="fa fa-pen icon-sm text-muted"></i>
                            <input type="file" name="featured_image" accept=".png, .jpg, .jpeg" />
                            <input type="hidden" name="featured_image_remove" />
                        </label>

                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                            data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                        </span>

                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                            data-action="remove" data-toggle="tooltip" title="Remove avatar">
                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group d-flex">
                        <div class="col-md-1">
                            <label class="text-right col-form-label ">Title</label>
                        </div>
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
                <div class="">
                    <label for="">Body</label>
                    <div id="contentQuill" style="height: 325px">
                        {!! old('content') !!}
                    </div>
                    <textarea name="content" id="content-textarea" class="d-none">{{ old('content') }}</textarea>
                    @error('content')
                        <div class="fv-plugins-message-container">
                            <div data-field="content" data-validator="stringLength" class="fv-help-block">{{ $message }}
                            </div>
                        </div>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex">
                    <button type="submit" class="px-5 mr-2 btn btn-success">Post blog</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
        </div>
    </form>
@endsection
