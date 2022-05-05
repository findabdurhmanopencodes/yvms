@extends('layouts.app')
@section('title', 'Edit Woreda')
@section('breadcrumb-list')
    <li class="active">Woredas</li>
@endsection
@section('breadcrumbTitle', 'Edit-woreda')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Woreda</a>
    </li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            {{-- @if (session('status'))
                <h6 class="alert alert-success">{{ session('status') }}</h6>
            @endif --}}

            <div class="card">
                {{-- <div class="card-header">
                    <h4>Edit & Update Student
                        <a href="{{ url('students') }}" class="btn btn-danger float-end">BACK</a>
                    </h4>
                </div> --}}
                <div class="card-body">

                    <form action="{{ url('woreda/'.$woreda->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Woreda Name:</label>
                                <input type="text" class="form-control" name="name" value="{{ $woreda->name }}"/>
                            </div>
                            <div class="col-lg-6">
                                <label>Woreda Code:</label>
                                <input type="text" class="form-control" name="code" value="{{ $woreda->code }}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Zone:</label>
                                <br>
                                <select class="form-control select2" id="kt_select2_1" name="zone" required>
                                    <option value="{{ $woreda->zone->id }}">{{ $woreda->zone->code }}</option>
                                    @foreach ($zones as $zone)
                                        <option value="{{ $zone->id }}">{{ $zone->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/pages/crud/forms/widgets/select2.js') }}"></script>
@endpush