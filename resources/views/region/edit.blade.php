@extends('layouts.app')
@section('title', 'Edit Regions')
@section('breadcrumb-list')
    <li class="active">Regions</li>
@endsection
@section('breadcrumbTitle', 'Edit-region')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Regions</a>
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

                    <form action="{{ url('region/'.$regions->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Region Name:</label>
                                <input type="text" class="form-control" name="name" value="{{ $regions->name }}"/>
                            </div>
                            <div class="col-lg-6">
                                <label>Region Code:</label>
                                <input type="text" class="form-control" name="code" value="{{ $regions->code }}"/>
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