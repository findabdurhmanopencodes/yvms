@extends('layouts.app')
@section('title', 'feild of Study')
@section('breadcrumb-list')
    <li class=""><a href="{{ route('FeildOfStudy.index', []) }}"> Field of studies </a></li>
    <li class="active">{{  (isset($feildOfStudy) ? 'Edit' : 'Create') }} Field of study</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ isset($feildOfStudy)? 'Edit':'Create'}} Field Of Study</h5>
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ isset($feildOfStudy)? route('FeildOfStudy.update', ['FeildOfStudy' => $feildOfStudy->id]): route('FeildOfStudy.store') }}">
                        @csrf
                        @isset($feildOfStudy)
                            @method('PATCH')
                        @endisset
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="name"> Field of Study </label>
                            <div class="col-sm-9">
                                <input type="text" value="{{ old('name') ?? (isset($feildOfStudy) ? $feildOfStudy->name : '') }}"
                                    id="name" placeholder="Name" name="name" class="col-xs-10 col-sm-5 form-control">
                                @error('name')
                                    <small class="text-danger"><b>{{ $message }}</b></small>
                                @enderror
                                @if (isset($feildOfStudy))
                                <input type="hidden" name="id" value="{{ $feildOfStudy->id }}">
                                @endif
                            </div>
                        </div>
                        <button class="btn-sm btn btn-primary btn-rounded btn-floating">
                            <i class="fa fa-plus"></i> {{ isset($feildOfStudy) ? 'Update Field of study' : 'Add Field of study' }}
                        </button>
                    </form>
                </div>
            </div>        </div>
    </div>
@endsection
