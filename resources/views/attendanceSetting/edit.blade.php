@extends('layouts.app')
@section('title', 'Edit Attedance Setting')
@section('breadcrumb-list')
    <li class="active">Attedance Setting </li>
@endsection
@section('breadcrumbTitle', 'Edit Attedance Setting')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Attedance Setting  </a>
    </li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="card">

                <div class="card-body">

                    <form action="{{ url('attendanceSetting/'.$attendanceSetting->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label> Minimum days </label>
                                <input type="number" class="form-control"  min="1"  max="30" required name="days" value="{{ $attendanceSetting->days }}"/>
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
