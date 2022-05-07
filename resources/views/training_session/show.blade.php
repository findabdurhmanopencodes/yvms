@extends('layouts.session_layout')
@section('action_title','Training Session Detail')
@section('title','Training Session Detail')
@section('breadcrumbTitle','Training Session Detail')
@section('breadcrumbList')
<li class="breadcrumb-item">
    <a  href="{{ route('training_session.index', []) }}">All Training Sessions</a>
</li>
<li class="active">Detail</li>
@endsection
@push('js')
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('assets/js/pages/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/pages/custom/profile/profile.js') }}"></script>
    <!--end::Page Scripts-->~
@endpush

@section('action_content')
    
@endsection
