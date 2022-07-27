@extends('layouts.app')

@section('title', ' All Resource')


@push('css')
    <style>

    </style>
@endpush

@section('content')
<div class="accordion accordion-solid accordion-toggle-plus " id="accordionExample6">

    <div class="card ">
        <div id="headingThree6" class="card-header text-white" style="background-color: rgba(15, 69, 105, 0.6);">
            <div class="card-title collapsed text-white" data-toggle="collapse" data-target="#collapseThree6"
                style="background-color: rgba(15, 69, 105, 0.6);">
                <i class="flaticon2-search fa-2x text-white"></i> Filter Resources
            </div>
        </div>
        <div id="collapseThree6" class="collapse" data-parent="#accordionExample6">
            <div class="card-body">

                <form
                    action="{{ route('session.resource.all',['training_session'=>Request::route('training_session')]) }}"
                    method="POST">
                    @csrf
                    <div class="col-sm-4">
                        <label for="title" class=" col-sm-12 col-form-label">Resource Name</label>
                        <input class="form-control" type="text" name="name" id="name">

                    </div>
                    <button type="submit" class="btn btn-primary  mx-4 my-4" name="filter" value="filter"><i
                            class="fa fa-search"></i> Search</button>
                </form>

            </div>

        </div>
    </div>
</div>
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
            {{ $resources->links() }}
        </div>
    </div>
@endsection

