@extends('layouts.app')
@section('title', 'Edit payment type')
@section('breadcrumb-list')
    <li class="active">  payment type </li>
@endsection
@section('breadcrumbTitle', ' payment type-edit')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted"> Edit payment type</a>
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
                        <a href="{{ route('paymentType.index') }}" class="btn btn-primary float-right">Close</a>
                    </h6>
                </div>
                <div class="card-body">

                    <form action="{{ url('paymentType/'.$paymentType->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label> Payment type:</label>
                                <input type="text" class="form-control" name="name" value="{{ $paymentType->name }}"/>
                            </div>
                            <div class="col-lg-6">
                                <label>Payment amount :</label>
                                <input type="text" class="form-control" name="amount" value="{{ $paymentType->amount }}"/>
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

