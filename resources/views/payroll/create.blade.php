@extends('layouts.app')
@section('title', ' Trainee payroll')
@section('breadcrumb-list')
    <li class=""><a href="{{ route('payrol.index', []) }}">Trainee payrolls </a></li>
    <li class="active"> Create trainee payroll</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ isset($payroll)? route('payroll.update', ['payroll' => $payroll->id]): route('payroll.store', []) }}">
                @csrf
                @isset($payroll)
                    @method('PATCH')
                @endisset
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="name"> Field of Study </label>
                    <div class="col-sm-9">
                        <input type="text" value="{{ old('name') ?? (isset($payroll) ? $payroll->name : '') }}"  id="name" placeholder="Name" name="name" class="col-xs-10 col-sm-5">
                        @error('name')
                            <small class="text-danger"><b>{{ $message }}</b></small>
                        @enderror
                    </div>

                    <div class="col-sm-9">
                        <input type="text" value="{{ old('training_session') ?? (isset($payroll) ? $payroll->training_session : '') }}"  id="name" name="session" class="col-xs-10 col-sm-5">
                        @error('name')
                            <small class="text-danger"><b>{{ $message }}</b></small>
                        @enderror
                    </div>



                </div>
                <button class="btn-sm btn btn-primary btn-rounded btn-floating">
                    <i class="fa fa-plus"></i> {{ isset($payroll) ? 'Update payroll' : 'Add payroll' }}
                </button>
            </form>
        </div>
    </div>
@endsection
