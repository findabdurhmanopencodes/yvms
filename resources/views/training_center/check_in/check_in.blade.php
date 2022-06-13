@extends('layouts.app')
@section('title','Chek-in')
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
                    <h1 class="text text-danger">This Id Is Not Accepted !!</h1>
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
            <h2>Check-In</h2>
        </div>
        <div class="card-body">
            <h5 class="card-title">Search</h5>
            <input type="text" id="search" placeholder="Search Volunteer Using Id Number .."
                class="typeahead form-control col-12 mb-6" style="background-color: #fdfbfb" value="MoP-">
                <a href="{{ route('session.trainingCenter.checkin.all', ['training_session'=>Request::route('training_session')]) }}" class="btn btn-primary">Checked in All</a>
            <div class="card card-custom md-6">
                <div class="card-header ribbon ribbon-top ribbon-ver">
                    <div class="ribbon-target bg-success" style="top: -2px; right: 20px;">

                    </div>
                    <h3 class="card-title">
                        <div id="check">

                        </div>
                    </h3>
                </div>
                <div class="card-body">


                    <img src="{{ asset('assets/media/users/default.jpg') }}" class="rounded float-right img-thumbnail"
                        alt="..." width="200" id="profile">
                    <h1 id="name">Name</h1>
                    <h1 id="phone">Phone</h1>
                    <h1 id="region">Region</h1>
                    <h1 id="center">Training Center</h1>

                    {{-- <span class="badge badge-pill badge-info mt-4"><h3>Accepted</h3></span> --}}



                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
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
    <script>
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
                        $("#name").html('Name:' + data.data.first_name + data.data.father_name);
                        $("#phone").html('Phone:' + data.data.phone);
                        $("#region").html('Region:' + data.data.woreda.zone.region.name);
                        $("#center").html('Training Center:' + data.data.woreda.zone.name);
                        $("#profile").attr("src", data.data.profilePhoto);
                        $("#check").html('<h3><a class="btn btn-primary" href='+'/{{ Request::route('training_session') }}/check-in/action/' + data.data.id + '><i class="fa fa-check"> Check-In</a></h3>');

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
    </script>
@endpush
