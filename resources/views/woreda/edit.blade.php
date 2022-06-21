@extends('layouts.app')
@section('title', 'Edit Woreda')
@section('breadcrumb-list')
    <li class="active">Woredas</li>
@endsection
@section('breadcrumbTitle', 'Edit-woreda')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Woreda</a>
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

                    <form action="{{ url('woreda/'.$woreda->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Woreda Name:</label>
                                <input type="text" class="form-control" name="name" value="{{ $woreda->name }}"/>
                            </div>
                            <div class="col-lg-6">
                                <label>Woreda Code:</label>
                                <input type="text" class="form-control" name="code" value="{{ $woreda->code }}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Zone:</label>
                                <br>
                                <select class="form-control select2" name="zone"  id="zone" required>
                                    <option value="{{ $woreda->zone->id }}">{{ $woreda->zone->name }}</option>
                                    @foreach ($zones as $zone)
                                        <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <label>Woreda Quota:</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="qoutaInpercent" value="{{ $woreda->qoutaInpercent*100 }}" id="woreda_quota"/>
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
            $('#zone').select2({
                placeholder: "Select a region"
            });

        });

        var prv_val = $('#woreda_quota').val();
        $("#woreda_quota").on("input", function(){  
            value = $('#zone').val();
              if (value) {
                $.ajax({
                  type: "POST",
                  url: "/woreda/validate",
                //   method: 'post',
                  data: {
                     'zone_id': value,
                     'qouta': $('#woreda_quota').val(),
                     'prv_val':prv_val,
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
        })
    </script>
@endpush