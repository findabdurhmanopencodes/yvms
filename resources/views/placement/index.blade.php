@extends('layouts.app')
@section('title', 'Placement')
@section('breadcrumb-list')
    <li class="active">Regions</li>
@endsection
@section('breadcrumbTitle', 'Placement')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Placement</a>
    </li>
@endsection

@push('js')
    <script src="{{ asset('assets/js/pages/crud/ktdatatable/base/data-ajax.js') }}"></script>
@endpush
{{--  --}}
@section('content')
    <!--begin::Card-->
    <div class="card card-custom card-body mb-3">
        <form action="" method="GET">
            <div class=" ml-0 col-12 p-0">
                <div class="row ">
                    <div class="form-group col-3">
                        <select name="region" id="" class="form-control select2">
                            <option value="">Select Region</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}" @if (Request::get('region') == $region->id) selected @endif>
                                    {{ $region->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <select name="zone" id="" class="form-control select2">
                            <option value="">Select Zone</option>
                            @foreach ($zones as $zone)
                                <option value="{{ $zone->id }}" @if (Request::get('zone') == $zone->id) selected @endif>
                                    {{ $zone->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <select name="woreda" id="" class="form-control select2">
                            <option value="">Select Woreda</option>
                            @foreach ($woredas as $woreda)
                                <option value="{{ $woreda->id }}" @if (Request::get('woreda') == $woreda->id) selected @endif>
                                    {{ $woreda->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <select name="training_center" id="" class="form-control select2">
                            <option value="">Select Training Center</option>
                            @foreach ($training_centers as $training_center)
                                <option value="{{ $training_center->id }}"
                                    @if (Request::get('training_center') == $training_center->id) selected @endif>{{ $training_center->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary btn-block"> Filter</button>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="trainingCenterEdit" tabindex="-1" role="dialog" aria-labelledby="trainingCenterEdit"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                {{-- <form action="/trh" method="POST"> --}}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Change Training Center</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="changePlacementForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="training_center" class="font-weight-bold">Training Center</label>
                            <select name="training_center_capacity_id" id="training_center_capacity_id"
                                class="form-control select2" style="width: 100%">
                                @foreach ($trainingCenterCapacities as $trainingCenterCapacity)
                                    <option value="{{ $trainingCenterCapacity->id }}">
                                        {{ $trainingCenterCapacity->trainingCenter->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Save Changes" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form id="approvePlacmentForm"
        action="{{ route('session.placment.approve', [request()->route('training_session')]) }}" method="POST">
        @csrf
    </form>

    <div class="card card-custom">
        <div class="card-header flex-wrap  pt-6 ">
            <div class="card-title mr-0">
                <h3 class="card-label"> Volunteer Placement </h3>
            </div>
            <div class="card-toolbar">
                <div class="d-flex">
                    <a class="btn btn-sm btn-info"
                        href="{{ route('session.placement.reset', [request()->route('training_session')]) }}">
                        <i class="fal fa-recycle"></i> Reset
                    </a>
                    <a class="btn ml-4 btn-sm btn-success" onclick="approvePlacment()" href="#">
                        <i class="fal fa-stamp"></i> Approve placment
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table width="100%" class="table table-striped ">
                <thead>
                    </tr>
                    <th> #</th>
                    <th> Name </th>
                    {{-- <th> Middle Name </th> --}}
                    <th> Region </th>
                    <th> Training Center </th>
                    <th> Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($placedVolunteers as $key => $placedVolunteer)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $placedVolunteer->approvedApplicant->volunteer->name() }}</td>
                            {{-- <td>{{ $placedVolunteer->approvedApplicant->volunteer->father_name }}</td> --}}
                            {{-- <td> {{ $placedVolunteer->approvedApplicant->volunteer->grand_father_name }} </td> --}}
                            <td> {{ $placedVolunteer->approvedApplicant->volunteer->woreda->zone->region->name }} </td>
                            <td> {{ $placedVolunteer->trainingCenterCapacity->trainingCenter->name }} </td>
                            <td>
                                <a href="#"
                                    data-action="{{ route('session.placement.change', [request()->route('training_session'), $placedVolunteer->id]) }}"
                                    class="btn btn-icon"
                                    onclick="$('#changePlacementForm').attr('action',this.dataset.action);onSubmit();">
                                    <span class="fa fa-edit"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex" style="justify-content: space-between;">
            <div class="">
                <span class="mr-5">Total: {{ $placedVolunteers->total() }}</span>
                <span>Page {{ $placedVolunteers->currentPage() > 0 ? $placedVolunteers->currentPage() : 0 }} of
                    {{ ceil($placedVolunteers->total() / $placedVolunteers->perPage()) }}</span>
            </div>
            <div class="">
                {{ $placedVolunteers->withQueryString()->links() }}
            </div>
        </div>

    </div>

@endsection
@push('js')
    <script>
        $('.select2').select2({});
    </script>

    <script>
        function onSubmit() {

            // require false;
            event.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "This Will change the training center of the Volunteer!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Change it!"
            }).then(function(result) {
                if (result.value) {
                    $('#trainingCenterEdit').modal();
                }
            });
        }

        function approvePlacment() {
            event.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "This action will not be reverted!",
                type: "danger",
                showCancelButton: true,
                confirmButtonText: "Yes, Approve!"
            }).then(function(result) {
                if (result.value) {
                    $('#approvePlacmentForm').submit();
                }
            });
        }
    </script>
@endpush
