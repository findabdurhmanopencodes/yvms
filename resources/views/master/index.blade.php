@extends('layouts.app')
@section('title', 'Master Trainers')
@push('css')
@endpush
@push('js')
    <script>
        function confirmDeleteMaster(masterId) {

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $('#deleteForm').attr('action','/training_master/'+masterId);
                    $('#deleteForm').submit();
                }
            });
        }
    </script>
@endpush
@section('content')
    <form  method="POST" id="deleteForm">
        @csrf
        @method('DELETE')
    </form>
    <div class="card card-custom">
        <div class="card-header flex-wrap  pt-6 ">
            <div class="card-title mr-0">
                <h3 class="card-label">Master Trainers</h3>
            </div>
            <div class="card-tool">
                <a href="{{ route('training_master.create', []) }}" class="btn btn-primary">Add Master
                    Trainer</a>
            </div>
        </div>
        <div class="card-body">
            <table width="100%" class="table table-striped ">
                <thead>
                    </tr>
                    <th> # </th>
                    <th> Full Name </th>
                    <th> Email </th>
                    <th> Bank Account </th>
                    <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($masters as $key => $master)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $master->user->name() }}</td>
                            <td> {{ $master->user->email }} </td>
                            <td>
                                {{ $master->bank_account }}
                            </td>
                            <td>
                                <a href="{{ route('training_master.edit', ['training_master' => $master->id]) }}"
                                    class="btn btn-icon">
                                    <span class="fa fa-edit"></span>
                                </a>

                                <a href="#" onclick="confirmDeleteMaster({{ $master->id }})" class="btn btn-icon">
                                    <span class="fa fa-trash"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="m-auto col-6 mt-3">
            {{ $masters->withQueryString()->links() }}
        </div>
    </div>
@endsection
