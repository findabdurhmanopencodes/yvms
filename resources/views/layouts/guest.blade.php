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
    <link href="{{ asset('assets/css/themes/layout/brand/dark.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/aside/dark.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">

    <!--end::Layout Themes-->
    @stack('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('calendar/css/redmond.calendars.picker.css') }}">
    <link rel="shortcut icon" href="{{ asset('mop_logo.jpg') }}" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed page-loading">
    <!--begin::Main-->
    <!--begin::Header Mobile-->


    <div style="background-color:  #5dade2;" id="kt_header_mobile"
        class="header-mobile align-items-center header-mobile-fixed">
        <!--begin::Logo-->
        <a href="{{ route('home', []) }}">
            <img style="height:50px; width:110px;" src="{{ asset('assets/media/logos/flag.gif') }}" />
        </a>

        <h3 style="color;white; font-size:13px;text-align:center;"> <br><br><br>
            Youth Volunteerism<br> Managment System<br>
            <hr>
            @if (true)
                <a href="{{ route('aplication.form') }}"
                    class="btn font-weight-bolder text-uppercase font-size-lg btn-success py-3 px-6">
                    <b>
                        {{-- <i class="fal fa-plus"></i> --}}
                    </b>
                    <span class="menu-text">Apply Now</span>
                </a>
            @endif

            {{-- Ministry of Peace| የሰላም ሚኒስቴር --}}


        </h3>
        <!--end::Logo-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Header Menu Mobile Toggle-->
            <button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
                <span></span>
            </button>
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header Mobile-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" style="padding-top: 80px;" id="kt_wrapper">
                <!--begin::Header-->
                <div id="kt_header" class="header header-fixed">
                    <!--begin::Container-->
                    <div class="container-fluid d-flex align-items-stretch justify-content-between">



                        <!--begin::Header Menu Wrapper-->
                        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                            <!--begin::Header Logo-->
                            <div class="header-logo">
                                <img style="height:50px; width:110px;"
                                    src="{{ asset('assets/media/logos/flag.gif') }}" />


                                <a href="{{ route('home', []) }}">
                                    <h3 style="color:#5dade2; font-size:13px;text-align:center;"> <br><br><br>
                                        Youth Volunteerism<br> Managment System<br>
                                        <hr><br>



                                        {{-- Ministry of Peace| የሰላም ሚኒስቴር --}}


                                    </h3>

                                </a>
                            </div>
                            <!--end::Header Logo-->
                            <!--begin::Header Menu-->
                            <!--begin::Container-->

                            <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                                <!--begin::Header Nav-->
                                <ul class="menu-nav" id="item-color">
                                    <li
                                        class="menu-item {{ strpos(Route::currentRouteName(), 'home') === 0 ? 'menu-item-active' : '' }}">
                                        <a href="{{ route('home') }}" class="menu-link">
                                            <i style="color:#5dade2 !important;" class=" fal fa-home"></i>
                                            <span class="menu-text">&nbsp; Home</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                    </li>
                                    <li
                                        class="menu-item {{ strpos(Route::currentRouteName(), 'aboutus') === 0 ? 'menu-item-active' : '' }}">
                                        <a href="{{ route('aboutus') }}" class="menu-link">
                                            <i style="color:#5dade2 !important;" class=" fal fa-flag"></i>
                                            <span style="color:#5dade2 !important;" class="menu-text"> &nbsp; About
                                                Us</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                    </li>
                                    <li
                                        class="menu-item {{ strpos(Route::currentRouteName(), 'contact_us') === 0 ? 'menu-item-active' : '' }}">
                                        <a href="{{ route('contactus') }}" class="menu-link">
                                            <i style="color:#5dade2 !important;" class="fal fa-address-book"></i>


                                            <span style="color:#5dade2 !important;" class="menu-text"> &nbsp;
                                                Contact Us</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                    </li>

                                    <li
                                        class="menu-item {{ strpos(Route::currentRouteName(), 'vission_and_mission') === 0 ? 'menu-item-active' : '' }}">
                                        <a href="{{ route('vission_and_mission') }}" class="menu-link">
                                            <i style="color:#5dade2 !important;" class="fal fa-eye"></i>
                                            <span style="color:#5dade2 !important;" class="menu-text"> &nbsp;
                                                Vision & Mision </span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                    </li>
                                    <li
                                        class="menu-item {{ strpos(Route::currentRouteName(), 'login') === 0 ? 'menu-item-active' : '' }}">
                                        <a href="{{ route('login') }}" class="menu-link">
                                            <i style="color:#5dade2 !important;" class="fal fa-sign-in-alt"></i>


                                            <span style="color:#5dade2 !important;" class="menu-text"> &nbsp; Login
                                            </span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                    </li>
                                    <li
                                    class="menu-item {{ strpos(Route::currentRouteName(), 'evene.all') === 0 ? 'menu-item-active' : '' }}">
                                    <a href="{{ route('event.all') }}" class="menu-link">
                                        <i style="color:#5dade2 !important;" class="fal fa-album-collection"></i>


                                        <span style="color:#5dade2 !important;" class="menu-text"> &nbsp; Events
                                        </span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                </li>
                                </ul>
                                <!--end::Header Nav-->
                            </div>
                            <!--end::Header Menu-->
                        </div>
                        <!--end::Header Menu Wrapper-->
                        <div class="topbar">
                            <div class="topbar-item">
                                @if (strpos(Route::currentRouteName(), 'home') !== 0)
                                    <a href="{{ route('aplication.form') }}"
                                        class="btn font-weight-bolder text-uppercase font-size-lg btn-success py-3 px-6">
                                        <b>
                                            {{-- <i class="fal fa-plus"></i> --}}
                                        </b>
                                        <span class="menu-text">Apply Now</span>
                                    </a>
                                @endif
                                {{-- <div class="btn btn-icon btn-clean btn-lg mr-1" id="kt_quick_panel_toggle">
                                    <span class="svg-icon svg-icon-xl svg-icon-primary">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
                                                <path
                                                    d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                                    fill="#000000" opacity="0.3"></path>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Header-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid p-0" id="kt_content">
                    <!--begin::Entry-->
                    <div class="d-flex flex-column-fluid">
                        <!--begin::Container-->
                        <div class="container">


                            @yield('content')
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Entry-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
                <div class="footer bg-white py-4 d-flex flex-lg-column mt-4" id="kt_footer">
                    <!--begin::Container-->
                    <div
                        class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <!--begin::Copyright-->
                        <div class="text-dark order-2 order-md-1">
                            <span class="text-muted font-weight-bold mr-2">2020©</span>
                            <a href="{{ route('home', []) }}" target="_blank"
                                class="text-dark-75 text-hover-primary">Ministry Of Peace</a>
                        </div>
                        <!--end::Copyright-->
                        <!--begin::Nav-->
                        <div class="nav nav-dark">
                            <a href="{{ route('aboutus', []) }}" target="_blank" class="nav-link pl-0 pr-5">About</a>
                            <a href="{{ route('contactus', ['id' => 1]) }}" target="_blank"
                                class="nav-link pl-0 pr-0">Contact</a>
                        </div>
                        <!--end::Nav-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Main-->
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

    <script src="{{ asset('calendar/js/jquery.plugin.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.plus.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.picker.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.ethiopian.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.ethiopian-am.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.picker-am.js') }}"></script>

    <!--end::Page Scripts-->
    <script>
        @if (Session::has('message'))
            $(function() {
                toastr.success('{{ Session::get('message') }}');
            })
        @endif
        @if (Session::has('apply_success'))
            $(function() {
                swal.fire("Application submited!", "You applied successfully!", "success");
            })
            //
        @endif
    </script>
    @stack('js')

</body>
<!--end::Body-->

</html>
