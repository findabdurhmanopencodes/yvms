@extends('layouts.app')
@section('title', 'Training detail')
@section('content')

    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    {{ $training->name }}
                    <span> {{ $training->code }}</span>
                    <span><i class="flaticon2-correct text-success icon-md ml-2"></i></span>
                </h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex">
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center flex-wrap justify-content-between">
                        {{-- <div class="flex-grow-1 font-weight-bold text-dark-50 py-5 py-lg-2 mr-5 w-100">
                            {{ $training->description ?? 'There is no description of the training' }}
                            <br />
                        </div> --}}
                    </div>
                    <!--end: Content-->
                </div>
                <!--end: Info-->
            </div>
            <div>
                @can('Document.store')
                    <form action="{{ route('training_document.store', ['training' => $training->id]) }}"
                        enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Document Name</label>
                                <input type="text" name="name" class="form-control " value="{{ old('name') }}"
                                    placeholder="Enter Document name" requireddd />
                                <span class="form-text text-muted">Please enter document name</span>
                                @error('name')
                                    <small class="text-danger"><b>{{ $message }}</b></small>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label>Document</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input form-control-solid" id="document"
                                        name="document" />
                                    <label class="custom-file-label" for="document">Choose Document</label>
                                </div>
                                @error('document')
                                    <small class="text-danger"><b>{{ $message }}</b></small>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <button type="submit" class="float-right btn btn-primary mr-2"><i class="fal fa-upload"></i>
                                    {{ 'Upload document' }}</button>
                            </div>
                        </div>
                    </form>
                @endcan
            </div>
            <div class="">
                @can('Document.index')
                    <table width="100%" class="table">
                        <thead>
                            </tr>
                            <th> # </th>
                            <th> Document Name </th>
                            <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainingDocuments as $key => $trainingDocument)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        {{ $trainingDocument->name }}
                                    </td>
                                    <td>
                                        <a href="{{ asset($trainingDocument->file->file_path) }}">Download File</a>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#"
                                                onclick="confirmDeleteTrainingDocument({{ $trainingDocument->id }})">
                                                <i class="fa fa-trash fa-sm"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if (count($trainingDocuments) <= 0)
                                <tr class="text-center">
                                    <td colspan="3" style="">No training document assigned</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                @endcan
            </div>
            <!--begin: Items-->
        </div>
    </div>
    <form action="" method="POST" id="deleteTrainingDocumentForm">@csrf @method('DELETE')</form>
    <!--end::Card-->
@endsection

@push('js')
    <script>
        function confirmDeleteTrainingDocument(id) {
            $('#deleteTrainingDocumentForm').attr('action', `/training/{{ $training->id }}/training_document/${id}`);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $('#deleteTrainingDocumentForm').submit();
                }
            });
        }
    </script>
@endpush
