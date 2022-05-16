@extends('layouts.app')
@section('title', 'Training Session Detail')
@section('breadcrumbTitle', 'Training Session Detail')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="{{ route('training_session.index', []) }}">All Training Sessions</a>
    </li>
    <li class="breadcrumb-item">Detail</li>

@endsection
@push('js')
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('assets/js/pages/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/pages/custom/profile/profile.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#gender').select2({
                placeholder: "Select a Gender"
            });
            $('#disablity_id').select2({
                placeholder: "Select a disablity Status "
            });
            $('#region_id').select2({
                placeholder: "Select a Region"
            });
            $('#zone_id').select2({
                placeholder: "Select a Zone"
            });
            $('#woreda_id').select2({
                placeholder: "Select Woreda "
            });

        });
    </script>
    <!--end::Page Scripts-->~
@endpush
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
    <div class="accordion accordion-solid accordion-toggle-plus " id="accordionExample6">

        <div class="card ">
            <div id="headingThree6" class="card-header text-white" style="background-color: rgba(15, 69, 105, 0.6);">
                <div class="card-title collapsed text-white" data-toggle="collapse" data-target="#collapseThree6"
                    style="background-color: rgba(15, 69, 105, 0.6);">
                    <i class="flaticon2-search fa-2x text-white"></i> Filter Applicants
                </div>
            </div>
            <div id="collapseThree6" class="collapse" data-parent="#accordionExample6">
                <div class="card-body">

                    <form action="{{ route('session.applicant.index', ['training_session' => Request::route('training_session')]) }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="name" class=" col-sm-12 col-form-label">First Name</label>
                                <input class="form-control" type="text" name="first_name" id="name">

                            </div>
                            <div class="col-sm-4">
                                <label for="father_name" class=" col-sm-12 col-form-label">Middle Name</label>
                                <input class="form-control" type="text" name="father_name" id="father_name">

                            </div>
                            <div class="col-sm-4">
                                <label for="grand_father_name" class=" col-sm-12 col-form-label">Last Name</label>
                                <input class="form-control" type="text" name="grand_father_name" id="grand_father_name">

                            </div>
                            <div class="col-sm-4">
                                <label for="email" class=" col-sm-12 col-form-label">Email</label>
                                <input class="form-control" type="text" name="email" id="email">

                            </div>

                            <div class="col-sm-4">
                                <label for="gender" class=" col-sm-12 col-form-label">Gender</label>
                                <br>
                                <select class="form-control select2" id="gender" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="disablity_id" class=" col-sm-12 col-form-label">Disablity </label>
                                <br>
                                <select class="form-control select2" id="disablity_id" name="disablity_id">
                                    <option value="">Select Disablity Status</option>
                                    @foreach ($disabilities as $disability)
                                        <option value="{{ $disability->id }}">{{ $disability->name }}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-sm-4">
                                <label for="phone" class=" col-sm-12 col-form-label">Phone Number</label>
                                <input class="form-control" type="text" name="phone" id="phone">
                            </div>

                            <div class="col-sm-4">
                                <label for="region_id" class=" col-sm-12 col-form-label">Region</label>
                                <select class="form-control select2" id="region_id" name="region_id">
                                    <option value="">Select region</option>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region->id }}">{{ $region->name }} ({{ $region->code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="zone_id" class=" col-sm-12 col-form-label">Zone</label>
                                <select class="form-control select2" id="zone_id" name="zone_id">
                                    <option value="">Select Zone</option>
                                    @foreach ($zones as $zone)
                                        <option value="{{ $zone->id }}">{{ $zone->name }} ({{ $zone->code }})
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label for="gpa" class=" col-sm-12 col-form-label">Woreda</label>
                                <select class="form-control select2" id="woreda_id" name="woreda_id">
                                    <option value="">Select Woreda</option>
                                    @foreach ($woredas as $woreda)
                                        <option value="{{ $woreda->id }}">{{ $woreda->name }} ({{ $woreda->code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="col-sm-4">
                                <label for="gpa" class=" col-sm-12 col-form-label">G.p.A</label>
                                <input class="form-control" type="number" name="gpa" id="gpa" min="2" max="4">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary  mx-4 my-4" name="filter" value="filter"><i
                                class="fa fa-search"></i> Search</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <div class="card card-custom">
        @if ($errors->any())
            <div class="alert alert-danger">
                <p><strong>Opps Something went wrong</strong></p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Applicants
                    <span class="d-block text-muted pt-2 font-size-sm">All Applicants In
                        {{ $trainingSession?->moto }}</span>
                </h3>


            </div>

        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <div class="datatable datatable-default datatable-bordered datatable-loaded">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Woreda</th>
                            <th>status</th>
                            <th> Actions</th>

                        </tr>
                    </thead>
                    <tbody style="" class="datatable-body">

                        @foreach ($volunters as $volunter)
                        <tr data-row="0" class="datatable-row" style="left: 0px;">
                            <td>
                                {{ $volunters->perPage() * $volunters->currentPage() - ($volunters->perPage() - ($loop->index + 1)) }}
                            </td>
                            <td>
                                {{ $volunter->first_name }} {{ $volunter->father_name }}
                            </td>
                            <td>
                                {{ $volunter->gender }}
                            </td>
                            <td>
                                {{ $volunter->phone }}
                            </td>

                            <td>
                                {{ $volunter->woreda?->name }}
                            </td>
                            <td>
                                <span
                                    class="badge badge-warning badge-pill">{{ $volunter->status?->acceptance_status == 0 ? 'pending' : 'decided' }}</span>
                            </td>
                            <td>
                                <div class="row">
                                    <a class="btn btn-sm btn-info"
                                        href="{{ route('session.applicant.show', ['training_session'=>Request::route('training_session'),'applicant' => $volunter->id]) }}">
                                        <i class="fa fa-sm fa-eye"></i> Detail</a>
                                </div>

                            </td>
                        </tr>
                        @endforeach
                        @if (count($volunters) < 1)
                            <tr>
                                <td class="text-capitalize text-danger font-size-h4">No Applicants Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {!! $volunters->links() !!}
                </div>
            </div>
            <!--end: Datatable-->
        </div>
    </div>

@endsection
