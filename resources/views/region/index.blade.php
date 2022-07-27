@extends('layouts.app')
@section('title', 'All Regions/City Administrations')
@section('breadcrumb-list')
    <li class="active">Regions/City Administrations</li>
@endsection
@section('breadcrumbTitle', 'Regions')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Regions/City Administrations</a>
    </li>
@endsection
@push('js')
    <script> 
        var COLUMNS = [{
                field: 'id',
                title: '#',
                sortable: 'asc',
                width: 30,
                type: 'number',
                selector: false,
                textAlign: 'center',
                template: function(row, index) {
                    return index + 1;
                }
            },
            {
                field: 'name',
                title: 'Name',
                sortable: 'asc',
            },
            {
                field: 'qoutaInpercent',
                title: 'Quata',
                sortable: 'asc',
            },
            {
                field: 'code',
                title: 'Code',
                sortable: 'asc',
            },
            {
                field: 'Actions',
                title: 'Actions',
                sortable: false,
                width: 100,
                overflow: 'visible',
                autoHide: false,
                template: function(row) {
                    var regionId = row.id;
                    return '\
                                    <div class="d-flex">\
                                                <a href="javascript:;" onclick="deleteRegion(' + regionId + ',$(this))" class="btn btn-sm btn-clean btn-icon" >\
                                                    <i class="far fa-trash"></i>\
                                                </a>\
                                                \
                                                <a href="/region/' + regionId + '/edit" class="btn btn-sm btn-clean btn-icon" >\
                                                    <i class="far fa-pen"></i>\
                                                </a>\
                                                @if($trainingSession_id!=null)
                                                <a href="'+{{ $trainingSession_id }}+'/'+regionId+'/region/capacity" class="btn btn-sm btn-clean btn-icon" >\
                                                    <i class="far fa-eye"></i>\
                                                </a>\
                                                \
                                                @endif
                                            </div>\
                                            ';
                         },
            }
        ]
        var HOST_URL = "{{ route('region.index') }}";

        function deleteRegion(regionId, parent) {
            event.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: '/region/' + regionId,
                        data: {
                            "id": regionId,
                            "_method": 'DELETE',
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        dataType: 'json',
                        success: function(data) {
                            $(parent).closest('tr')[0].remove();
                            Swal.fire(
                                "Deleted!",
                                "Region/City Administration has been deleted.",
                                "success"
                            )
                        },
                        error: function(data) {
                            if (data.status) {
                                Swal.fire("Forbidden!", "You can't delete this region/city administration!", "error");
                            }
                        }
                    });
                }
            });
        }
    </script>
    <script>
        $( document ).ready(function() {

        });
        
        $("#reg_quota").on("input", function(){
            if ($("#reg_quota").val() >= 0) {
                $.ajax({
                  type: "POST",
                  url: "/region/validate",
                //   method: 'post',
                  data: {
                     'qouta': $('#reg_quota').val(),
                     "_token": $('meta[name="csrf-token"]').attr('content'),
                  },
                  success: function(result){
                      if (result.limit == false) {
                          $('#message').html('you reached max qouta');
                          $(":submit").attr("disabled", true);
                      }else{
                        $('#message').html('');
                        $(":submit").removeAttr("disabled");
                      }
                  },
             });
            } else {
                $('#message').html('Invalid Number!!!');
                $(":submit").attr("disabled", true);
            }
           })
    </script>
    <script src="{{ asset('assets/js/pages/crud/ktdatatable/base/data-ajax.js') }}"></script>
@endpush
@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <div class="input-icon">
                    <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                    <span>
                        <i class="flaticon2-search-1 text-muted"></i>
                    </span>
                </div>
                {{-- <h3 class="card-label">List of regions/city adminstration
                    <span class="text-muted pt-2 font-size-sm d-block">Regions/City Administartion</span>
                </h3> --}}
            </div>
            <div class="card-toolbar">

                <!--begin::Button-->
                @can('Region.store')
                    <a href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#exampleModal">
                        <span class="svg-icon svg-icon-md">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                            <i class="fal fa-plus"></i>
                            <!--end::Svg Icon-->
                    </span>
                    Add New Region/City Adminstration</a>
                @endcan
                <form method="POST" action="{{ route('region.store', []) }}">
                        @csrf
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg"  role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add new Region/City Adminstrtion</h5>
                                        <button type="button" class="close" data-dismiss="modal" -label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card-body">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="col-lg-6">
                                                        <label>Region/City Adminstration Name:</label>
                                                        <input type="text" class="form-control" placeholder="region/city adminstration name" name="name"/>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>Region/City Adminstration Code:</label>
                                                        <input type="text" class="form-control" placeholder="region code" name="code"/>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-6">
                                                        <label>Region/City Adminstration Quota(%):</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" placeholder="Region/City Adminstration Quota in percent" name="region_quota" id="reg_quota" min="0"/>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                        </div>
                                                        <small class="text-danger"><b id="message"></b></small>
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
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
            <!--end: Datatable-->
        </div>
    </div>
    <!--end::Card-->
    {{-- <div class="py-2 pr-4">
        <a href="{{ route('role.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add Role</a>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"></h3>
        </div>
        <div class="p-0 card-body">
            <table class="table table-striped table-bordered table-hover dataTable no-footer table-striped projects">
                <thead>
                    <tr>
                        <th style="width: 1%">
                            #
                        </th>
                        <th style="width: 20%">
                            Name
                        </th>
                        <th style="width: 20%">
                            Created at
                        </th>
                        <th style="width: 10%">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $key => $role)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <a>{{ $role->name }}</a>
                            </td>
                            <td>{{ $role->created_at }}</td>
                            <td class="text-right project-actions">
                                <a class="btn btn-sm  btn-primary" href="{{ route('role.show', ['role' => $role->id]) }}">
                                    <i class="fa fa-eye">
                                    </i>
                                </a>
                                <a class="btn btn-sm  btn-primary" href="{{ route('role.edit', ['role' => $role->id]) }}">
                                    <i class="fa fa-pencil">
                                    </i>
                                </a>
                                <a class="btn btn-danger btn-sm" href="#" onclick="deleteRole({{ $role->id }},this);">
                                    <i class="fa fa-trash">
                                    </i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    @empty($roles)
                        <tr>
                            <td colspan="3">
                                <b>Roles not found</b>
                            </td>
                        </tr>
                    @endempty
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div> --}}
@endsection
