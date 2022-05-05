@extends('layouts.app')
@section('title', 'Regions')
@section('breadcrumb-list')
    <li class="active">Regions</li>
@endsection

@push('css')
    {{-- <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
@endpush

@section('content')
<div class="card card-custom gutter-b">
    <div class="card-header flex-wrap py-3">
        <div class="card-title">
            <h3 class="card-label">Regions
            {{-- <span class="d-block text-muted pt-2 font-size-sm">sorting &amp; pagination remote datasource</span></h3> --}}
        </div>
        <div class="card-toolbar">
            <!--begin::Button-->
            <a href="#" class="btn btn-primary font-weight-bolder">
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
            </span>Add Region</a>
            <!--end::Button-->
        </div>
    </div>
    <div class="card-body">
        <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th class="th-sm">Name
          
                </th>
                <th class="th-sm">Position
          
                </th>
                <th class="th-sm">Office
          
                </th>
                <th class="th-sm">Age
          
                </th>
                <th class="th-sm">Start date
          
                </th>
                <th class="th-sm">Salary
          
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,800</td>
              </tr>
              <tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                <td>2011/07/25</td>
                <td>$170,750</td>
              </tr>
            </tfoot>
          </table>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#dtBasicExample').DataTable();
            $('.dataTables_length').addClass('bs-select');
        });
    </script>
    {{-- <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/crud/datatables/basic/basic.js') }}"></script> --}}
@endpush