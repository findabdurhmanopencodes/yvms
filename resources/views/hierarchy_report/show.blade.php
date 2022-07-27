@extends('layouts.app')
@section('title', 'Hierarchy detail')
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap  pt-6 ">
            <div class="card-title align-items-start flex-column mr-0">
                <span class="card-label font-weight-bolder text-dark">Hierarchila Report Detail</span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm">Reported From :
                    {{ $hierarchy->reportable->name }}
                    <span class="label label-lg label-light-success label-inline">Reported date
                        :{{ \App\Constants::convertDateToEt($hierarchy->created_at)->format('d-m-Y') }} </span>
                </span>
            </div>

            <div class="card-tool">
                @can('HierarchyReport.update')
                    <a href="{{ route('session.hierarchy.edit', ['training_session' => Request::route('training_session')->id, 'hierarchy' => $hierarchy->id]) }}"
                        class="btn btn-primary">
                        <i class="fal fa-pen"></i>
                        Edit
                    </a>
                @endcan
                @can('HierarchyReport.destroy')
                    <button type="button" class="btn btn-danger" onclick="confirmDeleteReport()">
                        <i class="fal fa-trash"></i>
                        Delete
                    </button>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <div>
                {!! $hierarchy->content !!}
            </div>
        </div>
    </div>
    @can('HierarchyReport.destroy')
        <form id="reportFormDelete"
            action="{{ route('session.hierarchy.destroy', ['training_session' => Request::route('training_session')->id, 'hierarchy' => $hierarchy->id]) }}"
            method="POST">
            @method('DELETE')
            @csrf
        </form>
    @endcan

@endsection
@push('js')
    <script>
        function confirmDeleteReport() {
            event.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "danger",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $('#reportFormDelete').submit();
                }
            });
        }
    </script>
@endpush
