@extends('layouts.app')

@section('title', 'Add Resource')
@section('breadcrumbTitle', 'Add New Resource')

@section('breadcrumbList')
    <li class="breadcrumb-item"><a href="{{ route('resource.index') }}">Resource</a></li>
    <li class="breadcrumb-item active">Add resource</li>
@endsection
@section('content')
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Add Resource Form</h3>
        </div>
        <div class="card-body">
            <form class="form" method="POST"
                action="{{ isset($resource) ? route('resource.update', ['resource' => $resource->id]) : route('resource.store', []) }}">
                @csrf
                @isset($resource)
                    @method('PATCH')
                @endisset
                <div class="card-body row">
                    <div class="form-group col-md-12">
                        <label>Name</label>
                        <input type="text" name="name"
                            class="form-control form-control-solid" value="{{ old('name') ?? (isset($resource) ? $resource->name : '') }}"
                            placeholder="Enter resource name" />
                        <span class="form-text text-muted">Please enter resource name</span>
                        @error('name')
                            <small class="text-danger"><b>{{ $message }}</b></small>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-plus"></i>
                        {{ isset($resource) ? 'Update resource' : 'Add resource' }}</button>
                    <a href="{{ route('resource.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
