@extends('layouts.guest')
@section('title', 'Application Form')
@push('css')
    <link href="{{ asset('assets/css/pages/wizard/wizard-2.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .select2,
        .select2-container,
        .select2-container--default,
        .select2-container--below {
            width: 100% !important;
        }

    </style>
@endpush
@push('js')
    <script>
        var MinDob = '{{ $after }}';
        var MaxDob = '{{ $before }}';
    </script>
    <script src="{{ asset('assets/js/pages/custom/wizard/wizard-2.js') }}"></script>
    <script src="{{ asset('assets/js/pages/custom/profile/profile.js') }}"></script>

    <script>
        $(function() {
            $('#agree_check').on('click', function() {
                if ($('input#agree_check')[0].checked) {
                    $('button#next_step_button').prop('disabled', false);
                    $('button#submit_apply_button').prop('disabled', false);
                } else {
                    $('button#next_step_button').prop('disabled', true);
                    $('button#submit_apply_button').prop('disabled', true);
                }
            })
        })
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
    <script>
        $(document).ready(function() {
                    @if (old('region'))
                        $("#zone").html('');
                        var oldZone = {{ old('zone') }};
                        $.ajax({
                                url: "/api/region/" + oldZone + "/zone",
                                type: "GET",
                                data: {
                                    service_id: oldZone,
                                    _token: '{{ csrf_token() }}'
                                },
                                dataType: 'json',
                                success: function(result) {
                                    // $('#zone').html(
                                    // '<option value="">Select Zone</option>');
                                    $.each(result.data, function(key, value) {
                                            $("#zone").append('<option ' + oldZone + '==' + value.id + '
                                                value = "' + value
                                                .id + '">
                                                ' +
                                                value.name + ' < /
                                                option > ');
                                            }); $('#woreda').html(
                                            '<option value="">Select Woreda</option>');
                                    }
                                });
                        @endif
                        @if (old('woreda'))
                            $("#woreda").html('');
                            $('#woreda').html('<option value="">Select Woreda</option>');
                            var oldZone = {{ old('zone') }};
                            var oldWoreda = {{ old('woreda') }};
                            $.ajax({
                                    url: "/api/zone/" + oldZone + "/woreda",
                                    type: "GET",
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    dataType: 'json',
                                    success: function(result) {
                                        $.each(result.data, function(key, value) {
                                                var isSelected = value.id == oldWoreda ? 'selected' : '';
                                                $("#woreda").append('<option ' + isSelected + '
                                                    value = "' + value
                                                    .id + '">
                                                    ' +
                                                    value.name + ' < /
                                                    option > ');
                                                });
                                        }
                                    });
                            @endif
                            $('#region').on('change', function() {
                                var itemId = this.value;
                                var regionName = $("#region option:selected").text();
                                regionName = regionName.trim();
                                // $('#payment_service_name').text(regionName);
                                $("#zone").html('');
                                $.ajax({
                                    url: "/api/region/" + itemId + "/zone",
                                    type: "GET",
                                    data: {
                                        service_id: itemId,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    dataType: 'json',
                                    success: function(result) {
                                        $('#zone').html(
                                            '<option value="">Select Zone</option>');
                                        $.each(result.data, function(key, value) {
                                            $("#zone").append('<option value="' + value
                                                .id + '">' + value.name + '</option>');
                                        });
                                        $('#woreda').html(
                                            '<option value="">Select Woreda</option>');
                                    }
                                });
                            });
                            $('#zone').on('change', function() {
                                var itemId = this.value;
                                var zoneName = $("#zone option:selected").text();
                                zoneName = zoneName.trim();
                                $("#woreda").html('');
                                $.ajax({
                                    url: "/api/zone/" + itemId + "/woreda",
                                    type: "GET",
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    dataType: 'json',
                                    success: function(result) {
                                        $('#woreda').html(
                                            '<option value="">Select Woreda</option>');
                                        $.each(result.data, function(key, value) {
                                            $("#woreda").append('<option value="' + value
                                                .id + '">' + value.name + '</option>');
                                        });
                                    }
                                });
                            });
                        });
    </script>
    <script>
        $(function() {
            $('#educational_level').on('change', function() {
                var itemId = this.value;
                var regionName = $("#educational_level option:selected").text();
                if (itemId == 1) {
                    $('#msc_document_form_group').removeClass('d-none');
                    $('#phd_document_form_group').addClass('d-none');
                } else if (itemId == 2) {
                    $('#msc_document_form_group').removeClass('d-none');
                    $('#phd_document_form_group').removeClass('d-none');
                } else {
                    $('#msc_document_form_group').addClass('d-none');
                    $('#phd_document_form_group').addClass('d-none');
                }
                regionName = regionName.trim();
            });
        });
        $('#gender').on('change', function() {
            var itemId = this.value;
            if (itemId == 'F') {
                $('#non_pregnant_validation_document_form_group').removeClass('d-none');
            } else {
                $('#non_pregnant_validation_document_form_group').addClass('d-none');
            }

        });
    </script>
@endpush
@section('content')

    <div class="container">
        <div class="card card-custom">
            <div class="card-body p-0">
                <!--begin: Wizard-->
                <div class="wizard wizard-2" id="kt_wizard_v2" data-wizard-state="step-first" data-wizard-clickable="false">
                    <!--begin: Wizard Nav-->
                    <div class="wizard-nav border-right py-8 px-8 px-lg-10">
                        <div class="wizard-steps">
                            <!--begin::Wizard Step 1 Nav-->
                            <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                <div class="wizard-wrapper">
                                    <div class="wizard-icon">
                                        <span class="svg-icon svg-icon-2x">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                                            <i class="fa fa-check-circle"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </div>
                                    <div class="wizard-label">
                                        <h3 class="wizard-title"> </h3>Application Requirements </h3>
                                        <div class="wizard-desc">Code of conduct</div>
                                    </div>
                                </div>
                            </div>
                            <div class="wizard-step" data-wizard-type="step">
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
                    <div class="wizard-body py-8 px-8 px-lg-10">
                        <!--begin: Wizard Form-->
                        <div class="row">
                            <div class="offset-xxl-2 col-xxl-8">
                                <form class="form" action="{{ route('aplication.apply', []) }}"
                                    enctype="multipart/form-data" method="POST" id="kt_form">
                                    @csrf
                                    <!--begin: Wizard Step 0-->
                                    <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                        <h4 class="mb-10 font-weight-bold text-dark">Code of Conduct</h4>
                                        <div class="row">
                                            <div data-scroll="true" class="scroll scroll-pull"
                                                style="max-height:350px !important; overflow:auto;">

                                                <p>
                                                    የብሄራዊ በጎ ፈቃድ _ አገልግሎት ማህበረሰብ _ አገልግሎት ፕሮግራም ተሳታፊ ወጣቶች መመልመያ መስፈርቶች
                                                    የብሄራዊ በጎ ፈቃድ ማህበረሰብ ልማት አገልግሎት ስልጠና በአገር አቀፍ ደረጃ በ10ሩ የክልል መስተዳድሮችና በ2ቱ
                                                    የከተማ
                                                    መስተዳድሮች የሚገኙ ወጣት የበጎ ፈቃደኞችን የሚያካትት ሲሆን ለዚህ የበጎ ፈቃድ ማህበረሰብ አገልግሎት ለመመዝገብ
                                                    የሚያስፈልጉ መስፈርቶች የተመዝጋቢወችን ሙሉ ማንነት የሚያሳይ መጠይቅ እንዲኖረዉ ይፈለጋል
                                                </p>
                                                <div class="separator separator-solid"></div>
                                                <div>
                                                    <ol type="1" class='list'>
                                                        <li> በአገር አቀፍ ደረጃ ከሚገኙ ህጋዊ የከፍተኛ የትምህርት ተቋማት የመጀመሪያ ድግሪና ከዚያ በላይ፤
                                                        </li>
                                                        <li> የ8ኛ ክፍል ብሄራዊ ፈተና ያጠናቀቁበትን ሰርተፍኬት ያለዉ/ያላት </li>
                                                        <li> ዕድሜዉ ከ35 ዓመት ያልበለጠዉ/ያልበለጣት፤ </li>
                                                        <li> ከሚኖርበት/ከምትኖርበት ቦታ ትክክለኛ እና ተመዝጋቢዉን የሚገልፅ የታደሰ መታወቂያ ያለዉ/ያላት
                                                        </li>
                                                        <li> ካለበት ማህበረሰብ ጥሩ ስነ-ምግባር ያለዉ/ያላት የስነ-ምግባር የህይወት ምስክርነት ማቅረብ
                                                            የሚችል/የምትችል፤</li>
                                                        <li> ከማንዉም አይነት ደባል ሱስ ነጻ የሆነ/ች </li>
                                                        <li> ለድንበር የለሽ የበጎ ፈቃድ ማህበረሰብ አገልግሎት ራሱን ያዘጋጀና ቁርጠኛ የሆነ/ሆነች </li>
                                                        <li> የበጎ ፈቃድ ማህበረሰብ አገልግሎ ፕሮግራም ላይ እምነት ያለዉ/ያላት! </li>
                                                        <li> ከአገራችን እሴቶች መካከል የመስጠት የማካፈል እና ሰብዓዊነት የተላበስ ማንነት ያለዉ/ያላት፧
                                                        </li>
                                                        <li> የጤንነት ችግር የሌለበትና በየኛዉም አየር ንብረት ክፍል አካባቢ መሰልጠንና መስራት የሚችል/የምትችል
                                                        </li>
                                                        <li> ለሴት በጎ ፈቃድ ማህበረሰብ አገልግሎ ተመዝጋቢ ነፍሰ ጡር ያልሆነች ማሳሰቢያ </li>
                                                    </ol>
                                                </div>
                                                <p>
                                                    ከዚህ ቀደም በ3 ዙር ተመልምለዉ ለስልጠና የተመረጡ ግን ያልተሳተፉ በዚህ ዙር ተሳታፊ አይሆኑም!
                                                    መረጃዎች ሲሞሉ ሙሉ በሙሉ fእንግሊዘኛ ቋንቋ ሆኖ የጠራ መሆን አለበት የበጎ ፈቃደኞች ማስረጃዎች በሶፍት ኮፒ
                                                    ተዘጋጅተዉ
                                                    መላክ ይኖርባቸዋል
                                                </p>
                                            </div>

                                            <div class="mt-2">
                                                <div class="form-group">
                                                    <label class="checkbox">
                                                        <input type="checkbox"
                                                            {{ old('agree_check') == 'on' ? 'checked' : '' }}
                                                            name="agree_check" id="agree_check">
                                                        I Accepted all <a href="{{ route('terms') }}" target="_blank">
                                                            terms of conditions </a>
                                                        <span>

                                                        </span>

                                                    </label>
                                                    @error('agree_check')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Wizard Step 0-->
                                    <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                        <h4 class="mb-10 font-weight-bold text-dark">Enter your Basic Details</h4>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right">My Photo</label>
                                            <div class="col-lg-9 mx-auto col-xl-6">
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
                                            @error('photo')
                                                <div class="invalid-feedback d-block text-center">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="row">
                                            <!--begin::Input-->
                                            <div class="form-group col-md-6 ">
                                                <label class="d-block">First Name</label>
                                                <input type="text"
                                                    class="@error('first_name') is-invalid @enderror form-control  form-control-lg"
                                                    name="first_name" placeholder="First Name"
                                                    value="{{ old('first_name') }}" />
                                                @error('first_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <span class="form-text text-muted">Please enter your first name.</span>
                                            </div>
                                            <!--end::Input-->
                                            <!--begin::Input-->
                                            <div class="form-group col-md-6">
                                                <label class="d-block">Father Name</label>
                                                <input type="text"
                                                    class="@error('father_name') is-invalid @enderror form-control form-control-lg"
                                                    name="father_name" placeholder="Father Name"
                                                    value="{{ old('father_name') }}" />
                                                @error('father_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <span class="form-text text-muted">Please enter your father name.</span>
                                            </div>
                                            <!--end::Input-->
                                            <!--begin::Input-->
                                            <div class="form-group col-md-6">
                                                <label class="d-block">Grand Father Name</label>
                                                <input type="text"
                                                    class="@error('grand_father_name') is-invalid @enderror form-control form-control-lg"
                                                    name="grand_father_name" placeholder="Grand Father Name"
                                                    value="{{ old('grand_father_name') }}" />
                                                @error('grand_father_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <span class="form-text text-muted">Please enter your grand father
                                                    name.</span>
                                            </div>
                                            <!--end::Input-->
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label class="d-block">Disablity</label>
                                                    <select name="disability" id="disability"
                                                        class="@error('disability') is-invalid @enderror form-control form-control-lg">
                                                        <option value="">Select</option>
                                                        @foreach ($disabilities as $disable)
                                                            <option value="{{ $disable->id }}">{{ $disable->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('disability')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <span class="form-text text-muted">Please select if any
                                                        disability</span>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label class="d-block">Date Of Birth</label>
                                                    <input type="text" id="dob"
                                                        class="@error('dob') is-invalid @enderror form-control form-control-lg"
                                                        name="dob" placeholder="Date of Birth" autocomplete="off"
                                                        value="{{ old('dob') }}" />
                                                    @error('dob')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <span class="form-text text-muted">Please enter your date of
                                                        birth.</span>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-6">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label class="d-block">Gender</label>
                                                    <select name="gender" id="gender"
                                                        class="@error('gender') is-invalid @enderror form-control form-control-lg">
                                                        <option value="">Select</option>
                                                        <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>
                                                            Male
                                                        </option>
                                                        <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>
                                                            Female
                                                        </option>
                                                    </select>
                                                    @error('gender')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <span class="form-text text-muted">Please select your gender.</span>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label class="d-block">Phone</label>
                                                    <input type="tel"
                                                        class="@error('phone') is-invalid @enderror form-control form-control-lg"
                                                        name="phone" placeholder="Phone" value="{{ old('phone') }}" />
                                                    @error('phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <span class="form-text text-muted">Please enter your phone
                                                        number.</span>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label class="d-block">Email</label>
                                                    <input type="email"
                                                        class="@error('email') is-invalid @enderror form-control form-control-lg"
                                                        name="email" placeholder="Email" value="{{ old('email') }}" />
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <span class="form-text text-muted">Please enter your email
                                                        address.</span>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 form-group">
                                                <x-jet-label for="password" value="{{ __('Password') }}" />
                                                <input id="password"
                                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                                    type="password" placeholder="Password" name="password" requiredd
                                                    autocomplete="new-password" />
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-xl-6 form-group">
                                                <x-jet-label for="password_confirmation"
                                                    value="{{ __('Confirm Password') }}" />
                                                <input id="password_confirmation"
                                                    class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                                                    type="password" placeholder="Confirm Password"
                                                    name="password_confirmation" requiredd autocomplete="new-password" />
                                                @error('password_confirmation')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
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
                                                    <label class="d-block">Region</label>
                                                    <select name="region" id='region'
                                                        class="@error('region') is-invalid @enderror form-control d-block form-control-solid">
                                                        <option value="">Select</option>
                                                        @foreach ($regions as $region)
                                                            <option {{ old('region') == $region->id ? 'selected' : '' }}
                                                                value="{{ $region->id }}">{{ $region->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('region')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-4">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label class="d-block">Zone</label>
                                                    <select name="zone" id="zone"
                                                        class="@error('zone') is-invalid @enderror form-control form-control-lg">
                                                        <option value="">Select</option>
                                                    </select>
                                                    @error('zone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--end::Input-->
                                            </div>

                                            <div class="col-xl-4">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label class="d-block">Woreda</label>
                                                    <select name="woreda" id="woreda"
                                                        class="@error('woreda') is-invalid @enderror form-control form-control-lg">
                                                        <option value="">Select</option>
                                                    </select>
                                                    @error('woreda')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
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
                                                    <label class="d-block">Educational Level</label>
                                                    <select name="educational_level" id="educational_level"
                                                        class="@error('educational_level') is-invalid @enderror form-control form-control-lg">
                                                        <option value="">Select</option>
                                                        @foreach ($educationLevels as $key => $level)
                                                            <option
                                                                {{ old('educational_level') != null && old('educational_level') == $key ? 'selected' : '' }}
                                                                value="{{ $key }}">{{ $level }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('educational_level')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-5">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label class="d-block">Field of Study</label>
                                                    <select name="field_of_study" id="field_of_study"
                                                        class="@error('field_of_study') is-invalid @enderror form-control form-control-lg">
                                                        <option value="">Select</option>
                                                        @foreach ($fields as $field)
                                                            <option
                                                                {{ old('field_of_study') == $field->id ? 'selected' : '' }}
                                                                value="{{ $field->id }}">{{ $field->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('field_of_study')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-2">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label class="d-block">GPA</label>
                                                    <input name="gpa" id="gpa"
                                                        class="@error('gpa') is-invalid @enderror form-control"
                                                        type="number" value="{{ old('gpa') }}" max="4" min="1" />

                                                    @error('gpa')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label class="d-block">Ministry Document</label>
                                                    <div class="custom-file">
                                                        <input type="file"
                                                            class="@error('ministry_document') is-invalid @enderror  custom-file-input"
                                                            name="ministry_document" id="ministry_document" />
                                                        <label class="custom-file-label" for="customFile">Choose
                                                            file</label>
                                                        @error('ministry_document')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>


                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-6">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label class="d-block">BSC Document</label>
                                                    <div class="custom-file">
                                                        <input type="file"
                                                            class="@error('bsc_document') is-invalid @enderror custom-file-input"
                                                            name="bsc_document" id="bsc_document" />
                                                        <label class="custom-file-label" for="customFile">Choose
                                                            file</label>
                                                        @error('bsc_document')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xl-6 {{ old('educational_level') == 1 || old('educational_level') == 2 ? '' : 'd-none' }}"
                                                id="msc_document_form_group">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label class="d-block">MSC Document</label>
                                                    <div class="custom-file">
                                                        <input type="file"
                                                            class="@error('msc_document') is-invalid @enderror custom-file-input"
                                                            name="msc_document" id="msc_document" />
                                                        <label class="custom-file-label" for="customFile">Choose
                                                            file</label>
                                                        @error('msc_document')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-6">
                                                <!--begin::Select-->
                                                <div class="form-group {{ old('educational_level') == 2 ? '' : 'd-none' }}"
                                                    id="phd_document_form_group">
                                                    <label class="d-block">PHD Document</label>
                                                    <div class="custom-file">
                                                        <input type="file"
                                                            class="@error('phd_document') is-invalid @enderror custom-file-input"
                                                            name="phd_document" id="phd_document" />
                                                        <label class="custom-file-label" for="customFile">Choose
                                                            file</label>
                                                        @error('phd_document')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
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
                                                    <label class="d-block">Contact Name</label>
                                                    <input type="text" value="{{ old('contact_name') }}"
                                                        name="contact_name" id="contact_name"
                                                        class="@error('contact_name') is-invalid @enderror form-control form-control-md">
                                                    @error('contact_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-6">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label class="d-block">Contact Phone</label>
                                                    <input type="tel" value="{{ old('contact_phone') }}"
                                                        name="contact_phone" id="contact_phone"
                                                        class="@error('contact_phone') is-invalid @enderror form-control form-control-md">
                                                    @error('contact_phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label class="d-block">Kebele Id</label>
                                                    <div class="custom-file">
                                                        <input type="file"
                                                            class="@error('kebele_id') is-invalid @enderror custom-file-input"
                                                            name="kebele_id" id="kebele_id" />
                                                        <label class="custom-file-label" for="customFile">Choose
                                                            file</label>
                                                        @error('kebele_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!--end::Input-->
                                            </div>

                                            <div class="col-xl-6">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label class="d-block">Ethical Licence</label>
                                                    <div class="custom-file">
                                                        <input type="file"
                                                            class="@error('ethical_license') is-invalid @enderror custom-file-input"
                                                            name="ethical_license" id="ethical_license" />
                                                        <label class="custom-file-label" for="customFile">Choose
                                                            file</label>
                                                        @error('ethical_license')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <!--begin::Select-->
                                                <div class="form-group {{ old('gender') == 'F' ? '' : 'd-none' }}"
                                                    id="non_pregnant_validation_document_form_group">
                                                    <label class="d-block">Non Pregnancy Medicaid Approval</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            name="non_pregnant_validation_document"
                                                            id="non_pregnant_validation_document" />
                                                        <label
                                                            class="@error('non_pregnant_validation_document') is-invalid @enderror custom-file-label"
                                                            for="customFile">Choose
                                                            file</label>
                                                        @error('non_pregnant_validation_document')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="form-group">
                                                <label class="">
                                                    By clicking Apply, you agree to our <a href="#"><b>Terms</b></a>, and <a
                                                        href="#"><b>Conditions</b></a>. You may receive <b>Email</b>
                                                    Notifications from us and can opt out any time.
                                                </label>
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
                                            <button onclick="event.preventDefault();"
                                                class="btn btn-success font-weight-bold text-uppercase px-9 py-4"
                                                data-wizard-type="action-submit" id="submit_apply_button"
                                                style="min-width: 150px; background-color:rgb(249 ,92 ,57);color:white;font-weight:bold;">Apply</button>
                                            <button {{ old('agree_check') == 'on' ? '' : '' }}
                                                class="btn btn-primary font-weight-bold text-uppercase px-9 py-4"
                                                data-wizard-type="action-next" id="next_step_button">Next Step</button>
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
