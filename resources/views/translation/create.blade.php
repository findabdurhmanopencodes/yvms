@extends('layouts.app')
@section('title', 'Add new translation text')


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
@push('js')
    <script>
        $(function() {
            $('.select2').select2({
                allowClear: true
            })
        });
    </script>
    <script>
        // Class definition
        var KTQuilDemos = function() {

            // Private functions
            var demo1 = function() {
                var quill = new Quill('#content_div', {
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
                var editorId = '#content_div';
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
    <div class="card card-custom">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" id="registration_form" action="{{ route('translation.store', []) }}">
                        @csrf
                        @include('translation.form')
                        <div class="clear-fix"></div>
                        <div class="col-md-12 clear-both" style="margin-top: 100px !important;">
                            <input type="submit" class=" btn btn-primary float-right" value="Add Translation">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
