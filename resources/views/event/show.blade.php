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
                        <img src="{{ asset($image->url) }}" alt="images">
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
