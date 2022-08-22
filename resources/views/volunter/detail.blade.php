@extends('layouts.app')
@section('title', 'Detail volunteer')
@section('breadcrumb-list')
    <li class="active">Screening</li>
@endsection
@section('breadcrumbTitle', 'volunteer Detail')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">volunteer Detail</a>
    </li>
    <li class="breadcrumb-item">
        <a href="" class="text-muted">{{ $volunteer->first_name }} {{ $volunteer->father_name }}</a>
    </li>
@endsection
@section('content')
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        Personal Information
                    </h3>

                </div>
                <!--end::Header-->
                <div class="card-body">
                    <!--begin::Details-->
                    <div class="d-flex mb-9">
                        <!--begin: Pic-->

                        <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                            <div class="symbol symbol-40 symbol-lg-90">
                                <img src="{{ asset($volunteer->picture()->file_path) }}" alt="image">
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
                                        class="text-dark-75 text-hover-primary font-size-h5 font-weight-bold mr-3">{{ $volunteer->first_name }}
                                        {{ $volunteer->father_name }} {{ $volunteer->father_grand_name }}</a>
                                    <a href="#">
                                        <i class="flaticon2-correct text-success font-size-h5"></i>
                                    </a>
                                </div>
                                <div class="">


                                </div>

                            </div>
                            <!--end::Title-->
                            <!--begin::Content-->
                            <div class="d-flex flex-wrap justify-content-between mt-4">
                                <div class="d-flex flex-column flex-grow-1 pr-8">
                                    <div class="d-flex flex-wrap mb-4">
                                        <a href="#"
                                            class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                            <i
                                                class="flaticon2-user-outline-symbol mr-2 font-size-lg"></i>{{ $volunteer->gender == 'f' || 'F' ? 'Femail' : 'Male' }}</a>
                                        <a href="#"
                                            class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                            <i class="flaticon2-new-email mr-2 font-size-lg"></i>{{ $volunteer->email }}</a>
                                        <a href="#"
                                            class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                            <i class="flaticon2-phone mr-2 font-size-lg"></i>{{ $volunteer->phone }}</a>
                                        <a href="#" class="text-dark-50 text-hover-primary font-weight-bold">
                                            <i
                                                class="flaticon2-placeholder mr-2 font-size-lg"></i>{{ $volunteer->woreda?->name }},
                                            {{ $volunteer->woreda?->zone?->name }}
                                            {{ $volunteer->woreda?->zone?->region?->name }}</a>
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
                                <span class="font-weight-bolder font-size-sm">Educationl Level</span>
                                <span class="font-weight-bolder font-size-h5">
                                    <span
                                        class="text-dark-50 font-weight-bold"></span>{{ $volunteer->educationalLevel()[$volunteer->educational_level] }}</span>
                            </div>
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                            <span class="mr-4">
                                <i class="flaticon-book display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">Field Of Study</span>
                                <span class="font-weight-bolder font-size-h5">
                                    <span
                                        class="text-dark-50 font-weight-bold"></span>{{ $volunteer->fieldOfStudy->name }}</span>
                            </div>
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                            <span class="mr-4">
                                <i class="flaticon-book display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">Gpa</span>
                                <span class="font-weight-bolder font-size-h5">
                                    <span class="text-dark-50 font-weight-bold"></span>{{ $volunteer->gpa }}</span>
                            </div>
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                            <span class="mr-4">
                                <i class="flaticon-avatar display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">Conatct Name</span>
                                <span class="font-weight-bolder font-size-h5">
                                    <span
                                        class="text-dark-50 font-weight-bold"></span>{{ $volunteer->contact_name }}</span>
                            </div>
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                            <span class="mr-4">
                                <i class="flaticon2-phone display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">Conatct Phone</span>
                                <span class="font-weight-bolder font-size-h5">
                                    <span
                                        class="text-dark-50 font-weight-bold"></span>{{ $volunteer->contact_phone }}</span>
                            </div>
                        </div>
                        <!--end::Item-->

                    </div>
                    @if ($volunteer->status?->acceptance_status)
                        @php
                            $volStatus = $volunteer->status?->acceptance_status;
                            $volName = \App\Models\Status::$status[$volStatus];
                        @endphp

                        <div class="my-4 mx-4 float-right">
                            <h1>Status:<span
                                    class="badge {{ $volStatus == 0 ? 'badge-warning' : ($volStatus == 1 ? 'badge-success' : ($volStatus == 2 ? 'badge-danger' : 'badge-info')) }} badge-pill">{{ $volName }}</span>
                            </h1>
                        </div>
                        @if ($volunteer->status?->acceptance_status==2)
                        <div class="my-4 mx-4 float-left">
                            <h3>Rejection Reason</h3>
                            <p>{{ $volunteer->status?->rejection_reason??'unknown' }}</p>
                        </div>
                        @endif
                    @endif
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
                                Documents
                            </h3>

                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-3 pb-0">
                            <!--begin::Table-->
                            <div class="table">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless table-vertical-center">
                                            <h4>Educational Documents</h4>
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
                                                <div class="col-4">
                                                    <tr>
                                                        <td class="pl-0 py-4">
                                                            <div class="symbol symbol-50 symbol-light mr-1">
                                                                <span class="symbol-label">
                                                                    <img src="{{ asset('assets/media/svg/misc/007-disqus.svg') }}"
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
                                                                22 Kb
                                                            </div>
                                                        </td>

                                                        <td class="text-right">
                                                            <span
                                                                class="label label-lg label-light-primary label-inline"><a
                                                                    href="{{ asset($volunteer->picture()->file_path) }}"
                                                                    target="_blank">Open
                                                                    File</a></span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td class="pl-0 py-4">
                                                            <div class="symbol symbol-50 symbol-light mr-1">
                                                                <span class="symbol-label">
                                                                    <img src="{{ asset('assets/media/svg/misc/007-disqus.svg') }}"
                                                                        class="h-50 align-self-center" alt="">
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td class="pl-0">
                                                            <a href="#"
                                                                class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">
                                                                Bsc Degree Documnet File</a>
                                                            <div>
                                                                <span class="font-weight-bolder">Size:</span>
                                                                22 Kb
                                                            </div>
                                                        </td>
                                                        @if ($volunteer->getBsc() != null)
                                                            <td class="text-right">
                                                                <span
                                                                    class="label label-lg label-light-primary label-inline"><a
                                                                        href="{{ asset($volunteer->getBsc()->file_path) }}"
                                                                        target="_blank">Open
                                                                        File</a></span>
                                                            </td>
                                                        @else
                                                            <td class="text-right">
                                                                <span class="badge badge-danger badge-pill">Not
                                                                    Available</span>
                                                            </td>
                                                        @endif



                                                    </tr>
                                                    <tr>
                                                        <td class="pl-0 py-4">
                                                            <div class="symbol symbol-50 symbol-light mr-1">
                                                                <span class="symbol-label">
                                                                    <img src="{{ asset('assets/media/svg/misc/007-disqus.svg') }}"
                                                                        class="h-50 align-self-center" alt="">
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td class="pl-0">
                                                            <a href="#"
                                                                class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">
                                                                Msc Degree Documnet File</a>
                                                            <div>
                                                                <span class="font-weight-bolder">Size:</span>
                                                                22 Kb
                                                            </div>
                                                        </td>
                                                        @if ($volunteer->getMsc() != null)
                                                            <td class="text-right">
                                                                <span
                                                                    class="label label-lg label-light-primary label-inline"><a
                                                                        href="{{ asset($volunteer->getMsc()->file_path) }}"
                                                                        target="_blank">Open
                                                                        File</a></span>
                                                            </td>
                                                        @else
                                                            <td class="text-right">
                                                                <span class="badge badge-danger badge-pill">Not
                                                                    Available</span>
                                                            </td>
                                                        @endif



                                                    </tr>

                                                    <tr>
                                                        <td class="pl-0 py-4">
                                                            <div class="symbol symbol-50 symbol-light mr-1">
                                                                <span class="symbol-label">
                                                                    <img src="{{ asset('assets/media/svg/misc/007-disqus.svg') }}"
                                                                        class="h-50 align-self-center" alt="">
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td class="pl-0">
                                                            <a href="#"
                                                                class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">
                                                                Msc Degree Documnet File</a>
                                                            <div>
                                                                <span class="font-weight-bolder">Size:</span>
                                                                22 Kb
                                                            </div>
                                                        </td>
                                                        @if ($volunteer->getPhd() != null)
                                                            <td class="text-right">
                                                                <span
                                                                    class="label label-lg label-light-primary label-inline"><a
                                                                        href="{{ asset($volunteer->getPhd()->file_path) }}"
                                                                        target="_blank">Open
                                                                        File</a></span>
                                                            </td>
                                                        @else
                                                            <td class="text-right">
                                                                <span class="badge badge-danger badge-pill">Not
                                                                    Available</span>
                                                            </td>
                                                        @endif



                                                    </tr>

                                                </div>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless table-vertical-center">
                                            <thead>
                                                <h4>Personal Documents</h4>

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
                                                @if ($volunteer->gender == 'F' || $volunteer->gender == 'f')
                                                    <tr>
                                                        <td class="pl-0 py-4">
                                                            <div class="symbol symbol-50 symbol-light mr-1">
                                                                <span class="symbol-label">
                                                                    <img src="{{ asset('assets/media/svg/misc/007-disqus.svg') }}"
                                                                        class="h-50 align-self-center" alt="">
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td class="pl-0">
                                                            <a href="#"
                                                                class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">
                                                                Non- Pregenant Document</a>
                                                            <div>
                                                                <span class="font-weight-bolder">Size:</span>
                                                                22 Kb
                                                            </div>
                                                        </td>
                                                        @if ($volunteer->getPregnant() != null)
                                                            <td class="text-right">
                                                                <span
                                                                    class="label label-lg label-light-primary label-inline"><a
                                                                        href="{{ asset($volunteer->getPregnant()->file_path) }}"
                                                                        target="_blank">Open
                                                                        File</a></span>
                                                            </td>
                                                        @else
                                                            <td class="text-right">
                                                                <span class="badge badge-danger badge-pill">Not
                                                                    Available</span>
                                                            </td>
                                                        @endif



                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td class="pl-0 py-4">
                                                        <div class="symbol symbol-50 symbol-light mr-1">
                                                            <span class="symbol-label">
                                                                <img src="{{ asset('assets/media/svg/misc/007-disqus.svg') }}"
                                                                    class="h-50 align-self-center" alt="">
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="pl-0">
                                                        <a href="#"
                                                            class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">
                                                            Ethical Licence Document</a>
                                                        <div>
                                                            <span class="font-weight-bolder">Size:</span>
                                                            22 Kb
                                                        </div>
                                                    </td>
                                                    @if ($volunteer->getEthical() != null)
                                                        <td class="text-right">
                                                            <span
                                                                class="label label-lg label-light-primary label-inline"><a
                                                                    href="{{ asset($volunteer->getEthical()->file_path) }}"
                                                                    target="_blank">Open
                                                                    File</a></span>
                                                        </td>
                                                    @else
                                                        <td class="text-right">
                                                            <span class="badge badge-danger badge-pill">Not
                                                                Available</span>
                                                        </td>
                                                    @endif



                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
            <div class="card card-custom gutter-b">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        Placed Training Center Information
                    </h3>
                </div>
                <!--end::Header-->
                <div class="card-body">
                    <li>Placement Place
                        <strong
                            class="{{ $volunteer->placment() != null ? '' : 'text-danger' }}">{{ $volunteer->placment() != null ? $volunteer->placment()->name : 'Not Placed' }}
                            ({{ $volunteer->placment()?->code }})</strong>
                    </li>
                </div>
            </div>
            <div class="card card-custom gutter-b">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        Volunteer Deployment Information
                    </h3>
                </div>
                <!--end::Header-->
                <div class="card-body">
                    <li>Deployment Place <strong
                            class="{{ $volunteer?->approvedApplicant?->trainingPlacement?->deployment?->woredaIntake?->woreda != null ? '' : 'text-danger' }}">{{ $volunteer?->approvedApplicant?->trainingPlacement?->deployment?->woredaIntake?->woreda != null ? $volunteer?->approvedApplicant?->trainingPlacement?->deployment?->woredaIntake?->woreda->name . ' Woreda' : 'Not Placed' }}
                        </strong></li>
                </div>
            </div>
        </div>

        <!--end::Container-->
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/pages/crud/forms/widgets/select2.js') }}"></script>
@endpush
