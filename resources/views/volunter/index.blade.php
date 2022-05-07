@extends('layouts.app')
@section('content')
    <div class="accordion accordion-solid accordion-toggle-plus " id="accordionExample6">

        <div class="card ">
            <div id="headingThree6" class="card-header text-white" style="background-color: rgba(15, 69, 105, 0.6);">
                <div class="card-title collapsed text-white" data-toggle="collapse" data-target="#collapseThree6"
                    style="background-color: rgba(15, 69, 105, 0.6);">
                    <i class="flaticon2-search fa-2x text-white"></i> Filter Branches
                </div>
            </div>
            <div id="collapseThree6" class="collapse" data-parent="#accordionExample6">
                <div class="card-body">
                    <form action="">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="name" class=" col-sm-12 col-form-label">Name</label>
                                <input class="form-control" type="text" name="name" id="name">

                            </div>
                            <div class="col-sm-4">
                                <label for="code" class=" col-sm-12 col-form-label">Code</label>
                                <input class="form-control" type="text" name="code" id="code">

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
                <h3 class="card-label">Branch
                    <span class="d-block text-muted pt-2 font-size-sm">All Branches In Organization</span>
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
                            <th>Name</th>
                            <th>Code</th>
                            <th>Description</th>
                            <th> Actions</th>

                        </tr>
                    </thead>
                    <tbody style="" class="datatable-body">

                        @foreach ($volunters as $volunters)
                            <tr data-row="0" class="datatable-row" style="left: 0px;">
                                <td>
                                    {{ $volunters->perPage() * $volunters->currentPage() - ($volunters->perPage() - ($loop->index + 1)) }}
                                </td>

                                <td>
                                    <div class="row">
                                        <a class="btn btn-sm btn-info" href="{{ route('volunter.show', $volunter->id) }}">
                                            <i class="fa fa-edit"></i> Detail</a>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        @if (count($volunters) < 1)
                            <tr>
                                <td class="text-capitalize text-danger font-size-h1">No Volunters Found</td>
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
