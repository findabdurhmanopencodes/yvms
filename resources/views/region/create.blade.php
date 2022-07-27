@extends('layouts.app')
@section('title', 'Add Region')
@section('breadcrumb-list')
    <li class=""><a href="{{ route('region.index', []) }}">Regions</a></li>
    <li class="active">Add Region</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            {{-- {{ Form::open(array('url' => 'region', 'method')) }} --}}
            {{-- {!! Form::open(['url' => 'region/store', 'method' => 'POST']) !!} --}}
            <form method="POST" action="{{ isset($region)? route('region.update', ['region' => $region->id]): route('region.store', []) }}">
                @csrf
                @isset($region)
                    @method('PATCH')
                @endisset
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="name"> Region Name </label>
                    <div class="col-sm-6">
                        <input type="text" value="{{ old('name') ?? (isset($region) ? $region->name : '') }}"
                            id="name" placeholder="Region Name" name="name" class="col-xs-10 col-sm-5">
                        @error('name')
                            <small class="text-danger"><b>{{ $message }}</b></small>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <input type="text" value="{{ old('code') ?? (isset($region) ? $region->code : '') }}"
                            id="code" placeholder="Region Code" name="code" class="col-xs-10 col-sm-5">
                        @error('code')
                            <small class="text-danger"><b>{{ $message }}</b></small>
                        @enderror
                    </div>
                </div>
                <button class="btn-sm btn btn-primary btn-rounded btn-floating">
                    <i class="fa fa-plus"></i> {{ isset($region) ? 'Update Region' : 'Add Region' }}
                </button>
            </form>
                {{-- {{ Form::close() }} --}}
            {{-- {!! Form::close() !!} --}}
        </div>
    </div>
@endsection
