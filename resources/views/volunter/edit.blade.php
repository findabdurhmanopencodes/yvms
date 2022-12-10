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
            $("#graduation_date").datepicker({
                format: "yyyy",
                orientation: "bottom right",
                todayHighlight: true,
                viewMode: "years",
                minViewMode: "years",
                startDate: '{{ Andegna\DateTimeFactory::fromDateTime(Carbon\Carbon::now()->subYear(35))->format('Y') }}',
                endDate: '{{ Andegna\DateTimeFactory::fromDateTime(Carbon\Carbon::now()->subYear(0))->format('Y') }}',
                autoclose: true //to close picker once year is selected
            });
            $('#agree_check').on('click', function() {
                if ($('input#agree_check')[0].checked) {
                    $('button#next_step_button').prop('disabled', false);
                    $('button#submit_apply_button').prop('disabled', false);
                } else {
                    $('button#next_step_button').prop('disabled', true);
                    $('button#submit_apply_button').prop('disabled', true);
                }
            })
            $('#agree_check_first').on('click', function() {
                if ($('input#agree_check_first')[0].checked) {
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
            $('[name="first_name"]').on('change', function() {
                var firstName = $('[name="first_name"]').val();
                var fatherName = $('[name="father_name"]').val();
                var grandFatherName = $('[name="grand_father_name"]').val();
                $('#reviewFullName').text(firstName + ' ' + fatherName + ' ' + grandFatherName);
            });
            $('[name="father_name"]').on('change', function() {
                var firstName = $('[name="first_name"]').val();
                var fatherName = $('[name="father_name"]').val();
                var grandFatherName = $('[name="grand_father_name"]').val();
                $('#reviewFullName').text(firstName + ' ' + fatherName + ' ' + grandFatherName);
            });
            $('[name="grand_father_name"]').on('change', function() {
                var firstName = $('[name="first_name"]').val();
                var fatherName = $('[name="father_name"]').val();
                var grandFatherName = $('[name="grand_father_name"]').val();
                $('#reviewFullName').text(firstName + ' ' + fatherName + ' ' + grandFatherName);
            });
            $('[name="phone"]').on('change', function() {
                var phone = $('[name="phone"]').val();
                $('#reviewPhone').text(phone);
            });
            $('[name="email"]').on('change', function() {
                var email = $('[name="email"]').val();
                $('#reviewEmail').text(email);
            });
            $('[name="dob"]').on('change', function() {
                var dob = $('[name="dob"]').val();
                $('#reviewDOB').text(dob);
            });
            $('[name="gender"]').on('change', function() {
                var gender = $('[name="gender"]').val() == 'M' ? 'Male' : 'Female';
                $('#reviewGender').text(gender);
            });

            $('[name="region"]').on('change', function() {
                var value = $("#region option:selected").text();
                $('#reviewRegion').text(value);
            });

            $('[name="zone"]').on('change', function() {
                var value = $("#zone option:selected").text();
                $('#reviewZone').text(value);
            });

            $('[name="woreda"]').on('change', function() {
                var value = $("#woreda option:selected").text();
                $('#reviewWoreda').text(value);
            });

            $('[name="educational_level"]').on('change', function() {
                var value = $("#educational_level option:selected").text();
                $('#reviewEducationLevel').text(value);
            });

            $('[name="field_of_study"]').on('change', function() {
                var value = $("#field_of_study option:selected").text();
                $('#reviewFieldOfStudy').text(value);
            });

            $('[name="contact_name"]').on('change', function() {
                var value = $("#contact_name").val();
                $('#reviewContactName').text(value);
            });

            $('[name="contact_phone"]').on('change', function() {
                var value = $("#contact_phone").val();
                $('#reviewContactPhone').text(value);
            });

            $('[name="gpa"]').on('change', function() {
                var value = $("#gpa").val();
                $('#reviewGPA').text(value);
            });
        });
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
                        var oldZone = '{{ old('zone') }}';
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
                                            // $("#zone").append('<option '+(oldZone==value.id ?'selected':' ') + '
                                            //     value = "' + value
                                            //     .id + '">
                                            //     ' +
                                            //     value.name + ' < /
                                            //     option > ');
                                            // });
                                            $('#woreda').html(
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
                                                    var isSelected = value.id == oldWoreda ? 'selected' :
                                                        '';
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
                                                    .id + '">' + value.name +
                                                    '</option>');
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
                                                $("#woreda").append('<option value="' +
                                                    value
                                                    .id + '">' + value.name +
                                                    '</option>');
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
                                            <i class="fas fa-user-tag"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </div>
                                    <div class="wizard-label">
                                        <h3 class="wizard-title"> </h3>Objective &amp; Responsibility </h3>
                                        <div class="wizard-desc">Role &amp; Responsibility</div>
                                    </div>
                                </div>
                            </div>
                            <div class="wizard-step" data-wizard-type="step">
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
                                        <div class="wizard-desc">Application Requirements</div>
                                    </div>
                                </div>
                            </div>
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-wrapper">
                                    <div class="wizard-icon">
                                        <span class="svg-icon svg-icon-2x">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                                            <i class="fa fa-file-user"></i>
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
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-wrapper">
                                    <div class="wizard-icon">
                                        <span class="svg-icon svg-icon-2x">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Map/Compass.svg-->
                                            <i class="fas fa-thumbs-up"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </div>
                                    <div class="wizard-label">
                                        <h3 class="wizard-title">Completed</h3>
                                        <div class="wizard-desc">Review and Submit</div>
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
                                <form class="form" action="{{ route('session.applicant.update', ['training_session' => Request::route('training_session'), 'applicant' => $volunteer->id]) }}"
                                    enctype="multipart/form-data" method="POST" id="kt_form">
                                    @csrf
                                    @method('PUT')
                                    <!--begin: Wizard Step 0-->
                                    <div class="card card-custom" data-wizard-type="step-content"
                                        data-wizard-state="current">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h4 class="card-label font-weight-bold text-dark">Objectives &amp;
                                                    Responsibility</h4>
                                            </div>
                                            <div class="card-toolbar">
                                                <ul class="nav nav-tabs nav-bold nav-tabs-line">
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                                                            role="button" aria-haspopup="true"
                                                            aria-expanded="false">Language</a>
                                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                            @foreach ($objectiveTexts as $key => $objectiveText)
                                                                <a class="dropdown-item" data-toggle="tab"
                                                                    href="#lang_obj_{{ $objectiveText->id }}">
                                                                    {{ $objectiveText->language->name }}
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div data-scroll="true" class="scroll scroll-pull"
                                                    style="max-height:350px !important; overflow:auto;">
                                                    <div class="tab-content mt-5" id="myTabContent">
                                                        {{-- <div class="tab-pane fade show active" id="lang_en" role="tabpanel"
                                                            aria-labelledby="lang_en">
                                                            <h3>Objectives</h3>
                                                            <p>
                                                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                                Laboriosam
                                                                voluptates, obcaecati tempore asperiores nostrum ipsa eum
                                                                recusandae
                                                                dolorum eos. Itaque voluptatum iure est fugit sapiente quis
                                                                quam
                                                                odio
                                                                officia mollitia vel quo cumque ipsa, maxime blanditiis
                                                                minus,
                                                                accusantium quas enim reprehenderit. Commodi placeat
                                                                dignissimos
                                                                sunt
                                                                animi voluptates quidem quasi! Laborum, temporibus a!
                                                                Excepturi
                                                                ipsa,
                                                                minus veniam numquam suscipit eligendi adipisci possimus
                                                                quae
                                                                dolore,
                                                                voluptas facere, non odio velit molestias at quisquam?
                                                                Cupiditate
                                                                natus
                                                                error laborum enim ea numquam laudantium dolores suscipit
                                                                placeat
                                                                illo.
                                                                Consequatur officiis repellat, quam ex cupiditate excepturi
                                                                deleniti
                                                                distinctio sint architecto sequi, repellendus autem velit
                                                                praesentium
                                                                saepe?
                                                            </p>
                                                            <h3>Responsibilities</h3>
                                                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                                                                Odit quam
                                                                voluptatum porro est obcaecati! Nostrum labore inventore,
                                                                quia
                                                                recusandae dolor laboriosam aperiam aut molestiae facilis
                                                                excepturi
                                                                aliquam, fuga ipsam iste soluta quos consectetur
                                                                reprehenderit
                                                                mollitia
                                                                est suscipit, dolores quasi? Deleniti provident nemo numquam
                                                                vel ea
                                                                sint
                                                                totam, eveniet, beatae commodi odit sequi. Neque natus, enim
                                                                nesciunt
                                                                fugit aspernatur hic vero tempora quod earum harum
                                                                reprehenderit
                                                                dolores
                                                                consequuntur magni provident rerum? Officiis exercitationem
                                                                eius
                                                                corrupti dolores voluptatum? Officiis nesciunt praesentium
                                                                ipsa
                                                                iusto
                                                                amet ratione facilis. Soluta, dolorem! Quaerat atque neque
                                                                repellat
                                                                a
                                                                earum molestias debitis, exercitationem ex hic eius.
                                                                Repellat,
                                                                tenetur.
                                                            </p>
                                                        </div> --}}
                                                        @foreach ($objectiveTexts as $key => $objectiveText)
                                                            <div class="tab-pane fade {{ $key == 0 ? ' show active' : '' }}"
                                                                id="lang_obj_{{ $objectiveText->id }}" role="tabpanel"
                                                                aria-labelledby="lang_obj_{{ $objectiveText->id }}">
                                                                {!! $objectiveText->content !!}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" card-footer p-0 pt-4 pl-4 pb-0">
                                            <div class="form-group mb-0">
                                                <label class="checkbox" id="agree_check_first_label">
                                                    <input type="checkbox" checked
                                                        {{ old('agree_check_first') == 'on' ? 'checked' : '' }}
                                                        name="agree_check_first" id="agree_check_first"> I Accepted to above
                                                    objectives and responsibilities
                                                    <span>
                                                    </span>
                                                </label>
                                                @error('agree_check_first')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pb-5 card card-custom" data-wizard-type="step-content"
                                        data-wizard-state="current">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h4 class="mb-10 font-weight-bold text-dark card-label">Application Criteria
                                                </h4>
                                            </div>
                                            <div class="card-toolbar">
                                                <ul class="nav nav-tabs nav-bold nav-tabs-line">
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                                                            role="button" aria-haspopup="true"
                                                            aria-expanded="false">Language</a>
                                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                            @foreach ($appTexts as $key => $appText)
                                                                <a class="dropdown-item" data-toggle="tab"
                                                                    href="#lang_app_{{ $appText->id }}">
                                                                    {{ $appText->language->name }}
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div data-scroll="true" class="scroll scroll-pull"
                                                style="max-height:350px !important; overflow:auto;">
                                                <div class="tab-content mt-5" id="myTabContent">
                                                    {{-- <div class="tab-pane fade show active" id="lang_en_app" role="tabpanel"
                                                        aria-labelledby="lang_en_app">
                                                        National Volunteer Service Community Service Program Youth
                                                        Participation Requirements:<br>
                                                        The National Volunteer Community Development Service Training
                                                        includes young volunteers nationwide in the 10 regional and 2 city
                                                        governments, and the requirements for registration for this
                                                        volunteer community service are required to have a full
                                                        identification questionnaire. <br>

                                                        1. Bachelor's degree and above from legal higher education
                                                        institutions nationwide <br>
                                                        2. Has a Certificate of Completion of Grade 8 National Examination
                                                        3. Not over 35 years of age <br>
                                                        4. Has a valid ID from the place where he / she lives and identifies
                                                        the registrant. <br>
                                                        5. Be able to give an ethical life testimony from a well-behaved
                                                        community <br>
                                                        6. Free of any kind of addiction. <br>
                                                        7. Dedicated and committed to the volunteer service of borderless
                                                        community engagement. <br>
                                                        8. Has confidence in the volunteer community service program.<br>
                                                        9. Has a humane personality and among of the values of our country
                                                        is giving and sharing.</br>
                                                        10. S/he has no health problems and can train and work in any part
                                                        of the climate.<br>
                                                        11. Non-pregnant registered for the Women's Volunteer Community.
                                                    </div>
                                                    <div class="tab-pane fade" id="lang_am_app" role="tabpanel"
                                                        aria-labelledby="lang_am_app">
                                                        <p>
                                                            የብሄራዊ በጎ ፈቃድ _ አገልግሎት ማህበረሰብ _ አገልግሎት ፕሮግራም ተሳታፊ ወጣቶች መመልመያ
                                                            መስፈርቶች
                                                            የብሄራዊ በጎ ፈቃድ ማህበረሰብ ልማት አገልግሎት ስልጠና በአገር አቀፍ ደረጃ በ10ሩ የክልል
                                                            መስተዳድሮችና
                                                            በ2ቱ
                                                            የከተማ
                                                            መስተዳድሮች የሚገኙ ወጣት የበጎ ፈቃደኞችን የሚያካትት ሲሆን ለዚህ የበጎ ፈቃድ ማህበረሰብ አገልግሎት
                                                            ለመመዝገብ
                                                            የሚያስፈልጉ መስፈርቶች የተመዝጋቢወችን ሙሉ ማንነት የሚያሳይ መጠይቅ እንዲኖረዉ ይፈለጋል
                                                        </p>
                                                        <div class="separator separator-solid"></div>
                                                        <div>
                                                            <ol type="1" class='list'>
                                                                <li> በአገር አቀፍ ደረጃ ከሚገኙ ህጋዊ የከፍተኛ የትምህርት ተቋማት የመጀመሪያ ድግሪና ከዚያ
                                                                    በላይ፤
                                                                </li>
                                                                <li> የ8ኛ ክፍል ብሄራዊ ፈተና ያጠናቀቁበትን ሰርተፍኬት ያለዉ/ያላት </li>
                                                                <li> ዕድሜዉ ከ35 ዓመት ያልበለጠዉ/ያልበለጣት፤ </li>
                                                                <li> ከሚኖርበት/ከምትኖርበት ቦታ ትክክለኛ እና ተመዝጋቢዉን የሚገልፅ የታደሰ መታወቂያ
                                                                    ያለዉ/ያላት
                                                                </li>
                                                                <li> ካለበት ማህበረሰብ ጥሩ ስነ-ምግባር ያለዉ/ያላት የስነ-ምግባር የህይወት ምስክርነት
                                                                    ማቅረብ
                                                                    የሚችል/የምትችል፤</li>
                                                                <li> ከማንዉም አይነት ደባል ሱስ ነጻ የሆነ/ች </li>
                                                                <li> ለድንበር የለሽ የበጎ ፈቃድ ማህበረሰብ አገልግሎት ራሱን ያዘጋጀና ቁርጠኛ የሆነ/ሆነች
                                                                </li>
                                                                <li> የበጎ ፈቃድ ማህበረሰብ አገልግሎ ፕሮግራም ላይ እምነት ያለዉ/ያላት! </li>
                                                                <li> ከአገራችን እሴቶች መካከል የመስጠት የማካፈል እና ሰብዓዊነት የተላበስ ማንነት
                                                                    ያለዉ/ያላት፧
                                                                </li>
                                                                <li> የጤንነት ችግር የሌለበትና በየኛዉም አየር ንብረት ክፍል አካባቢ መሰልጠንና መስራት
                                                                    የሚችል/የምትችል
                                                                </li>
                                                                <li> ለሴት በጎ ፈቃድ ማህበረሰብ አገልግሎ ተመዝጋቢ ነፍሰ ጡር ያልሆነች ማሳሰቢያ </li>
                                                            </ol>
                                                        </div>
                                                        <p>
                                                            ከዚህ ቀደም በ3 ዙር ተመልምለዉ ለስልጠና የተመረጡ ግን ያልተሳተፉ በዚህ ዙር ተሳታፊ አይሆኑም!
                                                            መረጃዎች ሲሞሉ ሙሉ በሙሉ fእንግሊዘኛ ቋንቋ ሆኖ የጠራ መሆን አለበት የበጎ ፈቃደኞች ማስረጃዎች
                                                            በሶፍት
                                                            ኮፒ
                                                            ተዘጋጅተዉ
                                                            መላክ ይኖርባቸዋል
                                                        </p>
                                                    </div> --}}
                                                    @foreach ($appTexts as $key => $appText)
                                                        <div class="tab-pane fade {{ $key == 0 ? ' show active' : '' }}"
                                                            id="lang_app_{{ $appText->id }}" role="tabpanel"
                                                            aria-labelledby="lang_app_{{ $appText->id }}">
                                                            {!! $appText->content !!}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div class=" card-footer p-0 pt-4 pl-4 pb-0">
                                            <div class="form-group mb-0">
                                                <label class="checkbox" id="agree_check_label">
                                                    <input type="checkbox" checked
                                                        {{ old('agree_check') == 'on' ? 'checked' : '' }}
                                                        name="agree_check" id="agree_check"> I Accepted </a>
                                                    <a href="{{ route('terms') }}" target="_blank">
                                                        terms and conditions
                                                    </a>
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
                                    <!--end: Wizard Step 0-->
                                    <div class="pb-5" data-wizard-type="step-content"
                                        data-wizard-state="current">
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
                                                    value="{{ $volunteer->first_name }}" />
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
                                                    value="{{ $volunteer->father_name }}" />
                                                @error('father_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <span class="form-text text-muted">Please enter your father name.</span>
                                            </div>
                                            <!--end::Input-->
                                            <!--begin::Input-->
                                            <div class="form-group col-md-12">
                                                <label class="d-block">Grand Father Name</label>
                                                <input type="text"
                                                    class="@error('grand_father_name') is-invalid @enderror form-control form-control-lg"
                                                    name="grand_father_name" placeholder="Grand Father Name"
                                                    value="{{ $volunteer->grand_father_name }}" />
                                                @error('grand_father_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <span class="form-text text-muted">Please enter your grand father
                                                    name.</span>
                                            </div>
                                            <!--end::Input-->
                                            @if (false)
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label class="d-block">Disablity</label>
                                                        <select name="disability" id="disability"
                                                            class="@error('disability') is-invalid @enderror form-control form-control-lg">
                                                            <option value="">Select</option>
                                                            @foreach ($disabilities as $disable)
                                                                <option value="{{ $disable->id }}">
                                                                    {{ $disable->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('disability')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        <span class="form-text text-muted">Please select if any
                                                            disability</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label class="d-block">Date Of Birth</label>
                                                    <input type="text" id="dob"
                                                        class="@error('dob') is-invalid @enderror form-control form-control-lg"
                                                        name="dob" placeholder="Date of Birth" autocomplete="off"
                                                        value="{{ $birth_date }}" />
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
                                                        <option value="M" {{ $volunteer->gender == 'M' ? 'selected' : '' }}>
                                                            Male
                                                        </option>
                                                        <option value="F" {{ $volunteer->gender == 'F' ? 'selected' : '' }}>
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
                                                        name="phone" placeholder="Phone" value="{{ $volunteer->phone }}" />
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
                                                        name="email" placeholder="Email" value="{{ $volunteer->email }}" />
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <span class="form-text text-muted">Please enter your email
                                                        address.</span>
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
                                            <div class="col-xl-6">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label class="d-block">Educational Level</label>
                                                    <select name="educational_level" id="educational_level"
                                                        class="@error('educational_level') is-invalid @enderror form-control form-control-lg">
                                                        <option value="">Select</option>
                                                        @foreach ($educationLevels as $key => $level)
                                                            <option
                                                                {{  $volunteer->educational_level == $key ? 'selected' : '' }}
                                                                value="{{ $key }}">{{ $level }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('educational_level')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-6">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label class="d-block">Field of Study</label>
                                                    <select name="field_of_study" id="field_of_study"
                                                        class="@error('field_of_study') is-invalid @enderror form-control form-control-lg">
                                                        <option value="">Select</option>
                                                        @foreach ($fields as $field)
                                                            <option
                                                                {{ $volunteer->fieldOfStudy->id == $field->id ? 'selected' : '' }}
                                                                value="{{ $field->id }}">{{ $field->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('field_of_study')
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
                                                    <label class="d-block">GPA</label>
                                                    <input name="gpa" id="gpa"
                                                        class="@error('gpa') is-invalid @enderror form-control"
                                                        type="number" value="{{ $volunteer->gpa }}" max="4.0" min="1.0"
                                                        step="any" />

                                                    @error('gpa')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--end::Input-->
                                            </div>

                                            <div class="col-xl-6">
                                                <!--begin::Select-->
                                                <div class="form-group">
                                                    <label class="d-block">Year Of Gruduation</label>
                                                    <input name="graduation_date" id="graduation_date"
                                                        class="@error('graduation_date') is-invalid @enderror form-control"
                                                        type="text" value="{{ $volunteer->graduation_date }}" max="4"
                                                        min="1" />

                                                    @error('graduation_date')
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
                                                    <input type="text" value="{{ $volunteer->contact_name }}"
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
                                                    <input type="tel" value="{{ $volunteer->contact_phone }}"
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
                                                    <label class="d-block">Kebele Identification Image</label>
                                                    <div class="custom-file">
                                                        <input type="file"
                                                            class="@error('kebele_id') is-invalid @enderror custom-file-input"
                                                            name="kebele_id" id="kebele_id" />
                                                        <label class="custom-file-label" for="customFile">Choose
                                                            file</label>
                                                        @error('kebele_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    <span class="form-text text-muted">Please enter your Kebele ID.</span>
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
                                    <div class="pb-5" data-wizard-type="step-content">
                                        <h5 class="mb-10 font-weight-bold text-dark">Review your Details and Submit</h5>
                                        <!--begin::Item-->
                                        <div class="border-bottom mb-5 pb-5">
                                            <div class="font-weight-bolder mb-3">Your Account Details:</div>
                                            <div class="line-height-xl">
                                                Full Name:
                                                <span id="reviewFullName"></span>
                                                <br />
                                                Phone:
                                                <span id="reviewPhone"></span>
                                                <br />
                                                Email: <span id="reviewEmail"></span>
                                                <br />
                                                Date Of Birth: <span id="reviewDOB"></span>
                                                <br />
                                                Gender: <span id="reviewGender"></span>
                                                <br />
                                            </div>
                                        </div>

                                        <div class="border-bottom mb-5 pb-5">
                                            <div class="font-weight-bolder mb-3">Location:</div>
                                            <div class="line-height-xl">
                                                Region: <span id="reviewRegion"></span>
                                                <br />
                                                Zone:
                                                <span id="reviewZone"></span>
                                                <br />
                                                Woreda: <span id="reviewWoreda"></span>
                                            </div>
                                        </div>
                                        <div class="border-bottom mb-5 pb-5">
                                            <div class="font-weight-bolder mb-3">Education Background:</div>
                                            <div class="line-height-xl">
                                                Education Level: <span id="reviewEducationLevel"></span>
                                                <br />
                                                Feild Of Study:
                                                <span id="reviewFieldOfStudy"></span>
                                                <br />
                                                GPA: <span id="reviewGPA"></span>
                                                <br />
                                                Year of Graduation: <span id="reviewGraduationYear"></span>
                                            </div>
                                        </div>
                                        <div class="border-bottom mb-5 pb-5">
                                            <div class="font-weight-bolder mb-3">Other Documents:</div>
                                            <div class="line-height-xl">
                                                Contact Name: <span id="reviewContactName"></span>
                                                <br />
                                                Contact Phone:
                                                <span id="reviewContactPhone"></span>
                                            </div>
                                        </div>
                                        <!--end::Item-->
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
