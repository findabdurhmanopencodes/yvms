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
    <form action="{{ route('Event.store', []) }}" enctype="multipart/form-data" id="blog-form" method="POST">
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

                <form method="POST" action="{{ route('Event.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-custom">
                        <div class="card-header">
                            <h3 class="card-title">
                                Basic Demo
                            </h3>
                        </div>
                        <div class="card-body">
                            <div id="kt_quil_1" style="height: 325px">
                                Compose a message
                            </div>
                        </div>
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
