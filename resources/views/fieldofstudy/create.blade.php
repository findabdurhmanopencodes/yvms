@extends('layouts.app')
@section('title', 'feild of Study')
@section('breadcrumb-list')
    <li class=""><a href="{{ route('feild_of_study.index', []) }}"> Field of studies </a></li>
    <li class="active">Add Field of study</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ isset($feildOfStudy)? route('feild_of_study.update', ['feildOfStudy' => $feildOfStudy->id]): route('feild_of_study.store', []) }}">
                @csrf
                @isset($feildOfStudy)
                    @method('PATCH')
                @endisset
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="name"> Field of Study </label>
                    <div class="col-sm-9">
                        <input type="text" value="{{ old('name') ?? (isset($feildOfStudy) ? $feildOfStudy->name : '') }}"
                            id="name" placeholder="Name" name="name" class="col-xs-10 col-sm-5">
                        @error('name')
                            <small class="text-danger"><b>{{ $message }}</b></small>
                        @enderror
                    </div>
                </div>
                <button class="btn-sm btn btn-primary btn-rounded btn-floating">
                    <i class="fa fa-plus"></i> {{ isset($feildOfStudy) ? 'Update Field of study' : 'Add Field of study' }}
                </button>
            </form>
        </div>
    </div>
@endsection
