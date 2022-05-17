@extends('layouts.app')
@push('css')
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
@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Check-In</h2>
        </div>
        <div class="card-body">
            <h5 class="card-title">Search</h5>
            <form action="" method="POST">

                @csrf

                <input type="text" id="myInput" placeholder="Search VOlunter Using Id Number .." title="Type in a name"
                    class="typeahead form-control col-12 mb-6" style="background-color: #f1f1f1">

            </form>

            <div class="card card-custom md-6">
                <div class="card-header ribbon ribbon-top ribbon-ver">
                    <div class="ribbon-target bg-success" style="top: -2px; right: 20px;">

                    </div>
                    <h3 class="card-title">

                    </h3>
                </div>
                <div class="card-body">
                    <a class="btn btn-primary mb-4">
                        <h4><i class="fa fa-check-circle"></i>Check-In</h4>
                    </a>
                    <img src="{{ asset('assets/media/users/100_10.jpg') }}" class="rounded float-right img-thumbnail"
                        alt="..." width="200">
                    <h1>Name:Ajaib Mohammed</h1>
                    <h1>Phone:0931979439</h1>
                    <h1>Region:Oromia</h1>
                    <h1>Training Center:Jit</h1>

                    {{-- <span class="badge badge-pill badge-info mt-4"><h3>Accepted</h3></span> --}}



                </div>
            </div>
        </div>

    </div>
@endsection

{{-- @section('additional_javascript')
    <script>

autocomp();
        $('#myInput').on('keyup', function() {


 search();

        });
        function autocomp(){

            // var route = "{{ url('autocomplete.searchBox') }}";
            // $('#a').typeahead({
            //     source: function (query, process) {
            //         return $.get(route, {
            //             query: query
            //         }, function (data) {
            //             return process(data);
            //         });
            //     }
            // });
        }


        function search() {
            // var keyword = $('#myInput').val();
            // $.post('{{ route('autocomplete') }}', {
            //         _token: $('meta[name="csrf-token"]').attr('content'),
            //         keyword: keyword
            //     },
            //     function(data) {
            //         table_post_row(data, keyword);

            //     });


        }
        // table row with ajax
        function table_post_row(res, keyword) {

            let htmlView = '';
            if (res.lab.length <= 0) {
                htmlView += `
           <tr>
              <td colspan="4" class="text-danger h2 font">No Laboratory  Found with Service  <span class="font-weight-boldest">"${keyword}"</span> </td>
          </tr>`;
            }
            for (let i = 0; i < res.lab.length; i++) {
                 var id=res.lab[i].id;
                htmlView += `
            <tr>
               <td>` + (i + 1) + `</td>
                  <td>` + res.lab[i].name + `</td>
                  <td><a class='btn btn-info float-right' href={{ route("lab.show",1) }}> <i class='fa fa-eye '></i> Show Detail</a></td>
            </tr>`;

            }
            $('tbody').html(htmlView);
        }

        function searcha() {


        }
    </script>
@endsection --}}
