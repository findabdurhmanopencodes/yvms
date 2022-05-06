@extends('layouts.app')
@section('title', 'Disablity type')
@section('breadcrumb-list')
    <li class=""><a href="{{ route('disablity.index', []) }}"> Disablity type </a></li>
    <li class="active">Add disablity type</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ isset($disablity)? route('disablity.update', ['disablity' => $disablity->id]): route('disablity.store', []) }}">
                @csrf
                @isset($educationalLevel)
                    @method('PATCH')
                @endisset
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="name">Educational Level </label>
                    <div class="col-sm-9">
                        <input type="text" value="{{ old('name') ?? (isset($disablity) ? $disablity->name : '') }}"
                            id="name" placeholder="Name" name="name" class="col-xs-10 col-sm-5">
                        @error('name')
                            <small class="text-danger"><b>{{ $message }}</b></small>
                        @enderror
                    </div>
                </div>
                <button class="btn-sm btn btn-primary btn-rounded btn-floating">
                    <i class="fa fa-plus"></i> {{ isset($disablity) ? 'Update disablity type' : 'Add disablity type' }}
                </button>
            </form>
        </div>
    </div>
@endsection
