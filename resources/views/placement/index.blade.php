
@extends('layouts.app')
@section('title', 'All Regions')
@section('breadcrumb-list')
    <li class="active">Regions</li>
@endsection
@section('breadcrumbTitle', 'Regions')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Regions</a>
    </li>
@endsection

@push('js')
   
    <script src="{{ asset('assets/js/pages/crud/ktdatatable/base/data-ajax.js') }}"></script>
@endpush
@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">List of regions
                    <span class="text-muted pt-2 font-size-sm d-block">Regions</span>
                </h3>
            </div>
            <div class="card-toolbar">

                <!--begin::Button-->
                <a href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#exampleModal">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <i class="fal fa-plus"></i>
                        <!--end::Svg Icon-->
                    </span>Add New Region</a>

                  
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
          <table border="1">
            <tr>
              <th>Region</th>
              
              <th>Tigray</th>
               <th>Afar</th>
              <th>Tigray</th>
              <th>Afar</th>
              <th>Tigray</th>
              <th>Afar</th>
              <th>Tigray</th>
              <th>Afar</th>
            </tr>
            <tr>
              <td rowspan = "2"> Tigray</td>
              <td>Advanced Web</td>
              <td>75</td>
            </tr>
            <tr>
              <td rowspan = "2"> Tigray</td>
              <td>Advanced Web</td>
              <td>75</td>
            </tr>
            <tr>
              <td rowspan = "2"> Tigray</td>
              <td>Advanced Web</td>
              <td>75</td>
            </tr>
            <tr>
              <td rowspan = "2"> Tigray</td>
              <td>Advanced Web</td>
              <td>75</td>
            </tr>
            <tr>
              <td rowspan = "2"> Tigray</td>
              <td>Advanced Web</td>
              <td>75</td>
            </tr>
            <tr>
              <td rowspan = "2"> Tigray</td>
              <td>Advanced Web</td>
              <td>75</td>
            </tr>
            <tr>
              <td rowspan = "2"> Tigray</td>
              <td>Advanced Web</td>
              <td>75</td>
            </tr>
            <tr>
              <td>Operating Syatem</td>
              <td>60</td>
            </tr>
                <tr>
              <td rowspan = "2"> Afar</td>
              <td>Advanced Web</td>
              <td>80</td>
            </tr>
            <tr>
              <td>Operating Syatem</td>
              <td>75</td>
            </tr>
            <tr>
               <td></td>
              <td colspan="3">Total Average: 72.5</td>
            </tr>
          </table>
            <!--begin: Datatable-->
            <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
            <!--end: Datatable-->
        </div>
    </div>
 
@endsection