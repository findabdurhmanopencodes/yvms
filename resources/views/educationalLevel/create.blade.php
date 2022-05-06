@extends('layouts.app')
@section('title', 'Educational Level')
@section('breadcrumb-list')
    <li class=""><a href="{{ route('feild_of_study.index', []) }}"> Educational Level </a></li>
    <li class="active">Add educational Level</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ isset($educationalLevel)? route('educational_level.update', ['educationalLevel' => $educationalLevel->id]): route('educational_level.store', []) }}">
                @csrf
                @isset($educationalLevel)
                    @method('PATCH')
                @endisset
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="name">Educational Level </label>
                    <div class="col-sm-9">
                        <input type="text" value="{{ old('name') ?? (isset($educationalLevel) ? $educationalLevel->name : '') }}"
                            id="name" placeholder="Name" name="name" class="col-xs-10 col-sm-5">
                        @error('name')
                            <small class="text-danger"><b>{{ $message }}</b></small>
                        @enderror
                    </div>
                </div>
                <button class="btn-sm btn btn-primary btn-rounded btn-floating">
                    <i class="fa fa-plus"></i> {{ isset($educationalLevel) ? 'Update educationa Level' : 'Add educational Level' }}
                </button>
            </form>
        </div>
    </div>
@endsection
