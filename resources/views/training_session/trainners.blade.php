@extends('layouts.app')
@section('title', 'Assigned Training Masters')

@push('css')
    <style>

    </style>
@endpush

@section('content')
    <form method="POST" id="deleteForm">
        @csrf
        @method('DELETE')
    </form>
    <div class="card card-custom mb-2">
        <div class="card-body">
            <form method="POST"
                action="{{ route('session.training_master_placement.store', ['training_session' => Request::route('training_session')]) }}"
                class="row">
                @csrf
                <div class="col-md-5 form-group">
                    <select name="trainner" id="trainner"
                        class=" @error('trainner') is-invalid @enderror select2 form-control  form-control select2">
                        <option value="">Select Trainner</option>
                        @foreach ($freeTrainners as $freeTrainner)
                            <option
                                {{ old('trainner') != null ? (old('trainner') == $freeTrainner->id ? 'selected' : '') : '' }}
                                value="{{ $freeTrainner->id }}">{{ $freeTrainner->user->name }}</option>
                        @endforeach
                    </select>
                    @error('trainner')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <span class="form-text text-muted">Please select trainner.</span>
                </div>
                <div class="col-md-5 form-group">
                    <select name="training_center" id="training_center"
                        class=" @error('training_center') is-invalid @enderror select2 form-control  form-control select2">
                        <option value="">Select Training Center</option>
                        @foreach ($trainingCenters as $trainingCenter)
                            <option
                                {{ old('training_center') != null ? (old('training_center') == $trainingCenter->id ? 'selected' : '') : '' }}
                                value="{{ $trainingCenter->id }}">{{ $trainingCenter->name }}</option>
                        @endforeach
                    </select>
                    @error('training_center')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <span class="form-text text-muted">Please select training center.</span>
                </div>
                <div class="col-md-2">
                    <input type="submit" value="Assign Master Trainer" class="btn btn-sm btn-primary">
                </div>
            </form>
        </div>
    </div>
    <div class="card card-custom">
        <div class="card-header flex-wrap  pt-6 ">
            <div class="card-title mr-0">
                <h3 class="card-label">Master Trainers</h3>
            </div>
            <div class="card-tool">
            </div>
        </div>
        <div class="card-body">
            <table width="100%" class="table table-striped ">
                <thead>
                    </tr>
                    <th> # </th>
                    <th> Full Name </th>
                    <th> Training Center </th>
                    <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trainingMasterPlacements as $key => $trainingMasterPlacement)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><a
                                    href="{{ route('training_master.show', ['training_master' => $trainingMasterPlacement->master->id]) }}">{{ $trainingMasterPlacement->master->user->name() }}</a>
                            </td>
                            <td><a
                                    href="{{ route('TrainingCenter.show', ['TrainingCenter' => $trainingMasterPlacement->center->id]) }}">
                                    {{ $trainingMasterPlacement->center->name }}
                                </a> </td>
                            <td>
                                <a href="{{ route('training_master.edit', ['training_master' => $trainingMasterPlacement->master->id]) }}"
                                    class="btn btn-icon">
                                    <span class="fa fa-edit"></span>
                                </a>

                                <a href="#" onclick="confirmDeleteMasterPlacement({{ $trainingMasterPlacement->id }})"
                                    class="btn btn-icon">
                                    <span class="fa fa-trash"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="m-auto col-6 mt-3">
            {{-- {{ $masters->withQueryString()->links() }} --}}
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('.select2').select2({
            allowClear: true
        });

        function confirmDeleteMasterPlacement(masterId) {
            var sessionId = '{{ Request::route('training_session')->id   }}';
            $('#deleteForm').attr('action', '/'+sessionId+'/training_master_placement/' + masterId);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $('#deleteForm').submit();
                }
            });
        }
    </script>
@endpush
