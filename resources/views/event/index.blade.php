@extends('layouts.app')
@section('title', 'All events')
@section('breadcrumbList')
    <li class="active">events</li>
@endsection
@section('breadcrumbTitle', 'events')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">events</a>
    </li>
@endsection
@push('js')
    <script src="{{ asset('assets/js/pages/crud/ktdatatable/base/data-ajax.js') }}"></script>
@endpush
@section('content')
    <div class="accordion accordion-solid accordion-toggle-plus " id="accordionExample6">

        <div class="card ">
            <div id="headingThree6" class="card-header text-white" style="background-color: rgba(15, 69, 105, 0.6);">
                <div class="card-title collapsed text-white" data-toggle="collapse" data-target="#collapseThree6"
                    style="background-color: rgba(15, 69, 105, 0.6);">
                    <i class="flaticon2-search fa-2x text-white"></i> Filter Events
                </div>
            </div>
            <div id="collapseThree6" class="collapse" data-parent="#accordionExample6">
                <div class="card-body">

                    <form action="{{ route('Events.index') }}" method="POST">
                        @csrf
                        <div class="col-sm-4">
                            <label for="title" class=" col-sm-12 col-form-label">Event Title</label>
                            <input class="form-control" type="text" name="title" id="title">

                        </div>
                        <button type="submit" class="btn btn-primary  mx-4 my-4" name="filter" value="filter"><i
                                class="fa fa-search"></i> Search</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">List of events
                    <span class="text-muted pt-2 font-size-sm d-block">events</span>
                </h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @can('Event.store')
                    <a href="{{ route('Events.create', []) }}" class="btn btn-primary font-weight-bolder">
                        <span class="svg-icon svg-icon-md">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                            <i class="fal fa-plus"></i>
                            <!--end::Svg Icon-->
                        </span>Add New events</a>
                @endcan
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <table class="table " width="100">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $key => $event)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $event->title }}</td>
                            <td>
                                <form action="{{ route('Events.destroy', ['Event' => $event]) }}" method="post">
                                    @can('Event.show')
                                        <a class="btn btn-info" href="{{ route('Events.show', ['Event' => $event->id]) }}"><i
                                                class="fa fa-eye"></i>Detail</a>
                                    @endcan
                                    @can('Event.update')
                                        <a class="btn btn-warning" href="{{ route('Events.edit', ['Event' => $event->id]) }}"><i
                                                class="fa fa-edit"></i>Edit</a>
                                    @endcan

                                    @can('Event.destroy')
                                        <input class="btn btn-danger" type="submit" value="Delete" />
                                    @endcan
                                    @method('delete')
                                    @csrf
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if (count($events) < 1)
                        <tr>
                            <td class="text-capitalize text-danger font-size-h4">No Events Found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {!! $events->links() !!}
            </div>
        </div>
    </div>
@endsection
