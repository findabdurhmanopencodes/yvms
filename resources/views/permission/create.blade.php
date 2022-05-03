@extends('layouts.app')
@section('title', 'Add Permission')
@section('breadcrumb-list')
    <li class=""><a href="{{ route('permission.index', []) }}">Permissions</a></li>
    <li class="active">Add Permission</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST"
                action="{{ isset($permission)? route('permission.update', ['permission' => $permission->id]): route('permission.store', []) }}">
                @csrf
                @isset($permission)
                    @method('PATCH')
                @endisset
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="name"> Permission Name </label>
                    <div class="col-sm-9">
                        <input type="text" value="{{ old('name') ?? (isset($permission) ? $permission->name : '') }}"
                            id="name" placeholder="Permission Name" name="name" class="col-xs-10 col-sm-5">
                        @error('name')
                            <small class="text-danger"><b>{{ $message }}</b></small>
                        @enderror
                    </div>
                </div>
                <button class="btn-sm btn btn-primary btn-rounded btn-floating">
                    <i class="fa fa-plus"></i> {{ isset($permission) ? 'Update Permission' : 'Add Permission' }}
                </button>
            </form>
        </div>
    </div>
@endsection
