<html lang="en">
<!--begin::Head-->

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
    @stack('css')
    <link rel="shortcut icon" href="{{ asset('img/logo_peace_min.png') }}" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body"
    class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading {{ $miniSide ?? '' }}">

    <!--begin::Main-->
    <!--begin::Header Mobile-->
    <div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
        <!--begin::Logo-->
        <a href="/">
            <img alt="Logo" width="120" src="{{ asset('img/logo_peace_min.png') }}" width="40" />
        </a>
        <!--end::Logo-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Aside Mobile Toggle-->
            <button class="p-0 btn burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
                <span></span>
            </button>
            <!--end::Aside Mobile Toggle-->
            <!--begin::Header Menu Mobile Toggle-->
            <button class="p-0 ml-4 btn burger-icon" id="kt_header_mobile_toggle">
                <span></span>
            </button>
            <!--end::Header Menu Mobile Toggle-->
            <!--begin::Topbar Mobile Toggle-->
            <button class="p-0 ml-2 btn btn-hover-text-primary" id="kt_header_mobile_topbar_toggle">
                <span class="svg-icon svg-icon-xl">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24" />
                            <path
                                d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                fill="#000000" fill-rule="nonzero" opacity="0.3" />
                            <path
                                d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                fill="#000000" fill-rule="nonzero" />
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
            </button>
            <!--end::Topbar Mobile Toggle-->
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header Mobile-->
    <div class="d-flex flex-column flex-root">
        <div class="flex-row d-flex flex-column-fluid page">
            <!--begin::Aside-->
            <div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
                <!--begin::Brand-->
                <div class="mt-4 brand flex-column-auto" id="kt_brand">
                    <!--begin::Logo-->
                    <a href="#" class="text-center brand-logo w-100 d-block">
                        <img alt="Logo" src="{{ asset('img/peace_logo_max.png') }}" width="130" />
                    </a>

                    <!--end::Logo-->
                    <!--begin::Toggle-->
                    <button class="px-0 brand-toggle btn btn-sm" id="kt_aside_toggle">
                        <span class="svg-icon svg-icon-xl">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24" />
                                    <path
                                        d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
                                        fill="#000000" fill-rule="nonzero"
                                        transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
                                    <path
                                        d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
                                        fill="#000000" fill-rule="nonzero" opacity="0.3"
                                        transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                    </button>
                    <!--end::Toolbar-->
                </div>
                <!--end::Brand-->
                <!--begin::Aside Menu-->
                <div class="aside-menu-wrapper flex-column-fluid " style="padding: 5px;" id="kt_aside_menu_wrapper">
                    <!--begin::Menu Container-->
                    <div id="kt_aside_menu" class="my-4 aside-menu" data-menu-vertical="1" data-menu-scroll="1"
                        data-menu-dropdown-timeout="500">
                        <!--begin::Menu Nav-->
                        <ul class="menu-nav">
                            <li class="menu-item {{ strpos(Route::currentRouteName(), 'dashboard') === 0 ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('dashboard', []) }}" class="menu-link">
                                    <i class="menu-icon flaticon-home"></i>
                                    <span class="menu-text">Dashboard</span>
                                </a>
                            </li>
                            <li class="menu-item menu-item-submenu {{ strpos(Route::currentRouteName(), 'training_session') === 0 ? 'menu-item-open' : '' }}"
                                aria-haspopup="true" data-menu-toggle="hover">

                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <i class="menu-icon flaticon-calendar-1"></i>
                                    <span class="menu-text">Volunteer Program</span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="menu-submenu">
                                    <i class="menu-arrow"></i>
                                    <ul class="menu-subnav">
                                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                                            <span class="menu-link">
                                                <span class="menu-text">User</span>
                                            </span>
                                        </li>
                                        <li class="menu-item {{ strpos(Route::currentRouteName(), 'training_session.index') === 0 ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a href="{{ route('training_session.index', []) }}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">All Programs</span>
                                            </a>
                                        </li>
                                        <li class="menu-item {{ strpos(Route::currentRouteName(), 'training_session.create') === 0 ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a href="{{ route('training_session.create', []) }}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Add Program</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @if (Request::route('training_session'))
                                @can('session.detail')
                                    <li class="menu-item {{ strpos(Route::currentRouteName(), 'session.training_center.index') === 0 ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('session.training_center.index', ['training_session' => Request::route('training_session')]) }}"
                                            class="menu-link">
                                            <i class="menu-icon fal fa-university"></i>
                                            <span class="menu-text">Session Detail</span>
                                        </a>
                                    </li>
                                @endcan

                                <li class="menu-item menu-item-submenu {{ strpos(Route::currentRouteName(), 'session.volunteer.index') === 0 || strpos(Route::currentRouteName(), 'session.volunteer.all') === 0 || strpos(Route::currentRouteName(), 'session.applicant.verified') === 0 || strpos(Route::currentRouteName(), 'session.applicant.selected') === 0 || strpos(Route::currentRouteName(), 'session.applicant.email.unVerified') === 0 ? 'menu-item-open' : '' }}"
                                    aria-haspopup="true" data-menu-toggle="hover">

                                    <a href="javascript:;" class="menu-link menu-toggle">
                                        <i class="menu-icon flaticon-users"></i>
                                        <span class="menu-text">Applicants</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="menu-submenu">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item menu-item-parent" aria-haspopup="true">
                                                <span class="menu-link">
                                                    <span class="menu-text">Applicants</span>
                                                </span>
                                            </li>
                                            {{-- /*(strpos(Route::currentRouteName(), 'session.volunteer.all') === 0 || strpos(Route::currentRouteName(), 'session.volunteer') === 0) ? 'menu-item-active' : '' */ --}}
                                            <li class="menu-item {{ strpos(Route::currentRouteName(), 'session.volunteer.index') === 0 ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('session.volunteer.index', ['training_session' => Request::route('training_session')]) }}"
                                                    class="menu-link">
                                                    <i class="menu-bullet menu-bullet-dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Applicants</span>
                                                </a>
                                            </li>
                                            <li class="menu-item {{ strpos(Route::currentRouteName(), 'session.volunteer.all') === 0 ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">

                                                <a href="{{ route('session.volunteer.all', ['training_session' => Request::route('training_session')]) }}"
                                                    class="menu-link">
                                                    <i class="menu-bullet menu-bullet-dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Applicants all</span>
                                                </a>
                                                {{-- <a href="{{ route('session.volunteer.index', ['training_session' => Request::route('training_session')]) }}"
                                                    class="menu-link">
                                                    <i class="menu-bullet menu-bullet-dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Applicants</span>
                                                </a> --}}
                                            </li>
                                            <li class="menu-item {{ strpos(Route::currentRouteName(), 'session.applicant.verified') === 0 ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('session.applicant.verified', ['training_session' => Request::route('training_session')]) }}"
                                                    class="menu-link">
                                                    <i class="menu-bullet menu-bullet-dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Verified Applicants</span>
                                                </a>
                                            </li>
                                            <li class="menu-item {{ strpos(Route::currentRouteName(), 'session.applicant.selected') === 0 ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('session.applicant.selected', ['training_session' => Request::route('training_session')]) }}"
                                                    class="menu-link">
                                                    <i class="menu-bullet menu-bullet-dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Selected Applicant</span>
                                                </a>
                                            </li>
                                            <li class="menu-item {{ strpos(Route::currentRouteName(), 'session.applicant.email.unVerified') === 0 ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('session.applicant.email.unVerified', ['training_session' => Request::route('training_session')]) }}"
                                                    class="menu-link">
                                                    <i class="menu-bullet menu-bullet-dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Unverified Email</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                {{-- <li class="menu-item {{ strpos(Route::currentRouteName(), 'session.pacement') === 0 ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('session.placement.index', ['training_session' => Request::route('training_session')]) }}"
                                        class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Placed Applicant</span>
                                    </a>
                                </li> --}}

                                {{-- <li class="menu-item {{ strpos(Route::currentRouteName(), 'session.applicant') === 0 ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('session.volunteer.index', ['training_session' => Request::route('training_session')]) }}"
                                        class="menu-link">
                                        <i class="menu-icon flaticon-users"></i>
                                        <span class="menu-text">Applicants</span>
                                    </a>
                                </li> --}}

                                <li class="menu-item {{ strpos(Route::currentRouteName(), 'session.placement.index') === 0 ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('session.placement.index', ['training_session' => Request::route('training_session')]) }}"
                                        class="menu-link">
                                        <i class="menu-icon fal fa-map-marker-check"></i>

                                        <span class="menu-text">Placement Result</span>
                                    </a>
                                </li>

                                <li class="menu-item {{ strpos(Route::currentRouteName(), 'session.schedule') === 0 ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('session.schedule', ['training_session' => Request::route('training_session')]) }}"
                                        class="menu-link">
                                        <i class="menu-icon flaticon-calendar"></i>
                                        <span class="menu-text">Training Schedule</span>
                                    </a>
                                </li>
                                <li class="menu-item {{ strpos(Route::currentRouteName(), 'session.training_master_placement') === 0 ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('session.training_master_placement.index', ['training_session' => Request::route('training_session')]) }}"
                                        class="menu-link">
                                        <i class="menu-icon fal fa-user-tie"></i>
                                        <span class="menu-text">Assigned Trainner</span>
                                    </a>
                                </li>

                                <li class="menu-item {{ strpos(Route::currentRouteName(), 'session.CheckIn.index') === 0 ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('session.TrainingCenter.CheckIn', ['training_session' => Request::route('training_session')]) }}"
                                        class="menu-link">
                                        <i class="menu-icon flaticon2-check-mark"></i>
                                        <span class="menu-text">Check-In</span>
                                    </a>
                                </li>
                                <li class="menu-item {{ strpos(Route::currentRouteName(), 'session.graduation.list') === 0 ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('session.graduation.list', ['training_session' => Request::route('training_session')]) }}"
                                        class="menu-link">
                                        <i class="menu-icon fal fas fa-graduation-cap"></i>

                                        <span class="menu-text">Graduated Volunteers</span>
                                    </a>
                                </li>

                                <li class="menu-item {{ strpos(Route::currentRouteName(), 'session.deployment.index') === 0 ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('session.deployment.index', ['training_session' => Request::route('training_session')]) }}"
                                        class="menu-link">
                                        <i class="menu-icon fal fa-server"></i>

                                        <span class="menu-text">Volunteer Deployments </span>
                                    </a>
                                </li>
                                <li class="menu-item {{ strpos(Route::currentRouteName(), 'session.deployment.regions') === 0 ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('session.deployment.regions', ['training_session' => Request::route('training_session')]) }}"
                                        class="menu-link">
                                        <i class="menu-icon fal fa-university"></i>
                                        <span class="menu-text">Hierarchial Reports</span>
                                    </a>
                                </li>
                                <li class="menu-item {{ strpos(Route::currentRouteName(), 'session.certificate.graduate') === 0 ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('session.certificate.graduate', ['training_session' => Request::route('training_session')]) }}"
                                        class="menu-link">
                                        <i class="menu-icon fal flaticon2-document"></i>

                                        <span class="menu-text">Generate Certificate</span>
                                    </a>
                                </li>

                                <li class="menu-item {{ strpos(Route::currentRouteName(), 'session.training_session.quota') === 0 ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('session.training_session.quota', ['training_session' => Request::route('training_session')]) }}"
                                        class="menu-link">
                                        <i class="menu-icon fab fa-quora"></i>
                                        <span class="menu-text">Region Status</span>
                                    </a>
                                </li>
                                <li class="menu-item {{ strpos(Route::currentRouteName(), 'resources') === 0 ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('session.resource.all', ['training_session' => Request::route('training_session')]) }}"
                                        class="menu-link">
                                        <i class="menu-icon flaticon2-shopping-cart"></i>
                                        <span class="menu-text">Resource Managment</span>
                                    </a>
                                </li>
                            @endif
                            <li class="menu-item menu-item-submenu {{ strpos(Route::currentRouteName(), 'user') === 0 ? 'menu-item-open' : '' }}"
                                aria-haspopup="true" data-menu-toggle="hover">

                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <i class="menu-icon flaticon-users"></i>
                                    <span class="menu-text">User Managment</span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="menu-submenu">
                                    <i class="menu-arrow"></i>
                                    <ul class="menu-subnav">
                                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                                            <span class="menu-link">
                                                <span class="menu-text">User</span>
                                            </span>
                                        </li>

                                        <li class="menu-item {{ strpos(Route::currentRouteName(), 'user.index') === 0 ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a href="{{ route('user.index', []) }}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">All Users</span>
                                            </a>
                                        </li>

                                        <li class="menu-item {{ strpos(Route::currentRouteName(), 'user.create') === 0 ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a href="{{ route('user.create', []) }}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Add User</span>
                                            </a>
                                        </li>


                                        <li class="menu-item {{ strpos(Route::currentRouteName(), 'training_master') === 0 ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a href="{{ route('training_master.index', []) }}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Master Trainers</span>
                                            </a>
                                        </li>

                                        <li class="menu-item {{ strpos(Route::currentRouteName(), 'role.index') === 0 ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('role.index', []) }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Roles</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ strpos(Route::currentRouteName(), 'permission.index') === 0 ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('permission.index', []) }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Permissions</span>
                                        </a>
                                    </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="menu-item {{ strpos(Route::currentRouteName(), 'training.') === 0 ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('training.index', []) }}" class="menu-link">
                                    <i class="fal fa-book-open menu-icon"></i>
                                    <span class="menu-text">Training</span>
                                </a>
                            </li>

                            {{-- <li class="menu-item menu-item-submenu {{ strpos(Route::currentRouteName(), 'role') === 0 || strpos(Route::currentRouteName(), 'permission') === 0 ? 'menu-item-open' : '' }}"
                                aria-haspopup="true" data-menu-toggle="hover">

                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <i class="menu-icon flaticon-lock"></i>
                                    <span class="menu-text">Role &amp; Permissions</span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="menu-submenu">
                                    <i class="menu-arrow"></i>
                                    <ul class="menu-subnav">
                                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                                            <span class="menu-link">
                                                <span class="menu-text">Roles &amp; Permissions</span>
                                            </span>
                                        </li>

                                        <li class="menu-item {{ strpos(Route::currentRouteName(), 'role.index') === 0 ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a href="{{ route('role.index', []) }}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Roles</span>
                                            </a>
                                        </li>

                                        <li class="menu-item {{ strpos(Route::currentRouteName(), 'permission.index') === 0 ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a href="{{ route('permission.index', []) }}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Permissions</span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li> --}}

                            @include('aside.ms_aside')
                            @include('aside.placement')
                            @include('aside.payroll')

                            <li class="menu-item menu-item-submenu {{ strpos(Route::currentRouteName(), 'region') === 0 || strpos(Route::currentRouteName(), 'woreda') === 0 || strpos(Route::currentRouteName(), 'feild_of_study') === 0 || strpos(Route::currentRouteName(), 'zone') === 0 ? 'menu-item-open' : '' }}"
                                aria-haspopup="true" data-menu-toggle="hover">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <i class="menu-icon flaticon-settings"></i>
                                    <span class="menu-text">Setting</span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="menu-submenu">
                                    <i class="menu-arrow"></i>
                                    <ul class="menu-subnav">
                                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                                            <span class="menu-link">
                                                <span class="menu-text">Settings</span>
                                            </span>
                                        </li>
                                        @include('aside.ms')
                                        @include('aside.seya')
                                        @include('aside.aj')
                                        <li class="menu-item {{ strpos(Route::currentRouteName(), 'resource.index') === 0 ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a href="{{ route('resource.index', []) }}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Resource</span>
                                            </a>
                                        </li>
                                        <li class="menu-item {{ strpos(Route::currentRouteName(), 'translation') === 0 ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a href="{{ route('translation.index', []) }}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Translation</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="menu-item menu-item-submenu {{ strpos(Route::currentRouteName(), 'Events') === 0 || strpos(Route::currentRouteName(), 'woreda') === 0 || strpos(Route::currentRouteName(), 'feild_of_study') === 0 || strpos(Route::currentRouteName(), 'zone') === 0 ? 'menu-item-open' : '' }}"
                                aria-haspopup="true" data-menu-toggle="hover">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    {{-- <i class="menu-icon flaticon-file"></i> --}}
                                    <i class=" menu-icon fa fa-file-magnifying-glass"></i>
                                    <span class="menu-text">Events</span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="menu-submenu">
                                    <i class="menu-arrow"></i>
                                    <ul class="menu-subnav">
                                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                                            <span class="menu-link">
                                                <span class="menu-text">Events</span>
                                            </span>
                                        </li>


                                        <li class="menu-item {{ strpos(Route::currentRouteName(), 'audits') === 0 ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a href="{{ route('Events.create', []) }}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">New Event </span>
                                            </a>
                                        </li>
                                        <li class="menu-item {{ strpos(Route::currentRouteName(), 'audits') === 0 ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a href="{{ route('Events.index', []) }}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">All Event </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="menu-item menu-item-submenu {{ strpos(Route::currentRouteName(), 'audits') === 0 || strpos(Route::currentRouteName(), 'woreda') === 0 || strpos(Route::currentRouteName(), 'feild_of_study') === 0 || strpos(Route::currentRouteName(), 'zone') === 0 ? 'menu-item-open' : '' }}"
                                aria-haspopup="true" data-menu-toggle="hover">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    {{-- <i class="menu-icon flaticon-file"></i> --}}
                                    <i class=" menu-icon fa fa-file-magnifying-glass"></i>
                                    <span class="menu-text">Audits</span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="menu-submenu">
                                    <i class="menu-arrow"></i>
                                    <ul class="menu-subnav">
                                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                                            <span class="menu-link">
                                                <span class="menu-text">Audits</span>
                                            </span>
                                        </li>


                                        <li class="menu-item {{ strpos(Route::currentRouteName(), 'audits') === 0 ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a href="{{ route('audit.index', []) }}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Audits </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            {{-- @include('aside.ms') --}}
                        </ul>
                    </div>
                    <!--end::Menu Container-->
                </div>
                <!--end::Aside Menu-->
            </div>
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" style="padding-top: 50px;" id="kt_wrapper">
                <!--begin::Header-->
                @include('layouts.header')
                <!--end::Header-->
                <!--begin::Content-->
                <!--begin::Subheader-->

                <!--end::Subheader-->
                <!--begin::Entry-->
                <div class="p-5 flex-column-fluid">
                    <!--begin::Container-->
                    <div class="container mt-6">

                        @yield('content')

                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Entry-->
            </div>
            <!--end::Content-->
        </div>
        <!--begin::Footer-->
        <div class="py-4 bg-white footer d-flex flex-lg-column" id="kt_footer">
            <!--begin::Container-->
            <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                <!--begin::Copyright-->
                <div class="order-2 text-dark order-md-1">
                    <span class="mr-2 text-muted font-weight-bold">2020 &copy;</span>
                    <a href="#" target="_blank" class="text-dark-75 text-hover-primary">Ministry of Peace</a>
                </div>
                <!--end::Copyright-->
                <!--begin::Nav-->
                <div class="nav nav-dark">
                    <a href="#" target="_blank" class="pl-0 pr-5 nav-link">About</a>
                    <a href="#" target="_blank" class="pl-0 pr-5 nav-link">Team</a>
                    <a href="#" target="_blank" class="pl-0 pr-0 nav-link">Contact</a>
                </div>
                <!--end::Nav-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Footer-->
    </div>
    </div>
    <!--end::Aside-->
    </div>

    <!--end::Main-->
    <!-- begin::User Panel-->
    <div id="kt_quick_user" class="p-10 offcanvas offcanvas-right">
        <!--begin::Header-->
        <div class="pb-5 offcanvas-header d-flex align-items-center justify-content-between">
            <h3 class="m-0 font-weight-bold">User Profile
                <small class="ml-2 text-muted font-size-sm"></small>
            </h3>
            <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
                <i class="ki ki-close icon-xs text-muted"></i>
            </a>
        </div>
        <!--end::Header-->
        <!--begin::Content-->
        <div class="pr-5 offcanvas-content mr-n5">
            <!--begin::Header-->
            <div class="mt-5 d-flex align-items-center">
                <div class="mr-5 symbol symbol-100">
                    {{-- <div class="symbol-label" style="background-image:url({{ Auth::user()->photo }})"></div> --}}
                    <i class="symbol-badge bg-success"></i>
                </div>
                <div class="d-flex flex-column">
                    {{-- <a href="#"
                        class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">{{ Auth::user()->name() }}</a> --}}
                    <div class="mt-1 text-muted"></div>
                    <div class="mt-2 navi">
                        <a href="#" class="navi-item">
                            <span class="p-0 pb-2 navi-link">
                                <span class="mr-1 navi-icon">
                                    <span class="svg-icon svg-icon-lg svg-icon-primary">
                                        <i class="fal fa-id-card-alt"></i>
                                    </span>
                                    {{-- </span>
                                <span class="navi-text text-muted text-hover-primary">{{ Auth::user()->uid }}</span> --}}
                                </span>
                        </a>
                    </div>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Separator-->
            <div class="mt-8 mb-5 separator separator-dashed"></div>
            <!--end::Separator-->
            <!--begin::Nav-->
            <div class="p-0 navi navi-spacer-x-0">
                <!--begin::Item-->
                <a href="#" class="navi-item">
                    <div class="navi-link">
                        <div class="mr-3 symbol symbol-40 bg-light">
                            <div class="symbol-label">
                                <span class="svg-icon svg-icon-md svg-icon-success">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Notification2.svg-->
                                    <i class="far fa-id-card-alt"></i>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                        </div>
                        <div class="navi-text">
                            <a href="{{ route('profile.show', []) }}">

                                <div class="font-weight-bold">My Profile</div>
                                <div class="text-muted">Account settings and more
                                    <span class="label label-light-danger label-inline font-weight-bold"></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </a>
                <!--end:Item-->
                <!--begin::Item-->
                <form action="{{ route('logout', []) }}" id="logoutForm" method="POST">@csrf</form>
                <a href="#" onclick="event.preventDefault();$('#logoutForm').submit()" class="navi-item">
                    <div class="navi-link">
                        <div class="mr-3 symbol symbol-40 bg-light">
                            <div class="symbol-label">
                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-opened.svg-->
                                    <i class="fal fa-sign-out-alt"></i>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                        </div>
                        <div class="navi-text">
                            <div class="font-weight-bold">Logout</div>
                            <div class="text-muted"></div>
                        </div>
                    </div>
                </a>
                <!--end:Item-->
            </div>
            <!--end::Nav-->
            <!--begin::Separator-->
            <div class="separator separator-dashed my-7"></div>
            <!--end::Separator-->
        </div>
        <!--end::Content-->
    </div>
    <!-- end::User Panel-->
    {{-- <script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script> --}}
    <!--begin::Global Config(global config for global JS scripts)-->
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
