@extends('layouts.app')
@section('title', 'Resource Assignment')

@section('breadcrumbTitle', 'Resource Assignment')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted"></a>
    </li>
@endsection
@section('content')
    <!--begin::Card-->
    <div class="card card-custom card-body mb-3">
        <form
            action="{{ route('session.resource.assign.volunteer', ['training_session' => Request::route('training_session'), 'training_center_id' => $training_center_id]) }}"
            method="post">
            @csrf
            <div class=" ml-0 col-12 p-0">
                <div class="row ">

                    <div class="form-group col-6">
                        <label for="gender" class=" col-sm-12 col-form-label">Id Number</label>
                        <input class="form-control " placeholder="search by Id Number" name="id_number">
                    </div>
                    <div class="form-group col-6">
                        <label for="gender" class=" col-sm-12 col-form-label">Gender</label>
                        <br>
                        <select class="form-control select2" id="gender" name="gender">
                            <option value="">Select Gender</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                </div>
            </div>
            <div>
                <button class="btn btn-primary btn-block col-sm-2   " name="filter" type="filter" value="filter">
                   <i class="fa fa-search"></i> Find</button>
            </div>
        </form>
    </div>
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">volunteers
                    <span class="text-muted pt-2 font-size-sm d-block"> </span>
                </h3>
            </div>

        </div>
        <div class="card-body">
            <table class="table" width="100">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($volunteers as $key => $volunteer)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $volunteer->name() }}</td>
                            <td>{{ $volunteer->phone }}</td>
                            <td>{{ $volunteer->gender }}</td>
                            <td><a class="btn btn-primary"
                                    href="{{ route('session.resource.assign.volunteer.detail', ['training_session' => Request::route('training_session'), 'training_center_id' => $training_center_id, 'volunteer' => $volunteer->id]) }}">Give
                                    Resource</a>
                            </td>
                        </tr>
                    @endforeach
                    @if (count($volunteers) < 1)
                        <tr>
                            <td class="text-capitalize text-danger font-size-h4">No Volunteers Found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{-- {!! $volunters->links() !!} --}}
            </div>

        </div>
    </div>

@endsection
@push('js')
    <script>
        $('.select2').select2({});
    </script>
@endpush
