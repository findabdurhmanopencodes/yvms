@extends('layouts.auth')
@section('title', 'Verification Email')

@section('content')
    {{-- <div class="d-flex justify-items-center">


        <div class="pt-lg-10 mb-10">
            <h1 class="fw-bolder fs-2qx text-gray-800 mb-7">Verify Your Email</h1>


            <div class="fs-3 fw-bold text-muted mb-10">We have sent an email to
                <a>
                    Thanks for signing up! Before getting started, could you verify your email address by clicking on the
                    link we just emailed to you? If you didn\'t receive the email, we will gladly send you another
                   </a>
                <br>pelase follow a link to verify your email.
            </div>


            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <div class="fs-5">
                    <span class="fw-bold text-gray-700">Did’t receive an email?</span>
                    <button type="submit" class="btn btn-primary fw-bolder">Resend</button>
                </div>
            </form>
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <div class="text-center mb-10">
                    <button class="btn btn-lg btn-primary fw-bolder float-right" type="submit">Sign Out</button>
                </div>
            </form>

            <!--end::Action-->
        </div>

        <!--end::Wrapper-->
        <!--begin::Illustration-->
        <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px"
            style="background-image: url(/metronic8/demo4/assets/media/illustrations/dozzy-1/17.png"></div>
        <!--end::Illustration-->
    </div> --}}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Verfiying Email</h5>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">

                <!-- start logo -->
                <tr>
                    <td align="center" bgcolor="white">
                        <!--[if (gte mso 9)|(IE)]>
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                            <tr>
                            <td align="center" valign="top" width="600">
                            <![endif]-->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                            <tr>
                                <td align="center" valign="top" style="padding: 36px 24px;">
                                    <a href="" target="_blank" style="display: inline-block;">
                                        <img src="{{ asset('assets/media/logos/logo.jpeg') }}" alt="Logo" border="0"
                                            width="55"
                                            style="display: block; width: 55px; max-width: 70px; min-width: 48px;">
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <!--[if (gte mso 9)|(IE)]>
                            </td>
                            </tr>
                            </table>
                            <![endif]-->
                    </td>
                </tr>
                <!-- end logo -->

                <!-- start hero -->
                <tr>
                    <td align="center" bgcolor="white">
                        <!--[if (gte mso 9)|(IE)]>
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                            <tr>
                            <td align="center" valign="top" width="600">
                            <![endif]-->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                            <tr>
                                <td align="left" bgcolor="white"
                                    style="padding: 36px 24px 0; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; border-top: 3px solid #d4dadf;">
                                    <h1
                                        style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">
                                        Confirm Your Email Address</h1>
                                </td>
                            </tr>
                        </table>
                        <!--[if (gte mso 9)|(IE)]>
                            </td>
                            </tr>
                            </table>
                            <![endif]-->
                    </td>
                </tr>
                <!-- end hero -->

                <!-- start copy block -->
                <tr>
                    <td align="center" bgcolor="white">
                        <!--[if (gte mso 9)|(IE)]>
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                            <tr>
                            <td align="center" valign="top" width="600">
                            <![endif]-->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">

                            <!-- start copy -->
                            <tr>
                                <td align="left" bgcolor="#ffffff"
                                    style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">

                                    Thanks for signing up! Before getting started, could you verify your email address by clicking on the
                                    link we just emailed to you? If you didn\'t receive the email, we will gladly send you another
                                   </a>
                                <br>pelase follow a link to verify your email
                                </td>
                            </tr>
                            <!-- end copy -->

                            <!-- start button -->
                            <tr>
                                <td align="left" bgcolor="#ffffff">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td align="center" bgcolor="#ffffff" style="padding: 12px;">
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center" bgcolor="#1a82e2" style="border-radius: 6px;">
                                                            <form method="POST" action="{{ route('verification.send') }}">
                                                                @csrf
                                                            <button type="submit" target="_blank"
                                                                class="btn btn-primary btn-lg">
                                                                Verify</button>
                                                                </form>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <!-- end button -->

                            <!-- start copy -->

                            <!-- end copy -->

                            <!-- start copy -->
                            <tr>
                                <td align="left" bgcolor="#ffffff"
                                    style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-bottom: 3px solid #d4dadf">
                                    <p style="margin: 0;"> National youth Volunterism</p>
                                </td>
                            </tr>
                            <!-- end copy -->

                        </table>
                        <!--[if (gte mso 9)|(IE)]>
                            </td>
                            </tr>
                            </table>
                            <![endif]-->
                    </td>
                </tr>
                <!-- end copy block -->

                <!-- start footer -->
                <tr>
                    <td align="center" bgcolor="white" style="padding: 24px;">
                        <!--[if (gte mso 9)|(IE)]>
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                            <tr>
                            <td align="center" valign="top" width="600">
                            <![endif]-->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">

                            <!-- start permission -->
                            <tr>
                                <td align="center" bgcolor="white"
                                    style="padding: 12px 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                    <p style="margin: 0;">You received this email because we received a request for
                                        Email Verification
                                        for your account. If you didn't request <button class="btn btn-link" ><h4>Sign-Out</h4></button> you can safely delete this
                                        email.
                                    </p>
                                    </form>
                                </td>
                            </tr>
                            <!-- end permission -->

                            <!-- start unsubscribe -->
                            <tr>
                                <td align="center" bgcolor="#e9ecef"
                                    style="padding: 12px 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;">
                                    <div class="order-2 text-dark order-md-1">
                                        <span class="mr-2 text-muted font-weight-bold">2020 &copy;</span>
                                        <a href="#" target="_blank" class="text-dark-75 text-hover-primary">Ministry of Peace</a>
                                    </div>
                                </td>
                            </tr>
                            <!-- end unsubscribe -->

                        </table>
                        <!--[if (gte mso 9)|(IE)]>
                            </td>
                            </tr>
                            </table>
                            <![endif]-->
                    </td>
                </tr>
                <!-- end footer -->

            </table>
        </div>
    </div>

@endsection
@section('additional_cs')

    <style type="text/css">
        /**
             * Google webfonts. Recommended to include the .woff version for cross-client compatibility.
             */
        @media screen {
            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 400;
                src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
            }

            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 700;
                src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format('woff');
            }
        }

        /**
             * Avoid browser level font resizing.
             * 1. Windows Mobile
             * 2. iOS / OSX
             */
        body,
        table,
        td,
        a {
            -ms-text-size-adjust: 100%;
            /* 1 */
            -webkit-text-size-adjust: 100%;
            /* 2 */
        }

        /**
             * Remove extra space added to tables and cells in Outlook.
             */
        table,
        td {
            mso-table-rspace: 0pt;
            mso-table-lspace: 0pt;
        }

        /**
             * Better fluid images in Internet Explorer.
             */
        img {
            -ms-interpolation-mode: bicubic;
        }

        /**
             * Remove blue links for iOS devices.
             */
        a[x-apple-data-detectors] {
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            color: inherit !important;
            text-decoration: none !important;
        }

        /**
             * Fix centering issues in Android 4.4.
             */
        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }

        body {
            width: 100% !important;
            height: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /**
             * Collapse table borders to avoid space between cells.
             */
        table {
            border-collapse: collapse !important;
        }

        a {
            color: #1a82e2;
        }

        img {
            height: auto;
            line-height: 100%;
            text-decoration: none;
            border: 0;
            outline: none;
        }

    </style>
@endsection
