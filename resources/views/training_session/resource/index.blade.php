@extends('layouts.app')

@section('title', ' All Resource')


@push('css')
    <style>

    </style>
@endpush

@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap  pt-6 ">
            <div class="card-title mr-0">
                <h3 class="card-label">Resources</h3>
            </div>
            <div class="card-tool">
            </div>
        </div>
        <div class="card-body">
            <table width="100%" class="table">
                <thead>
                    </tr>
                        <th> # </th>
                        <th> Name </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resources as $key => $resource)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>

                                    {{ $resource->name }}
                            </td>
                            <td><a class="btn btn-sm btn-info" href="{{ route('session.resource.show',['training_session'=>Request::route('training_session'),'resource'=>$resource->id]) }}"><i class="fa fa-eye"></i>Show</a></td>

                        </tr>

                    @endforeach

                    @if (count($resources)<1)
                    <tr>
                    <td> <span class="text text-danger">No Resource Found!!  </span><span><a href="{{ route('resource.create') }}">  Create</a></span></td>
                </tr>

                    @endif

                </tbody>
            </table>
        </div>
        <div class="m-auto col-6 mt-3">
            {{ $resources->withQueryString()->links() }}
        </div>
    </div>
@endsection

