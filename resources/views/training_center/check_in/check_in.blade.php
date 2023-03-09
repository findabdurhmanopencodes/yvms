@extends('layouts.app')
@section('title','Chek-in')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('calendar/css/redmond.calendars.picker.css') }}">
@endpush
{{-- @push('css')
    <style>
        #myTable {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;
            font-size: 18px;
        }

        #myTable th,
        #myTable td {
            text-align: left;
            padding: 12px;
        }

        #myTable tr {
            border-bottom: 1px solid #ddd;
        }

        #myTable tr.header,
        #myTable tr:hover {
            background-color: #f1f1f1;
        }

    </style>
@endpush --}}
@section('content')
    <div id="notAccept" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bg-red-600">Checking Result</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h1 class="text text-danger">This Id Is already Cheked In !!</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div id="invalidVolunteer" class="modal fade" tabindex="-1">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bg-red-600">Checking Result</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h1 class="text text-danger">Volunteer Doesn't  Exist With This Id</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div id="sucess" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bg-red-600">Checking Result</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h1 class="text text-green-700">Checkin Sucess</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h2>Check-In In Training Center</h2>
            {{-- <div>
                <a href="{{ route('session.trainingCenter.checkin.all', ['training_session'=>Request::route('training_session')]) }}" class="btn btn-primary float-right">Checked in All</a>

            </div> --}}
        </div>

        <div class="card-body">
            {{-- <h5 class="card-title">Search</h5>
            <input type="text" id="search" placeholder="Search Volunteer Using Id Number .."
                class="typeahead form-control col-12 mb-6" style="background-color: #fdfbfb" value="MoP-"> --}}
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">MoP-</span>
                    </div>
                    <input type="text" id="search" placeholder="Search Volunteer Using Id Number .. Example(Ju-00001/1)" class="typeahead form-control col-12" style="background-color: #fdfbfb" aria-label="id" aria-describedby="basic-addon1">
                    {{-- <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1"> --}}
                  </div>
                <div id="check">

                </div>
                {{-- <div class="card card-custom md-6"> --}}
                {{-- <div class="card-header ribbon ribbon-top ribbon-ver">
                    <div class="ribbon-target bg-success" style="top: -2px; right: 20px;">

                    </div>
                    <h3 class="card-title">
                        <div id="check">

                        </div>
                    </h3>
                </div> --}}
                {{-- <div class="card-body">



                    <span class="badge badge-pill badge-info mt-4"><h3>Accepted</h3></span>



                </div> --}}
            {{-- </div> --}}

            <img src="{{ asset('assets/media/users/default.jpg') }}" class="rounded float-right img-thumbnail"
            alt="..." width="200" id="profile">
        <h5 id="name">Name</h5>
        <h5 id="phone">Phone</h5>
        <h5 id="region">Region</h5>
        <h5 id="center">Training Center</h5>
        <div id="update_pro"></div>
        </div>

        <form action="{{ route('session.center.update.profile', ['training_session'=> Request::route('training_session')]) }}" method="post">
            @csrf
            <div id="update_pro_form">
                
            </div>
        </form>
    </div>
    <div class="card">
        <div class="card-header">
            <h2>Check-In Volunteers ({{ $checkeInVolunteers->total() }})</h2>
        </div>
        <div class="card-body mb-0 pb-0">
            <div class="accordion accordion-solid accordion-toggle-plus " id="accordionExample6">
                <div class="card ">
                    <div id="headingThree6" class="card-header text-white" style="background-color: rgba(15, 69, 105, 0.6);">
                        <div class="card-title collapsed text-white" data-toggle="collapse" data-target="#collapseThree6"
                            style="background-color: rgba(15, 69, 105, 0.6);">
                            <i class="flaticon2-search fa-2x text-white"></i> Filter Applicants
                        </div>
                    </div>
                    <div id="collapseThree6" class="collapse" data-parent="#accordionExample6">
                        <div class="card-body">
                            <form action="{{ route('session.TrainingCenter.CheckIn', ['training_session'=>Request::route('training_session')]) }}" method="GET">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="my-3">ID number:</label>
                                        <input type="text" name="id_number" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="my-3">Gender:</label>
                                        <select name="gender" class="form-control">
                                            <option value="">select gender</option>
                                            <option value="M">Male</option>
                                            <option value="F">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="my-3">Checked In Date:</label>
                                        <input type="text" id="checkedin_date" class="form-control" name="checkedin_date" autocomplete="off" />
                                    </div>
                                <div>
                                <button type="submit" class="btn btn-primary  mx-4 my-4" name="filter" value="filter">Filter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered ">
				<thead>
					<tr>
						<th>#</th>
						<th>Full name</th>
						<th>ID number</th>
						<th>Gender</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($checkeInVolunteers as $key => $checkeInVolunteer)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>
                                {{ $checkeInVolunteer->first_name }} {{ $checkeInVolunteer->father_name }} {{ $checkeInVolunteer->grand_father_name }} 
                            </td>
                            <td>
                                {{ $checkeInVolunteer->id_number }}
                            </td>
                            <td>
                                {{ $checkeInVolunteer->gender == 'M' ? 'Male' : 'Female' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">no records found</td>
                        </tr>
                    @endforelse
				</tbody>
			</table>
			<div class="navigation">
                {{ $checkeInVolunteers->links() }}
			</div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('calendar/js/jquery.plugin.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.plus.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.picker.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.ethiopian.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.ethiopian-am.js') }}"></script>
    <script src="{{ asset('calendar/js/jquery.calendars.picker-am.js') }}"></script>
    {{-- <script>
        $(document).ready(function({
            function loadVolunteers(query = '') {
                $.ajax({
                    url: "{{ route('session.result', ['training_session' => 1]) }}",
                    method: 'GET',
                    data: {
                        query: query
                    },
                    dataType: 'json'
                    success: function(data) {
                        // $('t')
                    }
                })
            }
        }));

        $(document).on('keyup', '#search', function() {
            var query = $(this).val();
            fetch_customer_data(query);
        });
    </script> --}}
    <script src="{{ asset('js/qrcode.min.js') }}"></script>
    <script src="{{ asset('js/JsBarcode.all.min.js') }}"></script>
    <script>
        var field_of_studies = {!! json_encode($field_of_studies) !!};
        var educational_levels = {!! json_encode($educational_levels) !!};
        function myFunction(field_of_study) {
           return '<option value="'+field_of_study.id+'">'+field_of_study.name+'</option>';
        }
        function myEducationLevel(educational_level) {
           return '<option value="'+educational_level+'">'+educational_level+'</option>';
        }
        function fetch_customer_data(query = '') {
            $.ajax({
                url: 'result/',
                method: 'GET',
                data: {
                    query: query
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == 404) {
                        $('#invalidVolunteer').modal('show')
                    } else if (data.status == 505) {
                        $("#notAccept").modal('show');
                        // alert('volunteer is not Allowed');
                    }
                    // else if(data.status == 606){
                    //     alert('volunteer is aleady checked');
                    // }
                    else if (data.status == 200) {
                        var div__qr_img = document.createElement("div");

                        var div__qr_img_2 = document.createElement("div");

                        // div__qr_img.setAttribute('id', 'qrcode');

                        // // myDesign.appendChild(div__qr_img);

                        var qrcode = new QRCode(div__qr_img, {
                            text: data.data.id_number,
                            width: 50,
                            height: 44.7,
                            colorDark : "#000000",
                            colorLight : "#ffffff",
                            correctLevel : QRCode.CorrectLevel.H,
                        });

                        var img = qrcode._el.children[1];
                        var src = div__qr_img.children[0].toDataURL("image/png");

                        var div__bar_img_2 = document.createElement("div");
                        var div__bar_img = document.createElement("img");

                        JsBarcode(div__bar_img)
                            .options({font: "OCR-B", displayValue: true, width:0.9, height: 15, background: "white"})
                            .CODE128(data.data.id_number, {fontSize: 11, textMargin: 2, textPosition: "top", color:'inherit'})
                            .render();

                        // div__bar_img_2.style.position = "relative";
                        // div__bar_img_2.style.float = "right";
                        // div__bar_img_2.style.left = '142px';
                        // div__bar_img_2.style.top = '-216px';
                        div__bar_img.style.color = "black";
                        var barcodesrc = div__bar_img.src;

                        $.ajax({
                            url: 'barQRCode/',
                            method: 'GET',
                            data: {
                                barSrc: barcodesrc,
                                qrSrc: src,
                                id_number: data.data.id
                            },
                            dataType: 'json',
                            success: function(data) {
                                console.log(data.success);
                                // alert(data.success);
                            }
                        })
                        $("#name").html('Name:' + data.data.first_name + data.data.father_name);
                        $("#phone").html('Phone:' + data.data.phone);
                        $("#region").html('Region:' + data.data.woreda.zone.region.name);
                        // $("#center").html('Training Center:' + data.data.placment().name);
                        $("#profile").attr("src", data.data.profilePhoto);
                        $("#check").html('<h3><a class="btn btn-primary" href='+'/{{ Request::route('training_session')->id }}/check-in/action/' + data.data.id + '><i class="fa fa-check"> Check-In</a></h3> ');
                        $("#update_pro").html('<a href="#" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal" data-username='+data.data.first_name+'>\
                        <span class="svg-icon svg-icon-md">\
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->\
                            <i class="fal fa-plus"></i>\
                            <!--end::Svg Icon-->\
                    </span>\
                    Update Volunteer Pofile</a>')
                        $('#update_pro_form').html('<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">\
                            <div class="modal-dialog modal-lg"  role="document">\
                                <div class="modal-content">\
                                    <div class="modal-header">\
                                        <h5 class="modal-title" id="exampleModalLabel">Update Volunteer Profile</h5>\
                                        <button type="button" class="close" data-dismiss="modal" -label="Close">\
                                            <i aria-hidden="true" class="ki ki-close"></i>\
                                        </button>\
                                    </div>\
                                    <div class="modal-body">\
                                        <div class="card-body">\
                                            <input type="hidden" class="form-control" name="volunteer_id" value="'+data.data.id+'"/>\
                                            <div class="card-body">\
                                                <div class="form-group row">\
                                                    <div class="col-lg-4">\
                                                        <label>First name:</label>\
                                                        <input type="text" class="form-control" name="first_name" value="'+data.data.first_name+'" required/>\
                                                    </div>\
                                                    <div class="col-lg-4">\
                                                        <label>Middle name:</label>\
                                                        <input type="text" class="form-control" name="middle_name" value="'+data.data.father_name+'" required/>\
                                                    </div>\
                                                    <div class="col-lg-4">\
                                                        <label>Last name:</label>\
                                                        <input type="text" class="form-control" name="last_name" value="'+data.data.grand_father_name+'" required/>\
                                                    </div>\
                                                </div>\
                                                <div class="form-group row">\
                                                    <div class="col-lg-6">\
                                                        <label>Phone number:</label>\
                                                        <input type="text" class="form-control" name="phone" value="'+data.data.phone+'"/>\
                                                    </div>\
                                                    <div class="col-lg-6">\
                                                        <label>E-mail:</label>\
                                                        <input type="email" class="form-control" name="email" value="'+data.data.email+'" required/>\
                                                    </div>\
                                                </div>\
                                                <div class="form-group row">\
                                                    <div class="col-lg-4">\
                                                        <label>Gender:</label>\
                                                        <select name="gender" class="form-control" required>\
                                                            <option value="">select gender</option>\
                                                            <option value="M">Male</option>\
                                                            <option value="F">Female</option>\
                                                        </select>\
                                                    </div>\
                                                    <div class="col-lg-4">\
                                                        <label>Educational level:</label>\
                                                        <select name="education_level" class="form-control" required>\
                                                            <option value="">Select Educational Level</option>\
                                                            '+educational_levels.map(myEducationLevel)+'\
                                                        </select>\
                                                    </div>\
                                                    <div class="col-lg-4">\
                                                        <label>Gpa:</label>\
                                                        <input type="text" class="form-control" name="gpa" value="'+data.data.gpa+'" required/>\
                                                    </div>\
                                                </div>\
                                                <div class="form-group row">\
                                                    <div class="col-lg-4">\
                                                        <label>Field of study:</label>\
                                                        <select name="Field of study" class="form-control" required>\
                                                            <option value="">Select field of study</option>\
                                                            '+field_of_studies.map(myFunction)+'\
                                                        </select>\
                                                    </div>\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                    <div class="modal-footer">\
                                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>\
                                        <button type="submit" class="btn btn-primary font-weight-bold">Update &amp; Checkin</button>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>')
                    }
                }
            })
        }
        $(document).ready(function() {


            $(document).on('keyup', '#search', function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    var query = $(this).val();
                    fetch_customer_data(query);
                    if (("#search").val == null) {
                        $("#name").html('');
                        $("#check").html('');
                        $("#phone").html('');
                        $("#region").html('');
                        $("#center").html('');
                        $("#profile").attr('src', '{{ asset('assets/media/users/default.jpg') }}');
                    }
                }
            });
        });

        $('#exampleModal').on('show', function(e) {
            var link     = e.relatedTarget(),
                modal    = $(this),
                data = link.data("username")

                alert(data);
                // modal.find("#first_name").val(data);
                // modal.find("#username").val(username);
        });

        $(function() {
            var calendar = $.calendars.instance('ethiopian', 'am');
            $('#checkedin_date').calendarsPicker({
                calendar: calendar
            });
        })
    </script>
@endpush
