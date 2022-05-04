@extends('layouts.app')
@section('title', 'Profile')
@section('breadcrumb-list')
    <li class="active">Profile</li>
@endsection
@section('content')
    <div class="main-content">
        <div class="main-content-inner">
            <div class="page-content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="hr dotted"></div>
                        <div>
                            <div id="user-profile-1" class="user-profile row">
                                <div class="col-xs-12 col-sm-3 center">
                                    <div>
                                        <span style="border-top:3px solid #438EB9;" class="profile-picture">
                                            <img id="avatar" class="editable img-responsive" wi alt="User Photo"
                                                src="{{ asset('assets/images/avatars/profile-pic.jpg') }}" />
                                        </span>

                                        <div class="space-4"></div>

                                        <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                                            <div class="inline position-relative">
                                                <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                                    <i class="ace-icon fa fa-circle light-green"></i> &nbsp;
                                                    <span class="white">{{$user->name()}}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-6"></div>

                                    <div class="profile-contact-info">
                                        <div class="profile-contact-links align-left">


                                            <a href="#" class="btn btn-link">
                                                <i class="ace-icon fa fa-envelope bigger-125 blue"></i> {{$user->email}}
                                            </a>
                                        </div>

                                        <div class="space-6"></div>


                                    </div>

                                    <div class="hr hr12 dotted"></div>


                                    <div class="clearfix">
                                        <div class="grid2">
                                            <span class="bigger-110 blue"> Active </span>

                                            <br /> Status
                                        </div>

                                        <div class="grid2">
                                            <span class="bigger-110 blue"> 27 </span>

                                            <br /> Age
                                        </div>
                                    </div>

                                    <div class="hr hr16 dotted"></div>
                                </div>


                                <div class="col-xs-12 col-sm-9">
                                    <div id="patient_action_toolbar" class="pull-right tableTools-container">




                                        <a class="btn btn-sm btn-primary btn-white btn-round" href="" title="Edit">
                                            <i class="ace-icon fa fa-envelope bigger-120"></i>
                                            Send Message
                                        </a>

                                        <a class="btn btn-sm btn-primary btn-white btn-round" href="" title="Edit">
                                            <i class="ace-icon fa fa-pencil bigger-120"></i>
                                            Edit Profile
                                        </a>




                                    </div>

                                    <div class="space-12"></div>

                                    <div style="border-top:3px solid #438EB9;"
                                        class="profile-user-info profile-user-info-striped">
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Full Name</div>

                                            <div class="profile-info-value">
                                                <span class="editable" id="username"> {{$user->name()}} </span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Role</div>

                                            <div class="profile-info-value">
                                                <!--  <i class="fa fa-map-marker light-orange bigger-110"></i> -->
                                                <span class="editable" id="country">roles</span>

                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Gender </div>

                                            <div class="profile-info-value">
                                                <span class="editable" id="age">Gender</span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Last login </div>

                                            <div class="profile-info-value">
                                                <span class="editable" id="signup">user last login</span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Is active </div>

                                            <div class="profile-info-value">
                                                <span class="editable" id="login">Active</span>
                                            </div>
                                        </div>



                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Username</div>

                                            <div class="profile-info-value">
                                                <span class="editable" id="about">Username</span>
                                            </div>
                                        </div>


                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Phone </div>

                                            <div class="profile-info-value">
                                                <span class="editable" id="about">Phone</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-20"></div>











                                    <div class="hr hr2 hr-double"></div>




                                </div>
                            </div>
                        </div>

                        <!-- /////////////////////////////////////////////////////////////////////////////////////// -->
                        <table id="dynamic-table" style="border-top:3px solid #438EB9;"
                            class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th colspan="8">
                                        <b>
                                            <i class="fa fa-user"></i>
                                            Client Information </b>
                                    </th>

                                    <th colspan="5">
                                        <b>
                                            <i class="fa fa-list"></i>
                                            Request Information</b>
                                    </th>
                                </tr>
                                <tr style="background-color:lightblue;">
                                    <th>#</th>
                                    <th>Campus</th>
                                    <th>College</th>
                                    <th>Building(Area) </th>
                                    <th>Floor</th>
                                    <th>Office(Dept)</th>
                                    <th>OfficeNo</th>
                                    <th>Problem</th>
                                    <th>RequestTime</th>
                                    <th>ResponseTime</th>
                                    <th>Status</th>



                                    <th>
                                        <i class="ace-icon fa fa-wrench bigger-110"></i>Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> 1 </td>
                                    <td>Main Campus</td>
                                    <td> Notural Science</td>
                                    <td>NS Building</td>
                                    <td>02</td>
                                    <td>Biology Dept </td>

                                    <td> NS-101</td>

                                    <td> Printer Problem</td>
                                    <td>10 Apr,2022 8:00 AM</td>
                                    <td>10 Apr,2022 8:30</td>
                                    <td>Open </td>







                                    <td>
                                        <div class="widget-toolbar no-border">
                                            <div class="inline dropdown-hover">
                                                <button class="btn btn-minier btn-primary">

                                                    <b>
                                                        <i class="ace-icon fa fa-list bigger-110">&nbsp;</i>
                                                        Actions
                                                    </b>
                                                    <i class="ace-icon fa fa-angle-down icon-on-right bigger-110"></i>
                                                </button>

                                                <ul
                                                    class="dropdown-menu dropdown-menu-right dropdown-125 dropdown-lighter dropdown-close dropdown-caret">
                                                    <li>
                                                        <a href="#update-modal" data-toggle='modal'>
                                                            <i class="ace-icon fa fa-pencil bigger-110 ">&nbsp;</i>
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" onclick="">
                                                            <i class="ace-icon fa fa-trash bigger-110 ">&nbsp;</i>
                                                            Delete
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /////////////////////////////////////////////////////////////////////////////////////// -->
                    <!-- PAGE CONTENT ENDS -->
                </div>
                <!-- /.col -->
            </div>



        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-jet-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-jet-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-jet-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-jet-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout> --}}
