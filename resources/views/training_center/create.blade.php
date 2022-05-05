@extends('layouts.app')
@section('title', 'Add Training Center')
@section('breadcrumbTitle', 'Add New Role')

@section('breadcrumbList')
    <li class="breadcrumb-item"><a href="{{ route('TrainingCenter.index', []) }}">Training Centers</a></li>
    <li class="breadcrumb-item active"> adding Training Center</li>
@endsection


@section('content')
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Training Center Registeration Form</h3>
        </div>
        <div class="card-body">
            <form class="form" method="POST"
                action="{{ isset($trainingCenter) ? route('TrainingCenter.update', ['TrainingCenter' => $trainingCenter->id]) : route('TrainingCenter.store', []) }}"
                enctype="multipart/form-data">
                @csrf
                @isset($trainingCenter)
                    @method('PATCH')
                @endisset
                <div class="card-body row">
                    <div class="form-group col-md-12">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control "
                            value="{{ old('name') ?? (isset($trainingCenter) ? $trainingCenter->name : '') }}"
                            placeholder="Enter Training Center name" required />
                        <span class="form-text text-muted">Please enter trainingCenter name</span>
                        @error('name')
                            <small class="text-danger"><b>{{ $message }}</b></small>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label>Code</label>
                        <input type="text" name="code" class="form-control "
                            value="{{ old('code') ?? (isset($trainingCenter) ? $trainingCenter->code : '') }}"
                            placeholder="Enter Training Center code" />
                        <span class="form-text text-muted">Please enter Training Center name</span>
                        @error('code')
                            <small class="text-danger"><b>{{ $message }}</b></small>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label>Logo</label>
                        <div></div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input form-control-solid" id="logo" name="logo" />
                            <label class="custom-file-label" for="logo">Choose Image</label>
                        </div>
                        @error('logo')
                        <small class="text-danger"><b>{{ $message }}</b></small>
                    @enderror
                    </div>
                </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-plus"></i>
                {{ isset($trainingCenter) ? 'Update Training Center' : 'Add Training Center' }}</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
        </form>
    </div>
    </div>
@endsection
