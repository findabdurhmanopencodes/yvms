@extends('layouts.app')
@section('title', 'Distance location')
@section('content')

@push('css')
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
        var HOST_URL = "{{ route('distance.index') }}";

        function deleteDistance(distanceid, parent) {
            event.preventDefault();
            Swal.fire({
                title: "Are you sure to delete this distance?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: '/distance/'+distanceid,
                        data: {
                            "id": distanceid,
                            "_method": 'DELETE',
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        dataType: 'json',
                        success: function(data) {
                            $(parent).closest('tr')[0].remove();
                            Swal.fire(
                                "Deleted!",
                                "Distance has been deleted.",
                                "success"
                            )
                        },

                        error: function(data) {
                            if (data.status) {
                                Swal.fire("Forbidden!", "You can't delete this distance", "error");
                            }
                        }



                    });
                }
            });
        }


    </script>
    <script src="{{ asset('assets/js/pages/crud/ktdatatable/base/data-ajax.js') }}"></script>
     <script src="{{ asset('assets/js/pages/widgets.js') }}"></script>

<script>
        $( document ).ready(function() {
            $('#zone').select2({
            });

        });
        $( document ).ready(function() {
            $('#center').select2({
            });

        });
        $( document ).ready(function() {
            $('#address').select2({
            });

        });
        $( document ).ready(function() {
            $('#uni').select2({
            });

        });
</script>
<!--end::Page Scripts-->
@endpush

    <div class="card card-custom card-body mb-3">




        <form action=""  id="form" method="GET">
        <div class=" ml-1 col-12 p-0">
            <div class="row ">

                <div class="form-group col-4">
                    <select name="training_session" id="address" class="form-control select2">
                        <option value="">Select Zone </option>
                        @foreach ($zones as $zone)
                            <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-4">
                    <select name="training_center" id="uni" class="form-control select2" >
                        <option value="">Select Training Center</option>
                        @foreach ($training_centers as $training_center)
                            <option value="{{ $training_center->id }}">{{ $training_center->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-2">
                    <button class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Filter </button>
                </div>
                <div class="form-group col-2">
                    <button class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Import </button>
                </div>
            </div>
        </div>
    </form>
    </div>
    <div class="card card-custom">
        <div class="card-header flex-wrap  pt-6 ">
            <div class="card-title mr-0">
                <h3 class="card-label"> Transporation Tarif between Training center and Volunter origin zone </h3>
            </div>
            <div class="card-title mr-0">
            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">

                <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                <i class="fal fa-plus"></i>
                <!--end::Svg Icon-->
      <i class="fa fa-usd"> </i> New Distance
    </a>
</div>
</div>

        <div class="card-body">
            <table width="100%" class="table table-striped ">
                <thead>
                    </tr>
                    <th> #</th>

                    <th> Training Center </th>
                    <th> Zone </th>

                    <th> KM </th>
                    <th> Total Birr </th>
                    <th> Created at </th>


                    <th>Action </th>

                    </tr>
                </thead>
                <tbody>


                    @foreach($distances  as $key =>  $distance )
                        <tr>
                                 <td> {{ $key + 1 }}</td>
                                 <td>
                                    {{ $distance->traininingCenter->name?? '-' }}

                                </td>
                                 <td> {{ $distance->zone->name }} </td>
                                 <td> {{ $distance->km }} </td>

                                 <td>
                                    @if(empty($price->price))

                                    {{ '-' }}
                                @else
                                {{ number_format($distance->km * $price->price, 2) }}
                                 @endif
                                </td>

                                 <td> {{ $distance->created_at}} </td>
                            </td>

                            <td>
                                <a href="javascript:;" onclick="deleteDistance({{ $distance->id  }},$(this))" class="btn btn-sm btn-clean btn-icon" class="btn btn-icon">
                                <span class="fa fa-trash"></span>
                                </a>
                                <a href="{{ route('distance.edit', ['distance'=>$distance->id]) }}"  class="btn btn-sm btn-clean btn-icon" class="btn btn-icon">
                                    <span class="fa fa-edit"></span>
                                </a>

                                </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="m-auto col-6 mt-3">
            {{ $distances->withQueryString()->links() }}
        </div>
    </div>

    <div class="card-toolbar">
      <form method="POST" action="{{ route('distance.store', ['distance_id'=>1]) }}">
                @csrf
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Create  new distance in KM </h5>
                                <button type="button" class="close" data-dismiss="modal" -label="Close">
                                    <i aria-hidden="true" class="ki ki-close"></i>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="form-group col-12">
                                        <select name="training_center" id="center" class="form-control select2" required="required">
                                            <option value="">Select Training Center</option>
                                            @foreach ($training_centers as $training_center)
                                                <option value="{{ $training_center->id }}">{{ $training_center->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-12">
                                        <select name="zone" id="zone" class="form-control select2" required="required">
                                            <option value="">Select Zone</option>
                                            @foreach ($zones as $zone)
                                                <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group col-12">
                                     <input type="number" name="km" class="form-control" placeholder="Distance in km" required>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary font-weight-bold"> Save </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <!--end::Button-->
    </div>
@endsection
