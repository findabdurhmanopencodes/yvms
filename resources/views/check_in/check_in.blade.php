@extends('layouts.app')
@section('title', 'All Zones')
@section('breadcrumb-list')
    <li class="active">Check-in Student</li>
@endsection
@section('breadcrumbTitle', 'Zones/Subcities')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Zones/Subcities</a>
    </li>
@endsection




@section('content')
    <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample6">

        <div class="card">
            <div class="card-header" id="headingThree6">
                <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseThree6">
                    <i class="flaticon2-search fa-2x"></i> Filter
                </div>
            </div>
            <div id="collapseThree6" class="collapse" data-parent="#accordionExample6">
                <div class="card-body">
                    <form method="post">
                        @csrf
                        <div class="row">

                            <div class="col-4">
                                <label for="location_id" class=" col-4 col-form-label">Lab name</label>
                                <input class="form-control" type="text" name="name">

                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary  mx-4 my-4" name="filter" value="filter"><i
                                class="fa fa-search"></i> Search</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <ol class="breadcrumb text-muted fs-6 fw-bold">


        {{-- @if (count($offices) > 1)
            <li class="breadcrumb-item pe-3"><a href="{{ route('lab.structureDetail', $parent_id) }}"
                    class="pe-3">{{ $offices[0]?->parent->name }}</a></li>
        @endif --}}


    </ol>


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
                <h3 class="card-label">Structures
                    <span class="d-block text-muted pt-2 font-size-sm"></span>
                </h3>
            </div>

        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <div class="datatable datatable-default datatable-bordered datatable-loaded">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th> Name</th>
                            <th>Code</th>
                            <th> Actions</th>

                        </tr>
                    </thead>
                    <tbody style="" class="datatable-body">
                        {{-- @foreach ($offices as $office)
                            <tr data-row="0" class="datatable-row" style="left: 0px;">
                                <td>
                                    {{ $offices->perPage() * $offices->currentPage() - ($offices->perPage() - ($loop->index + 1)) }}
                                </td>
                                <td>{{ $office->name }}</td>
                                <td>{{ $office->code }}</td>
                                <td>
                                    <div class="row">
                                        @if ($office->labs !== null)
                                            <a class="btn nbtn-sm btn-info mx-4"
                                                href="{{ route('lab.office', $office->id) }}">
                                                <i class="fa fa-eye "></i> Show Lab</a>
                                        @else
                                            <a class="btn nbtn-sm btn-info mx-4"
                                                href="{{ route('lab.structureDetail', $office->id) }}">
                                                <i class="fa fa-eye "></i> detail</a>
                                        @endif

                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        @if (count($offices) < 1)
                            <tr>
                                <td class="font-size-h1-sm text-danger">No Result Found</td>
                            </tr>
                        @endif --}}
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{-- {!! $offices->links() !!} --}}
                </div>
            </div>
            <!--end: Datatable-->
        </div>
    </div>
@endsection
@section('additional_javascript')
    <script>
        // Class definition
        var KTSelect2 = function() {
            // Private functions
            var demos = function() {
                // multi select
                $('.select2').select2({
                    placeholder: "select Organization",
                    width: '100%'

                });
            }
            return {
                init: function() {
                    demos();
                }
            };
        }();

        // Initialization
        jQuery(document).ready(function() {
            KTSelect2.init();
        });
    </script>
@endsection
