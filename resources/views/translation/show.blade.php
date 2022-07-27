@extends('layouts.app')
@section('title', 'Translation')
@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3>{{ $translationText->trasnslationType() }} in <b>{{ $translationText->language->name }}</b></h3>
            </div>
        </div>
        <div class="card-body">
            {!! $translationText->content !!}
        </div>
    </div>
@endsection
