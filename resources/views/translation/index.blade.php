@extends('layouts.app')
@section('title', 'Translation Texts')
@section('content')
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
                                <a href="#"
                                    onclick="confirmDelete('{{ route('translation.destroy', ['translation' => $translationText->id]) }}')">
                                    <i class="fal fa-trash"></i>
                                </a>
                                <a href="{{ route('translation.show', ['translation' => $translationText->id]) }}">
                                    <i class="fal fa-eye"></i>
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
    </script>
@endpush
