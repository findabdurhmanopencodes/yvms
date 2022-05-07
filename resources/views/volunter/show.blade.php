@extends('layouts.app')
@section('title', 'Edit Zone')
@section('breadcrumb-list')
    <li class="active">Zones</li>
@endsection
@section('breadcrumbTitle', 'Applicant Detail')
@section('breadcrumbList')

    <li class="breadcrumb-item">
        <a href="" class="text-muted">applicant</a>
    </li>
    <li class="breadcrumb-item">
        <a href="" class="text-muted">{{$applicant->first_name}} {{$applicant->father_name}}</a>
    </li>
@endsection

@section('content')
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-body">
                    <!--begin::Details-->
                    <div class="d-flex mb-9">
                        <!--begin: Pic-->
                        <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                            <div class="symbol symbol-50 symbol-lg-120">
                                <img src="{{ asset('assets/media/users/300_1.jpg') }}" alt="image">
                            </div>
                            <div class="symbol symbol-50 symbol-lg-120 symbol-primary d-none">
                                <span class="font-size-h3 symbol-label font-weight-boldest"></span>
                            </div>
                        </div>
                        <!--end::Pic-->
                        <!--begin::Info-->
                        <div class="flex-grow-1">
                            <!--begin::Title-->
                            <div class="d-flex justify-content-between flex-wrap mt-1">
                                <div class="d-flex mr-3">
                                    <a href="#"
                                        class="text-dark-75 text-hover-primary font-size-h5 font-weight-bold mr-3">{{ $applicant->first_name }}
                                        {{ $applicant->father_name }} {{ $applicant->father_grand_name }}</a>
                                    <a href="#">
                                        <i class="flaticon2-correct text-success font-size-h5"></i>
                                    </a>
                                </div>
                                <div class="">

                                        <a href="#" class="btn btn-bg btn-info font-weight-bolder"><i class="fa fa-check"></i>Accept Request</a>

                                        <a href="#" class="btn btn-bg btn-danger font-weight-bolder">Reject Request</a>

                                </div>
                            </div>
                            <!--end::Title-->
                            <!--begin::Content-->
                            <div class="d-flex flex-wrap justify-content-between mt-1">
                                <div class="d-flex flex-column flex-grow-1 pr-8">
                                    <div class="d-flex flex-wrap mb-4">
                                        <a href="#"
                                            class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                            <i
                                                class="flaticon2-new-email mr-2 font-size-lg"></i>{{ $applicant->email }}</a>
                                        <a href="#"
                                            class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                            <i class="flaticon2-phone mr-2 font-size-lg"></i>{{ $applicant->phone }}</a>
                                        <a href="#" class="text-dark-50 text-hover-primary font-weight-bold">
                                            <i
                                                class="flaticon2-placeholder mr-2 font-size-lg"></i>{{ $applicant->woreda->name }},
                                            {{ $applicant->woreda->zone->name }}
                                            {{ $applicant->woreda->zone->region->name }}</a>
                                    </div>

                                </div>

                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Details-->
                    <div class="separator separator-solid"></div>
                    <!--begin::Items-->
                    <div class="d-flex align-items-center flex-wrap mt-8">
                        <!--begin::Item-->
                        <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                            <span class="mr-4">
                                <i class="flaticon-file display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">Gpa</span>
                                <span class="font-weight-bolder font-size-h5">
                                    <span class="text-dark-50 font-weight-bold"></span>{{ $applicant->gpa }}</span>
                            </div>
                        </div>
                        <!--end::Item-->

                    </div>
                    <!--begin::Items-->
                </div>
            </div>
            <!--end::Card-->
            <!--begin::Row-->
            <div class="row">
                <div class="col-lg-12">
                    <!--begin::Advance Table Widget 2-->
                    <div class="card card-custom card-stretch gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">Attached File Of
                                    {{ $applicant->first_name }} {{ $applicant->father_name }}
                                    {{ $applicant->father_grand_name }}</span>
                                <span class="text-muted mt-3 font-weight-bold font-size-sm">For More Detail Info About {{ $applicant->first_name }} {{ $applicant->father_name }}
                                    {{ $applicant->father_grand_name }}</span>
                            </h3>

                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-3 pb-0">
                            <!--begin::Table-->
                            <div class="table-responsive">
                                <table class="table table-borderless table-vertical-center">
                                    <thead>
                                        <tr>
                                            <th class="p-0" style="width: 50px"></th>
                                            <th class="p-0" style="min-width: 200px"></th>
                                            <th class="p-0" style="min-width: 100px"></th>
                                            <th class="p-0" style="min-width: 125px"></th>
                                            <th class="p-0" style="min-width: 110px"></th>
                                            <th class="p-0" style="min-width: 150px"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="pl-0 py-4">
                                                <div class="symbol symbol-50 symbol-light mr-1">
                                                    <span class="symbol-label">
                                                        <img src="{{ asset('assets/media/svg/misc/002-eolic-energy.svg') }}"
                                                            class="h-50 align-self-center" alt="">
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="pl-0">
                                                <a href="#"
                                                    class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">8th
                                                    Grade Ministry File</a>
                                                <div>
                                                    <span class="font-weight-bolder">Size:</span>
                                                    20kb
                                                </div>
                                            </td>

                                            <td class="text-right">
                                                <span class="label label-lg label-light-primary label-inline">Donwload
                                                    File</span>
                                            </td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <!--end::Table-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Advance Table Widget 2-->
                </div>

            </div>
            <!--end::Row-->
            <!--begin::Row-->

            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/pages/crud/forms/widgets/select2.js') }}"></script>
@endpush
