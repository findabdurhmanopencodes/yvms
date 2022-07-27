@extends('layouts.app')
@section('title', 'Add Permission')
@section('breadcrumbTitle', 'Add Permission')
@section('breadcrumbList')
    <li class="breadcrumb-item"><a href="{{ route('permission.index', []) }}">Permissions</a></li>
    <li class="breadcrumb-item active">Add permission</li>
@endsection

@section('content')
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Add Permission Form</h3>
        </div>
        <div class="card-body">
            <form class="form" method="POST"
                action="{{ isset($permission) ? route('permission.update', ['permission' => $permission->id]) : route('permission.store', []) }}">
                @csrf
                @isset($permission)
                    @method('PATCH')
                @endisset
                <div class="card-body row">
                    <div class="form-group col-md-12">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control form-control-solid"
                            value="{{ old('name') ?? (isset($permission) ? $permission->name : '') }}"
                            placeholder="Enter permission name" />
                        <span class="form-text text-muted">Please enter permission name</span>
                        @error('name')
                            <small class="text-danger"><b>{{ $message }}</b></small>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-plus"></i>
                        {{ isset($permission) ? 'Update Permission' : 'Add Permission' }}</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection
