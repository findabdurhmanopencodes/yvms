@extends('layouts.app')
@push('title', 'Event Detail')
@push('jsPage')
@endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $event->title }}</h5>

            <div class="card card-custom gutter-b">

                <div class="card-title">
                    <h3 class="card-label">
                        {{ $event->title }}
                        <small>{{ $event->created_at->diffForHumans() }}</small>
                    </h3>
                    @foreach ($event->images as $image)
                    <div >
                        <img src="{{ asset($image->url) }}"class="my-11" width="700" height="300" alt="event Image not Found">
                        <p>created At:{{ $image->created_at }}</p>

                    </div>
                    <div>
                        @can('Event.update')
                        <a class="btn btn-danger" href="{{ route('event.image.remove', ['eventImage'=>$image->id]) }}" onclick="alert('are you sure to delete');">Delete Image</a>

                        @endcan
                        </div>

                    @endforeach
                </div>
            </div>
            <div class="card-body">
                {!! $event->content !!}
            </div>
        </div>
    </div>
    </div>
@endsection
