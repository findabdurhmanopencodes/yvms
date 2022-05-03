@extends('layouts.app')

@section('title', 'Add Role')
@section('breadcrumb-list')
    <li class="active"><a href="{{ route('role.index', []) }}">Roles</a></li>
    <li class="active">Add role</li>
@endsection
@section('content')
    <div class="page-header">
        <h1>
            Add Role
            <i class="ace-icon fa fa-angle-double-right"></i>
            <small>
                register new roles
            </small>
        </h1>
    </div>
    <div class="row">
        <div class="col-8 mx-auto">
            <form method="POST" action="{{ isset($role)? route('role.update',['role'=> $role->id]) : route('role.store', []) }}">
                @csrf
                @isset($role)
                    @method('PATCH')
                @endisset
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="name"> Role Name </label>
                    <div class="col-sm-9">
                        <input type="text" value="{{old('name')?? (isset($role)?$role->name:'')}}" id="name" placeholder="Role Name" name="name" class="col-xs-10 col-sm-5">
                        @error('name')
                            <small class="text-danger"><b>{{ $message }}</b></small>
                        @enderror
                    </div>
                </div>
                <button class="btn-sm btn btn-outline-primary btn-rounded btn-floating">
                    <i class="fa fa-plus"></i> {{isset($role)?'Update Role':'Add Role'}}
                </button>
            </form>
        </div>
    </div>
@endsection
