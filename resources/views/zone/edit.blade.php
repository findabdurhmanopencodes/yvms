@extends('layouts.app')
@section('title', 'Edit Zone')
@section('breadcrumb-list')
    <li class="active">Zones</li>
@endsection
@section('breadcrumbTitle', 'Edit-zone')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Zones</a>
    </li>
@endsection

@push('css')
<style>
    .select2,
    .select2-container,
    .select2-container--default,
    .select2-container--below {
        width: 100% !important;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            {{-- @if (session('status'))
                <h6 class="alert alert-success">{{ session('status') }}</h6>
            @endif --}}

            <div class="card">
                {{-- <div class="card-header">
                    <h4>Edit & Update Student
                        <a href="{{ url('students') }}" class="btn btn-danger float-end">BACK</a>
                    </h4>
                </div> --}}
                <div class="card-body">

                    <form action="{{ url('zone/'.$zone->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Zone Name:</label>
                                <input type="text" class="form-control" name="name" value="{{ $zone->name }}"/>
                            </div>
                            <div class="col-lg-6">
                                <label>Zone Code:</label>
                                <input type="text" class="form-control" name="code" value="{{ $zone->code }}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Region:</label>
                                <br>
                                <select class="form-control select2" name="region" id="region" required>
                                    <option value="{{ $zone->region->id }}">{{ $zone->region->name }}</option>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <label>Zone Quota:</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="qoutaInpercent" value="{{ $zone->qoutaInpercent*100 }}" id="zon_quota" min="0"/>
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <small class="text-danger"><b id="message"></b></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-2 col-form-label">Active: </label>
                            <div class="col-3">
                                <span class="switch switch-icon">
                                    <label>
                                        <input type="checkbox" checked="checked" name="status"/>
                                        <span></span>
                                    </label>
                                </span>
                            </div>                            
                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    {{-- <script src="{{ asset('assets/js/pages/crud/forms/widgets/select2.js') }}"></script> --}}

    <script>
        $( document ).ready(function() {
            $('#region').select2({
                placeholder: "Select a region"
            });

        });

        var prv_val = $('#zon_quota').val();
        $("#zon_quota").on("input", function(){
            if ($("#zon_quota").val() >= 0) {
                value = $('#region').val();
                if (value) {
                    $.ajax({
                    type: "POST",
                    url: "/zone/validate",
                    //   method: 'post',
                    data: {
                        'region_id': value,
                        'qouta': $('#zon_quota').val(),
                        'prv_val': prv_val,
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(result){
                        if (result.limit == false) {
                            $('#message').html('you reached max qouta');
                            $(":submit").attr("disabled", true);
                        }else{
                            $('#message').html('');
                            $(":submit").removeAttr("disabled");
                        }
                    },
                    });
                }
            } else {
                $('#message').html('Invalid Number!!!');
                $(":submit").attr("disabled", true);
            }
        });
    </script>
@endpush