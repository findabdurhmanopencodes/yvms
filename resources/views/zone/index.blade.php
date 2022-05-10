@extends('layouts.app')
@section('title', 'All Zones')
@section('breadcrumb-list')
    <li class="active">Zones</li>
@endsection
@section('breadcrumbTitle', 'Zones')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Zones</a>
    </li>
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
@push('js')
    <script>
        var HOST_URL = "{{ route('zone.index') }}";

        function deleteZone(zoneId, parent) {
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
                        url: '/zone/' + zoneId,
                        data: {
                            "id": zoneId,
                            "_method": 'DELETE',
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        dataType: 'json',
                        success: function(data) {
                            $(parent).closest('tr')[0].remove();
                            Swal.fire(
                                "Deleted!",
                                "Role has been deleted.",
                                "success"
                            )
                        },
                        error: function(data) {
                            if (data.status) {
                                Swal.fire("Forbidden!", "You can't delete this role!", "error");
                            }
                        }
                    });
                }
            });
        }
    </script>
    <script>
        $( document ).ready(function() {
            $('#region').select2({
                placeholder: "Select a region"
            });

        });

        $("#zon_quota").on("input", function(){  
            value = $('#region').val();
              if (value) {
                $.ajax({
                  type: "POST",
                  url: "/zone/validate",
                //   method: 'post',
                  data: {
                      'region_id': value,
                     'qouta': $('#zon_quota').val(),
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
              }
        })
        
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
                field: 'code',
                title: 'Code',
                sortable: 'asc',
            },
            {
                field: 'region',
                title: 'Region',
                sortable: 'asc',
                // template: function(row) {
                //     console.log(row);
                //     return row.region_id;
                // }
            },
            {
                field: 'Actions',
                title: 'Actions',
                sortable: false,
                width: 100,
                overflow: 'visible',
                autoHide: false,
                template: function(row) {
                    var zoneId = row.id;
                    return '\
                                    <div class="d-flex">\
                                                <a href="javascript:;" onclick="deleteZone(' + zoneId + ',$(this))" class="btn btn-sm btn-clean btn-icon" >\
                                                    <i class="far fa-trash"></i>\
                                                </a>\
                                                \
                                                <a href="/zone/' + zoneId + '/edit" class="btn btn-sm btn-clean btn-icon" >\
                                                    <i class="far fa-pen"></i>\
                                                </a>\
                                                \
                                            </div>\
                                            ';
                },
            }
        ];
    </script>
    <script src="{{ asset('assets/js/pages/crud/ktdatatable/base/data-ajax.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/pages/crud/forms/widgets/select2.js') }}"></script> --}}
@endpush
@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">List of zones
                    <span class="text-muted pt-2 font-size-sm d-block">Zones</span>
                </h3>
            </div>
            <div class="card-toolbar">

                <!--begin::Button-->
                <a href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#exampleModal">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <i class="fal fa-plus"></i>
                        <!--end::Svg Icon-->
                    </span>Add New Zone</a>

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
                                                        <input type="text" class="form-control" placeholder="zone name" name="name" required/>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>Zone Code:</label>
                                                        <input type="text" class="form-control" placeholder="zone code" name="code" required/>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-lg-6">
                                                        <label>Region:</label>
                                                        <br>
                                                        <select class="form-control select2" id="region" name="region" required>
                                                            <option value=""></option>
                                                            @foreach ($regions as $region)
                                                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>Zone Quota:</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" placeholder="Zone quota in percent" name="zone_quota" id="zon_quota"/>
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
