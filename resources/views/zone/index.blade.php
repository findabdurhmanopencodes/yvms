@extends('layouts.app')
@section('title', 'Zones')
@section('breadcrumb-list')
    <li class="active">Zones</li>
@endsection

@push('css')
    {{-- <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
@endpush

@section('content')
<div class="card card-custom gutter-b">
    <form method="POST" action="{{ route('zone.store', []) }}">
        @csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg"  role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add new Zone</h5>
                        <button type="button" class="close" data-dismiss="modal" -label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Zone Name:</label>
                                        <input type="text" class="form-control" placeholder="zone name" name="name"/>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Zone Code:</label>
                                        <input type="text" class="form-control" placeholder="zone code" name="code"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Region:</label>
                                        <br>
                                        <select class="form-control select2" id="kt_select2_1" name="region">
                                            <option value=""></option>
                                            @foreach ($regions as $region)
                                                <option value="{{ $region->id }}">{{ $region->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="card-header flex-wrap py-3">
        <div class="card-title">
            <h3 class="card-label">Zones
            {{-- <span class="d-block text-muted pt-2 font-size-sm">sorting &amp; pagination remote datasource</span></h3> --}}
        </div>
        <div class="card-toolbar">
            <!--begin::Button-->
            <a href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#exampleModal">
            <span class="svg-icon svg-icon-md">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <circle fill="#000000" cx="9" cy="15" r="6" />
                        <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>Add Zone</a>
            <!--end::Button-->
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-class" id= "table-id">
  
            <thead>
              <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Code</th>
                  <th>Region</th>
                  <th>Actions</th>
              </tr>
              
            </thead>
            <tbody>
                @foreach ($zones as $key => $zone)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $zone->name }}</td>
                        <td>{{ $zone->code }}</td>
                        {{-- <td>{{ $region->region()->name }}</td> --}}
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('assets/js/pages/crud/forms/widgets/select2.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#dtBasicExample').DataTable();
        $('.dataTables_length').addClass('bs-select');
    });
</script>
    {{-- <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/crud/datatables/basic/basic.js') }}"></script> --}}
@endpush