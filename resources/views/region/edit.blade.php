@extends('layouts.app')
@section('title', 'Edit Regions')
@section('breadcrumb-list')
    <li class="active">Regions</li>
@endsection
@section('breadcrumbTitle', 'Edit-region')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Regions</a>
    </li>
@endsection

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

                    <form action="{{ url('region/'.$regions->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Region Name:</label>
                                <input type="text" class="form-control" name="name" value="{{ $regions->name }}"/>
                            </div>
                            <div class="col-lg-6">
                                <label>Region Code:</label>
                                <input type="text" class="form-control" name="code" value="{{ $regions->code }}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Region Quota:</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="qoutaInpercent" value="{{ $regions->qoutaInpercent*100 }}" id="reg_quota" min="0"/>
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
<script>
    var prv_val = $("#reg_quota").val();
    $("#reg_quota").on("input", function(){
        if ($("#reg_quota").val() >= 0) {
            $.ajax({
                type: "POST",
                url: "/region/validate",
            //   method: 'post',
                data: {
                    'qouta': $('#reg_quota').val(),
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
        } else {
            $('#message').html('Invalid Number!!!');
            $(":submit").attr("disabled", true);
        }
        
    })
</script>
@endpush