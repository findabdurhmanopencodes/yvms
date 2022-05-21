@extends('layouts.app')
@section('title', 'Training All')
@section('content')
    <!--begin::Card-->
    <div class="card card-custom card-body mb-3">
        <form action="{{ route('training.store', []) }}" method="POST">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Training Title</label>
                    <input type="text" name="name" class="form-control form-control-solid" value="{{ old('name') }}"
                        placeholder="Enter training name" />
                    {{-- <span class="form-text text-muted">Please enter training name</span> --}}
                    @error('name')
                        <small class="text-danger"><b>{{ $message }}</b></small>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>Code</label>
                    <input type="text" name="code" class="form-control form-control-solid" value="{{ old('code') }}"
                        placeholder="Enter training code" />
                    {{-- <span class="form-text text-muted">Please enter training code</span> --}}
                    @error('code')
                        <small class="text-danger"><b>{{ $message }}</b></small>
                    @enderror
                </div>
                <div class="col-md-12">
                    <input type="submit" value="Add Training" class="btn d-block ml-auto btn-primary">
                </div>
            </div>
        </form>
    </div>




    <!-- Modal-->
    <div class="modal fade" id="editTrainingModal" tabindex="-1" role="dialog" aria-labelledby="editTrainingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" id="trianingUpdateForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTrainingModalLabel">Edit Training</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Training Title</label>
                                <input type="text" name="name" class="form-control form-control-solid"
                                    value="{{ old('name') }}" id="editName" placeholder="Enter training name" />
                                {{-- <span class="form-text text-muted">Please enter training name</span> --}}
                                @error('name')
                                    <small class="text-danger"><b>{{ $message }}</b></small>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label>Training Code</label>
                                <input type="text" name="code" id="editCode" class="form-control form-control-solid"
                                    value="{{ old('code') }}" placeholder="Enter training code" />
                                {{-- <span class="form-text text-muted">Please enter training code</span> --}}
                                @error('code')
                                    <small class="text-danger"><b>{{ $message }}</b></small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                        <input type="submit" value="Save changes" class="btn btn-primary font-weight-bold">
                        {{-- <button type="button" onclick="$('#editTrainingModal').submit()" class="btn btn-primary font-weight-bold"></button> --}}
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-custom">
        <div class="card-header flex-wrap  pt-6 ">
            <div class="card-title mr-0">
                <h3 class="card-label"> All Trainings </h3>
            </div>
        </div>
        <div class="card-body">
            <table width="100%" class="table table-striped ">
                <thead>
                    </tr>
                    <th> #</th>
                    <th> Name </th>
                    <th> Code </th>
                    <th> Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trainings as $key => $training)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $training->name }}</td>
                            <td> {{ $training->code }} </td>
                            <td>
                                <a href="#" class="btn btn-icon" onclick="$('#trianingUpdateForm').attr('action','{{route('training.update',['training'=>$training->id])}}');$('#editName').val('{{$training->name}}');$('#editCode').val('{{$training->code}}')" data-toggle="modal" data-target="#editTrainingModal">
                                    <span class="fa fa-edit"></span>
                                </a>

                                <a href="{{ route('training.show', ['training'=>$training->id]) }}" class="btn btn-icon" >
                                    <span class="fa fa-eye"></span>
                                </a>
                                <a href="#" class="btn btn-icon" onclick="deleteTraining('{{ $training->id }}')">
                                    <span class="fa fa-trash"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="m-auto col-6 mt-3">
            {{ $trainings->withQueryString()->links() }}
        </div>
    </div>
    <form method="POST" id="trainingDelete">
        @csrf
        @method('DELETE')
    </form>

@endsection
@push('js')
    <script>
        function deleteTraining(trainingId) {
            Swal.fire({
                title: "Are you sure?",
                text: "This will delete training!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    var route = '/training/' + trainingId;
                    $('#trainingDelete').attr('action', route);
                    $('#trainingDelete').submit();
                }
            });
        }

    </script>
@endpush
