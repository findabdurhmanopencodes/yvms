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
                <a href="{{ route('Events.create', []) }}" class="btn btn-primary font-weight-bolder">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <i class="fal fa-plus"></i>
                        <!--end::Svg Icon-->
                    </span>Add New events</a>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <table class="table " width="100">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        {{-- <th>Content</th> --}}
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $key => $event)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $event->title }}</td>
                            {{-- <td> {!! $event->content !!}</td> --}}
                            <td><a class="btn btn-info" href="{{ route('Events.show', ['Event'=>$event->id]) }}"><i class="fa fa-eye"></i>Detail</a></td>
                        </tr>
                    @endforeach
                    @if (count($events) < 1)
                        <tr>
                            <td class="text-capitalize text-danger font-size-h4">No Applicants Found</td>
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
