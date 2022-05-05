@extends('layouts.guest')
@section('title', 'Application Form')
@push('css')
    <link href="{{ asset('assets/css/pages/wizard/wizard-2.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('js')
    <script src="{{ asset('assets/js/pages/custom/wizard/wizard-2.js') }}"></script>
    <script src="{{ asset('assets/js/pages/custom/profile/profile.js') }}"></script>
    <script>
        $(function() {})
    </script>
    <script>
        $(function() {
            $('#region').select2({
                placeholder: "Select a region"
            });
            $('#gender').select2({
                placeholder: "Select a gender"
            });

            $('#zone').select2({
                placeholder: "Select a zone"
            });

            $('#woreda').select2({
                placeholder: "Select a woreda"
            });

            $('#educational_level').select2({
                placeholder: "Select a Education Level"
            });
            $('#disability').select2({
                placeholder: "Select a Field of Disability"
            });
            $('#field_of_study').select2({
                placeholder: "Select a Field of Study"
            });
            var calendar = $.calendars.instance('ethiopian', 'am');
            $('#dob').calendarsPicker({
                calendar: calendar
            });
        })
    </script>
@endpush
@section('content')

    <div class="container">
        <div class="card card-custom">
            <div class="card-body p-0">
                <!--begin: Wizard-->
                <div class="wizard wizard-2" id="kt_wizard_v2" data-wizard-state="step-first" data-wizard-clickable="false">
                    <!--begin: Wizard Nav-->
                    <div class="wizard-nav border-right py-8 px-8 py-lg-20 px-lg-10">
                        <!--begin::Wizard Step 1 Nav-->
                        <div class="wizard-steps">
                            <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                <div class="wizard-wrapper">
                                    <div class="wizard-icon">
                                        <span class="svg-icon svg-icon-2x">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                                            <i class="fa fa-user"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </div>
                                    <div class="wizard-label">
                                        <h3 class="wizard-title">Basic Information</h3>
                                        <div class="wizard-desc">Fill Information Details</div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Wizard Step 1 Nav-->
                            <!--begin::Wizard Step 2 Nav-->
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-wrapper">
                                    <div class="wizard-icon">
                                        <span class="svg-icon svg-icon-2x">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Map/Compass.svg-->
                                            <i class="fa fa-location-arrow"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </div>
                                    <div class="wizard-label">
                                        <h3 class="wizard-title">Setup Locations</h3>
                                        <div class="wizard-desc">Choose Your Location</div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Wizard Step 2 Nav-->
                            <!--begin::Wizard Step 3 Nav-->
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-wrapper">
                                    <div class="wizard-icon">
                                        <span class="svg-icon svg-icon-2x">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Map/Compass.svg-->
                                            <i class="fa fa-user-graduate"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </div>
                                    <div class="wizard-label">
                                        <h3 class="wizard-title">Educational Document</h3>
                                        <div class="wizard-desc">Upload Educational Document</div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Wizard Step 3 Nav-->
                            <!--begin::Wizard Step 3 Nav-->
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-wrapper">
                                    <div class="wizard-icon">
                                        <span class="svg-icon svg-icon-2x">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Map/Compass.svg-->
                                            <i class="fa fa-ellipsis-h"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </div>
                                    <div class="wizard-label">
                                        <h3 class="wizard-title">Other Documents</h3>
                                        <div class="wizard-desc">Upload other Document</div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Wizard Step 3 Nav-->
                        </div>
                    </div>
                    <!--end: Wizard Nav-->
                    <!--begin: Wizard Body-->
                    <div class="wizard-body py-8 px-8 py-lg-20 px-lg-10">
                        <!--begin: Wizard Form-->
                        <div class="row">
                            <div class="offset-xxl-2 col-xxl-8">
                                <form class="form" id="kt_form">
                                    <!--begin: Wizard Step 1-->
                                    <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                        <h4 class="mb-10 font-weight-bold text-dark">Enter your Basic Details</h4>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right">Photo</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="image-input image-input-outline" id="kt_profile_avatar"
                                                    style="background-image: url({{ asset('user.png') }})">
                                                    <div class="image-input-wrapper"
                                                        style="background-image: url({{ asset('user.png') }})"></div>
                                                    <label
                                                        class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                        data-action="change" data-toggle="tooltip" title=""
                                                        data-original-title="Change avatar">
                                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                                        <input type="file" name="photo" accept=".png, .jpg, .jpeg" />
                                                        <input type="hidden" name="profile_avatar_remove" />
                                                    </label>
                                                    <span
                                                        class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                        data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                    </span>
                                                    <span
                                                        class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                        data-action="remove" data-toggle="tooltip" title="Remove avatar">
                                                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                    </span>
                                                </div>
                                                <span class="form-text text-muted">Allowed file types: png, jpg,
                                                    jpeg.</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!--begin::Input-->
                                            <div class="form-group col-md-6">
                                                <label>First Name</label>
                                                <input type="text" class="form-control form-control-solid form-control-lg"
                                                    name="first_name" placeholder="First Name"
                                                    value="{{ old('first_name') }}" />
                                                <span class="form-text text-muted">Please enter your first name.</span>
                                            </div>
                                            <!--end::Input-->
                                            <!--begin::Input-->
                                            <div class="form-group col-md-6">
                                                <label>Father Name</label>
                                                <input type="text" class="form-control form-control-solid form-control-lg"
                                                    name="father_name" placeholder="Father Name"
                                                    value="{{ old('father_name') }}" />
                                                <span class="form-text text-muted">Please enter your father name.</span>
                                            </div>
                                            <!--end::Input-->
                                            <!--begin::Input-->
                                            <div class="form-group col-md-6">
                                                <label>Grand Father Name</label>
                                                <input type="text" class="form-control form-control-solid form-control-lg"
                                                    name="grand_father_name" placeholder="Grand Father Name"
                                                    value="{{ old('grand_father_name') }}" />
                                                <span class="form-text text-muted">Please enter your grand father
                                                    name.</span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Date Of Birth</label>
                                                    <input type="text" id="dob"
                                                        class="form-control form-control-solid form-control-lg" name="dob"
                                                        placeholder="Date of Birth" autocomplete="off"
                                                        value="{{ old('dob') }}" />
                                                    <span class="form-text text-muted">Please enter your date of
                                                        birth.</span>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-6">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label>Gender</label>
                                                    <select name="gender" id="gender"
                                                        class="form-control form-control-solid form-control-lg">
                                                        <option value="">Select</option>
                                                        <option value="M">Male</option>
                                                        <option value="F">Female</option>
                                                    </select>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Phone</label>
                                                    <input type="tel"
                                                        class="form-control form-control-solid form-control-lg" name="phone"
                                                        placeholder="Phone" value="{{ old('phone') }}" />
                                                    <span class="form-text text-muted">Please enter your phone
                                                        number.</span>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email"
                                                        class="form-control form-control-solid form-control-lg" name="email"
                                                        placeholder="Email" value="{{ old('email') }}" />
                                                    <span class="form-text text-muted">Please enter your email
                                                        address.</span>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-12">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Disablity</label>
                                                    <select name="disability" id="disability"
                                                        class="form-control form-control-solid form-control-lg">
                                                        <option value="">Select</option>

                                                    </select>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Wizard Step 1-->
                                    <!--begin: Wizard Step 2-->
                                    <div class="pb-5" data-wizard-type="step-content">
                                        <h4 class="mb-10 font-weight-bold text-dark">Setup Your Current Location &amp;
                                            Contact Info</h4>
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label>Region</label>
                                                    <select name="region" id='region'
                                                        class="form-control form-control-solid form-control-md">
                                                        <option value="">Select</option>
                                                        <option value="ZW">Zimbabwe</option>
                                                    </select>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-4">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label>Zone&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                    <select name="zone" id="zone"
                                                        class="form-control form-control-solid form-control-lg">
                                                        <option value="">Select</option>
                                                        <option value="ZW">Zimbabwe</option>
                                                    </select>
                                                </div>
                                                <!--end::Input-->
                                            </div>

                                            <div class="col-xl-4">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label>Woreda</label>
                                                    <select name="woreda" id="woreda"
                                                        class="form-control form-control-solid form-control-lg">
                                                        <option value="">Select</option>
                                                        <option value="ZW">Zimbabwe</option>
                                                    </select>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Wizard Step 2-->

                                    <!--begin: Wizard Step 3-->
                                    <div class="pb-5" data-wizard-type="step-content">
                                        <h4 class="mb-10 font-weight-bold text-dark">Educational Document</h4>
                                        <div class="row">
                                            <div class="col-xl-5">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label>Educational Level</label>
                                                    <select name="educational_level" id="educational_level"
                                                        class="form-control form-control-solid form-control-lg">
                                                        <option value="">Select</option>
                                                        <option value="ZW">Zimbabwe</option>
                                                    </select>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-5">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label>Field of Study</label>
                                                    <select name="field_of_study" id="field_of_study"
                                                        class="form-control form-control-solid form-control-lg">
                                                        <option value="">Select</option>
                                                        <option value="ZW">Zimbabwe</option>

                                                    </select>
                                                </div>
                                                <!--end::Input-->
                                            </div>

                                            <div class="col-xl-2">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label>GPA</label>
                                                    <input name="gpa" id="gpa" class="form-control form-control-lg"
                                                        type="number" max="4" min="1" />
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label>Ministry Document</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            name="ministry_document" id="ministry_document" />
                                                        <label class="custom-file-label" for="customFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label>BSC Document</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="bsc_document"
                                                            id="bsc_document" />
                                                        <label class="custom-file-label" for="customFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xl-12">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label>MSC Document</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="msc_document"
                                                            id="msc_document" />
                                                        <label class="custom-file-label" for="customFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xl-12">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label>PHD Document</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="phd_document"
                                                            id="phd_document" />
                                                        <label class="custom-file-label" for="customFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Wizard Step 3-->

                                    <!--begin: Wizard Step 4-->
                                    <div class="pb-5" data-wizard-type="step-content">
                                        <h4 class="mb-10 font-weight-bold text-dark">Other Mandatory Documents</h4>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label>Contact Name</label>
                                                    <input type="text" name="contact_name" id="contact_name"
                                                        class="form-control form-control-solid form-control-md">
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-6">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label>Contact Phone</label>
                                                    <input type="tel" name="contact_phone" id="contact_phone"
                                                        class="form-control form-control-solid form-control-md">
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label>Kebele Id</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="kebele_id"
                                                            id="kebele_id" />
                                                        <label class="custom-file-label" for="customFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label>Ethical Licence</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="ethical_license"
                                                            id="ethical_license" />
                                                        <label class="custom-file-label" for="customFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xl-12">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label>Non Pregnancy Medicaid Approval</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            name="non_pregnant_validation_document"
                                                            id="non_pregnant_validation_document" />
                                                        <label class="custom-file-label" for="customFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Wizard Step 4-->

                                    <!--begin: Wizard Actions-->
                                    <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                        <div class="mr-2">
                                            <button class="btn btn-light-primary font-weight-bold text-uppercase px-9 py-4"
                                                data-wizard-type="action-prev">Previous</button>
                                        </div>
                                        <div>
                                            <button class="btn btn-success font-weight-bold text-uppercase px-9 py-4"
                                                data-wizard-type="action-submit">Submit</button>
                                            <button class="btn btn-primary font-weight-bold text-uppercase px-9 py-4"
                                                data-wizard-type="action-next">Next Step</button>
                                        </div>
                                    </div>
                                    <!--end: Wizard Actions-->
                                </form>
                            </div>
                            <!--end: Wizard-->
                        </div>
                    </div>
                    <!--end: Wizard Body-->
                </div>
                <!--end: Wizard-->
            </div>
        </div>
    </div>

@endsection
