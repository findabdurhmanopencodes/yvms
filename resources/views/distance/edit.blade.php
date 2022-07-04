@extends('layouts.app')
@section('title', 'Edit Distance')
@section('breadcrumb-list')
    <li class="active"> Distance
@endsection
@section('breadcrumbTitle', ' Edit Distance')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted"> Edit Distance</a>
    </li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

             @if( $errors->any())
                <h6 class="alert alert-danger"></h6>

                <ul>
                    @foreach ($errors->all()  as $error )
                    <li> {{ $error }}</li>

                    @endforeach


                </ul>
            @endif

            <div class="card">
                <div class="card-header">
                    <h6>
                        <a href="{{ route('distance.index') }}" class="btn btn-primary float-right">Close</a>
                    </h6>
                </div>
                <div class="card-body">

                    <form action="{{ url('distance/'.$distance->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label><b>Training center:     <span>     <i class=" fa fa-arrow-right"></i></span> </b></label>
                               <br> <input type="text"  title="You cannot edit this" disabled  class="form-control" name="trainining_center_id" value="{{ $distance->traininingCenter->name }}"/>
                            </div>

                            <div class="col-lg-4">
                                <label><b>Killo Meter(Editable)</b> </label>
                           <br> <input type="text" title="You can edit this"  class="form-control" name="km" value="{{ $distance->km }}"/>
                            </div>


                            <div class="col-lg-4">
                                <label> <b> <span>     <i class=" fa fa-arrow-left"></i></span> Zone: </b>   </label>
                                <br><input type="text" disabled  title="You cannot edit this"  class="form-control" name="zone_id" value="{{ $distance->zone->name}}"/>
                            </div>
                        </div>


                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary pull-right">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

