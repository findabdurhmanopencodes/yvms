@extends('layouts.app')

@section('title', 'Session Center Detail')


@push('css')
    <style>

    </style>
@endpush

@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap  pt-6 ">
            <div class="card-title mr-0">
                <h3 class="card-label">Trainning Centers</h3>
            </div>
            <div class="card-tool">
            </div>
        </div>
        <div class="card-body">
            <table width="100%" class="table table-striped ">
                <thead>
                    </tr>
                        <th> # </th>
                        <th> Center </th>
                        <th> Capacity </th>
                        <th> Code </th>
                        <th> Zone </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trainingCenterCapacities as $key => $trainingCenterCapacity)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <a href="{{ route('session.training_center.show', ['training_session'=>Request::route('training_session'),'training_center'=>$trainingCenterCapacity->trainingCenter->id]) }}">
                                    {{ $trainingCenterCapacity->trainingCenter->name }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('session.training_center.show', ['training_session'=>Request::route('training_session'),'training_center'=>$trainingCenterCapacity->trainingCenter->id]) }}">
                                    {{ $trainingCenterCapacity->capacity }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('session.training_center.show', ['training_session'=>Request::route('training_session'),'training_center'=>$trainingCenterCapacity->trainingCenter->id]) }}">
                                    {{ $trainingCenterCapacity->trainingCenter->code }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('session.training_center.show', ['training_session'=>Request::route('training_session'),'training_center'=>$trainingCenterCapacity->trainingCenter->id]) }}">
                                    {{ $trainingCenterCapacity->trainingCenter->zone->name }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('session.training_center.show', ['training_session'=>Request::route('training_session'),'training_center'=>$trainingCenterCapacity->trainingCenter->id]) }}"
                                    class="btn btn-icon">
                                    <span class="fa fa-eye"></span>
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
            var sessionId = '{{ Request::route('training_session')->id }}';
            $('#deleteForm').attr('action', '/' + sessionId + '/training_master_placement/' + masterId);
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
