@extends('layouts.app')
@section('title', 'Translation Texts')


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
        var card = new KTCard('kt_card_1');

    </script>

@endpush
@section('content')

    <div class="card card-custom mb-2 {{old('language')==null?'card-collapsed':''}} " data-card="true" id="kt_card_1">
        <div class="card-header">
            <div class="card-title">
                <h3>Languages Setting</h3>
            </div>
            <div class="card-toolbar">
                <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle">
                    <i class="ki ki-arrow-down icon-xs"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('language.store', []) }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-10 form-group">
                        <input type="text" name="language" id="language" class="form-control" placeholder="Language Name">
                        @error('language')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <input type="submit" value="Add Language" class="btn btn-primary">
                    </div>
                </div>
            </form>
            <table width="100%" class="table">
                <thead>
                    </tr>
                    <th>Language</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($langs as $lang)
                        <tr>
                            <td>{{ $lang->name }}</td>
                            <td>
                                <a href="#" onclick="confirmDeleteLanguage('{{route('language.destroy',['language'=>$lang->id])}}')">
                                    <i class="fal fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    @if (count($translationTexts) <= 0)
                        <tr style="font-size: 13px;" class="text-center">
                            <td colspan="3" style="">No translation text</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="card card-custom">

        <div class="card-header">
            <div class="card-title">
                <h3 class="title-label">Translation texts</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('translation.create', []) }}" class="btn btn-primary"><i class="fa fa-plus"></i>Add
                    new translation</a>
            </div>
        </div>
        <div class="card-body">
            <table width="100%" class="table">
                <thead>
                    </tr>
                    {{-- <th>Title</th> --}}
                    <th>Language</th>
                    <th>Type</th>
                    <th>Action</th>
                    {{-- <th><i class="menu-icon flaticon-list"></i> </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($translationTexts as $translationText)
                        <tr>
                            <td>{{ $translationText->language->name }}</td>
                            <td>{{ $translationText->trasnslationType() }}</td>
                            {{-- <td>{{ count($translationText->volunteers) }}</td> --}}
                            <td>
                                <a href="{{ route('translation.show', ['translation' => $translationText->id]) }}">
                                    <i class="fal fa-eye"></i>
                                </a>
                                <a href="#"
                                    onclick="confirmDelete('{{ route('translation.destroy', ['translation' => $translationText->id]) }}')">
                                    <i class="fal fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    @if (count($translationTexts) <= 0)
                        <tr style="font-size: 13px;" class="text-center">
                            <td colspan="3" style="">No translation text</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <form action="" method="POST" id="deleteForm">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('js')
    <script>
        function confirmDelete(url) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $('#deleteForm').attr('action', url);
                    $('#deleteForm').submit();
                }
            });
        }

        function confirmDeleteLanguage(url) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $('#deleteForm').attr('action', url);
                    $('#deleteForm').submit();
                }
            });
        }
    </script>
@endpush
