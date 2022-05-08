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
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/mop_logo.jpg') }}" />
    <img  style="height:50px; width:110px;" src="{{ asset('assets/media/logos/flag.gif') }}" /> 
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed page-loading">
    <!--begin::Main-->
    <!--begin::Header Mobile-->
    <div  style="background-color:  #5dade2;" id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
        <!--begin::Logo-->
        <a href="#">
            <img  style="height:50px; width:110px;" src="{{ asset('assets/media/logos/flag.gif') }}" /> 
        </a>

 
            <h3 style="color;white; font-size:13px;text-align:center;"> <br><br><br>
                Youth Volunteerism<br> Managment System(YVMS)<br>
                <hr>
                <a href="{{ route('aplication.form') }}" class="btn"
                style="min-width: 150px; background-color:rgb(249 ,92 ,57);color:white;font-weight:bold;">
                <b>
                    {{-- <i class="fal fa-plus"></i> --}}
                </b>
                <span class="menu-text">Apply Now</span>
            </a>
            
                
                {{-- Ministry of Peace| የሰላም ሚኒስቴር  --}}

                
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
                            <img  style="height:50px; width:110px;" src="{{ asset('assets/media/logos/flag.gif') }}" /> 
                             

                            <a href="#">
                                <h3 style="color:#5dade2; font-size:13px;text-align:center;"> <br><br><br>
                                    Youth Volunteerism<br> Managment System(YVMS)<br>
                                    <hr>
                                    Ministry of Peace
                                
                                    
                                    {{-- Ministry of Peace| የሰላም ሚኒስቴር  --}}
        
                                    
                                </h3>
                                
                            </a>
                            </div>
                            <!--end::Header Logo-->
                            <!--begin::Header Menu-->
                                                    <!--begin::Container-->

                            <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                                <!--begin::Header Nav-->
                                @include('menu.header')
                                <!--end::Header Nav-->
                            </div>
                            <!--end::Header Menu-->
                        </div>
                        <!--end::Header Menu Wrapper-->
                        <div class="topbar">
                            <div class="topbar-item">
                                <a href="{{ route('aplication.form') }}" class="btn"
                                    style="min-width: 150px; background-color:rgb(249 ,92 ,57);color:white;font-weight:bold;">
                                    <b>
                                        {{-- <i class="fal fa-plus"></i> --}}
                                    </b>
                                    <span class="menu-text">Apply Now</span>
                                </a>
                              --}}
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
                            <a href="#" target="_blank" class="text-dark-75 text-hover-primary"> Ministry of Peace| የሰላም ሚኒስቴር </a>
                        </div>
                        <!--end::Copyright-->
                        <!--begin::Nav-->
                        <div class="nav nav-dark">
                            <a href="#" target="_blank" class="nav-link pl-0 pr-5"> Home</a> 
                            <a href="#" target="_blank" class="nav-link pl-0 pr-0"> About Us</a> &nbsp;&nbsp;
                            <a href="#" target="_blank" class="nav-link pl-0 pr-5"> Contact us</a>
                            <a href="#" target="_blank" class="nav-link pl-0 pr-0"> Vision & Mission </a>&nbsp;&nbsp;
                            <a href="#" target="_blank" class="nav-link pl-0 pr-0"> Login</a>
                            

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

    @stack('js')
    <!--end::Page Scripts-->
    <script>
        @if (Session::has('message'))
            $(function(){
            toastr.success('{{ Session::get('message') }}');
            })
        @endif
    </script>
@section('title','Welcome To Ministry Of Peace')
</body>
<!--end::Body-->

</html>

