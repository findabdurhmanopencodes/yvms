<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | {{ env('APP_NAME') }}</title>
    <meta name="description" content="Page with empty content" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Page Vendors Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->

    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{ asset('assets/css/themes/layout/header/base/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/brand/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/aside/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">
    <!--end::Layout Themes-->
    <style>
        table {
            word-break: break-word;
        }
    </style>
    <link rel="shortcut icon" href="{{ asset('img/logo_peace_min.png') }}" />
</head>

<body class="">
    <div class="card mt-4">

        <div class="card-body">
            <h5 class="card-title text-center">My Detail Information</h5>
            <div>
                <form action="{{ route('logout', []) }}" id="logoutForm" method="POST">@csrf</form>

                <a class="btn btn-light-info float-right" href="#"
                    onclick="event.preventDefault();$('#logoutForm').submit()"> <i class="fa fa-sign-out"></i> logout
                </a>

            </div>
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
                                        @if ($volunteer->picture())
                                            <img src="{{ asset($volunteer->picture()->file_path) }}" alt="image">
                                        @else
                                            <img src="{{ asset('user.png') }}" alt="">
                                        @endif
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
                                                    <i
                                                        class="flaticon2-new-email mr-2 font-size-lg"></i>{{ $volunteer->email }}</a>
                                                <a href="#"
                                                    class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                                    <i
                                                        class="flaticon2-phone mr-2 font-size-lg"></i>{{ $volunteer->phone }}</a>
                                                <a href="#"
                                                    class="text-dark-50 text-hover-primary font-weight-bold">
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
                                                class="text-dark-50 font-weight-bold"></span>{{ $volunteer->fieldOfStudy?->name }}</span>
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
                                            <span
                                                class="text-dark-50 font-weight-bold"></span>{{ $volunteer->gpa }}</span>
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
                                @if ($volunteer->status?->acceptance_status == 2)
                                    <div class="my-4 mx-4 float-left">
                                        <h3>Rejection Reason</h3>
                                        <p>{{ $volunteer->status?->rejection_reason ?? 'unknown' }}</p>
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
                                                <table class="table table-borderless table-vertical-center resposive">
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
                                                        <div class="col-sm-4">
                                                            <tr>
                                                                <td class="pl-0 py-4">
                                                                    <div class="symbol symbol-50 symbol-light mr-1">
                                                                        <span class="symbol-label">
                                                                            <img src="{{ asset('assets/media/svg/misc/007-disqus.svg') }}"
                                                                                class="h-50 align-self-center"
                                                                                alt="">
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                                <td class="pl-0">
                                                                    <a href="#"
                                                                        class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">8th
                                                                        Grade Ministry File</a>
                                                                    <div>
                                                                        <span class="font-weight-bolder">Size:</span>

                                                                    </div>
                                                                </td>

                                                                <td class="text-right">
                                                                    @if ($volunteer->picture())
                                                                        <span
                                                                            class="label label-lg label-light-primary label-inline"><a
                                                                                href="{{ asset($volunteer->picture()?->file_path) }}"
                                                                                target="_blank">Open
                                                                                File</a></span>
                                                                    @else
                                                                        <span class="badge badge-danger badge-pill">Not
                                                                            Available</span>
                                                                    @endif

                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td class="pl-0 py-4">
                                                                    <div class="symbol symbol-50 symbol-light mr-1">
                                                                        <span class="symbol-label">
                                                                            <img src="{{ asset('assets/media/svg/misc/007-disqus.svg') }}"
                                                                                class="h-50 align-self-center"
                                                                                alt="">
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                                <td class="pl-0">
                                                                    <a href="#"
                                                                        class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">
                                                                        Bsc Degree Documnet File</a>
                                                                    <div>
                                                                        <span class="font-weight-bolder">Size:</span>

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
                                                                                class="h-50 align-self-center"
                                                                                alt="">
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                                <td class="pl-0">
                                                                    <a href="#"
                                                                        class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">
                                                                        Msc Degree Documnet File</a>
                                                                    <div>
                                                                        <span class="font-weight-bolder">Size:</span>

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
                                                                                class="h-50 align-self-center"
                                                                                alt="">
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                                <td class="pl-0">
                                                                    <a href="#"
                                                                        class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">
                                                                        Msc Degree Documnet File</a>
                                                                    <div>
                                                                        <span class="font-weight-bolder">Size:</span>

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
                                                                                class="h-50 align-self-center"
                                                                                alt="">
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                                <td class="pl-0">
                                                                    <a href="#"
                                                                        class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">
                                                                        Non- Pregenant Document</a>
                                                                    <div>
                                                                        <span class="font-weight-bolder">Size:</span>

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
                                                                            class="h-50 align-self-center"
                                                                            alt="">
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td class="pl-0">
                                                                <a href="#"
                                                                    class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">
                                                                    Ethical Licence Document</a>
                                                                <div>
                                                                    <span class="font-weight-bolder">Size:</span>

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
                    <div class="row">
                        <div class="col-lg-12">
                            <!--begin::Advance Table Widget 2-->
                            <div class="card card-custom card-stretch gutter-b">
                                <!--begin::Header-->
                                <div class="card-header border-0 pt-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        Training Material
                                    </h3>

                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body pt-3 pb-0">
                                    <!--begin::Table-->
                                    <div class="table">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <table
                                                    class="table table-borderless table-vertical-center table-responsive-sm">
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
                                                        <div class="col-6">
                                                            @foreach ($trainingMaterials as $trainingMaterial)
                                                                <tr>
                                                                    <td class="pl-0 py-4">
                                                                        <div
                                                                            class="symbol symbol-50 symbol-light mr-1">
                                                                            <span class="symbol-label">
                                                                                <img src="{{ asset('assets/media/svg/misc/007-disqus.svg') }}"
                                                                                    class="h-50 align-self-center"
                                                                                    alt="">
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                    <td class="pl-0">
                                                                        <a href="#"
                                                                            class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">
                                                                            {{ $trainingMaterial->training?->name }}
                                                                            ({{ $trainingMaterial->name }})
                                                                        </a>

                                                                    </td>

                                                                    <td class="text-right">
                                                                        <span
                                                                            class="label label-lg label-light-primary label-inline"><a
                                                                                href="{{ asset($trainingMaterial->file?->file_path) }}"
                                                                                target="_blank"
                                                                                download>Downlaod</a></span>


                                                                    </td>

                                                                </tr>
                                                            @endforeach
                                                        </div>
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
                </div>

                <!--end::Container-->
            </div>
        </div>
    </div>
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1200
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#6993FF",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#F3F6F9",
                        "dark": "#212121"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#E1E9FF",
                        "secondary": "#ECF0F3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#212121",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#ECF0F3",
                    "gray-300": "#E5EAEE",
                    "gray-400": "#D6D6E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#80808F",
                    "gray-700": "#464E5F",
                    "gray-800": "#1B283F",
                    "gray-900": "#212121"
                }
            },
            "font-family": "Poppins"
        };
    </script>
    <!--end::Global Config-->
    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Theme Bundle-->
    <!--begin::Page Vendors(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM"></script>
    <script src="{{ asset('assets/plugins/custom/gmaps/gmaps.js') }}"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('assets/js/pages/widgets.js') }}"></script>
    @stack('js')
    <!--end::Page Scripts-->
    <script>
        @if (Session::has('message') && !Session::has('error'))
            $(function() {
                toastr.success('{{ Session::get('message') }}');
            })
        @endif

        @if (session('warning'))
            $(function() {
                swal.fire("Error!", "{{ session('warning') }}", "warning");
            })
        @endif

        @if (session('error'))
            $(function() {
                swal.fire("Error!", "{{ session('error') }}", "error");
            })
        @endif
    </script>
</body>


</html>
