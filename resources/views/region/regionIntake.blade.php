@extends('layouts.app')
@section('title', 'Edit Region Intake')
@section('breadcrumb-list')
    <li class="active">Region Intake</li>
@endsection
@section('breadcrumbTitle', 'Edit-regionIntake')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Region Intake</a>
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

                    <form action="{{ route('session.intake.update', ['training_session'=>$trainingSession->id,'region_id'=>$regions->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Region Name:</label>
                                <input type="number" class="form-control" placeholder="Capacity" name="capacity" min="0" value="{{ $regionIntake->intake }}" required />
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