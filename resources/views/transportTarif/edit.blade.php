@extends('layouts.app')
@section('title', 'Edit tarif')
@section('breadcrumb-list')
    <li class="active">Tarif</li>
@endsection
@section('breadcrumbTitle', 'Edit tarif')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Transport tarif </a>
    </li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="card">

                <div class="card-body">

                    <form action="{{ url('transportTarif/'.$transportTarif->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label>Tarif per 1 KM :</label>
                                <input type="text" class="form-control"  required name="price" value="{{ $transportTarif->price }}"/>
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
