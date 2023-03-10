@extends('layouts.app')
@section('title', 'Edit Volunteer')
@section('breadcrumb-list')
    <li class="active">Edit Volunteer</li>
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
            <form action="{{ route('session.applicant.update', ['applicant'=>$volunteer->id, 'training_session'=>Request::route('training_session')->id]) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="card">
                    <div class="card-header">
                        <h4>Edit & Update Volunteers
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>First name:</label>
                                    <input type="text" class="form-control" name="first_name" value="{{ $volunteer->first_name }}" required/>
                                </div>
                                <div class="col-lg-4">
                                    <label>Middle name:</label>
                                    <input type="text" class="form-control" name="middle_name" value="{{ $volunteer->father_name }}" required/>
                                </div>
                                <div class="col-lg-4">
                                    <label>Last name:</label>
                                    <input type="text" class="form-control" name="last_name" value="{{ $volunteer->grand_father_name }}" required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Phone number:</label>
                                    <input type="text" class="form-control" name="phone" value="'{{ $volunteer->phone }}"/>
                                </div>
                                <div class="col-lg-6">
                                    <label>E-mail:</label>
                                    <input type="email" class="form-control" name="email" value="{{ $volunteer->email }}" required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>Gender:</label>
                                    <select name="gender" class="form-control" required>
                                        <option value="">select gender</option>
                                        <option value="M" {{ $volunteer->gender == 'M' ? 'selected' : '' }}>Male</option>
                                        <option value="F" {{ $volunteer->gender == 'F' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label>Educational level:</label>
                                    <select name="education_level" class="form-control" required>
                                        <option value="">Select Educational Level</option>
                                        @foreach ($educational_levels as $key=>$educational_level)
                                            <option value="{{ $key }}" {{ $volunteer->educational_level == $key ? 'selected' : '' }}>{{ $educational_level }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label>Gpa:</label>
                                    <input type="text" class="form-control" name="gpa" value="{{ $volunteer->gpa }}" required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>Field of study:</label>
                                    <select name="Field of study" class="form-control" required>
                                        <option value="">Select field of study</option>
                                        @foreach ($field_of_studies as $field_of_study)
                                            <option value="{{ $field_of_study->id }}" {{ $volunteer->field_of_study_id == $field_of_study->id ? 'selected' : '' }}>{{ $field_of_study->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary float-right" type="submit">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
    {{-- <script src="{{ asset('assets/js/pages/crud/forms/widgets/select2.js') }}"></script> --}}
@endpush