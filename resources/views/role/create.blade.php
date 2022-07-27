@extends('layouts.app')

@section('title', 'Add Role')
@section('breadcrumbTitle', 'Add New Role')

@section('breadcrumbList')
    <li class="breadcrumb-item"><a href="{{ route('role.index', []) }}">Roles</a></li>
    <li class="breadcrumb-item active">Add role</li>
@endsection
@section('content')
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Add Role Form</h3>
        </div>
        <div class="card-body">
            <form class="form" method="POST"
                action="{{ isset($role) ? route('role.update', ['role' => $role->id]) : route('role.store', []) }}">
                @csrf
                @isset($role)
                    @method('PATCH')
                @endisset
                <div class="card-body row">
                    <div class="form-group col-md-12">
                        <label>Name</label>
                        <input type="text" name="name"
                            class="form-control form-control-solid" value="{{ old('name') ?? (isset($role) ? $role->name : '') }}"
                            placeholder="Enter role name" />
                        <span class="form-text text-muted">Please enter role name</span>
                        @error('name')
                            <small class="text-danger"><b>{{ $message }}</b></small>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-plus"></i>
                        {{ isset($role) ? 'Update Role' : 'Add Role' }}</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection
