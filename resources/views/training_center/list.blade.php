@extends('layouts.app')
@section('title', 'All Training Centers')

@section('breadcrumbTitle', 'Training Centers')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Training Centers</a>
    </li>
@endsection

@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3>
                    Syndication Room List
                </h3>
                {{-- <h3 class="card-label">List of Sydication rooms
                    <span class="text-muted pt-2 font-size-sm d-block">Training Centers </span>
                </h3> --}}
            </div>
            <div class="card-toolbar">
                <div class="input-icon">
                    <input type="text" class="form-control" placeholder="Search..." id="" />
                    <span>
                        <i class="flaticon2-search-1 text-muted"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table width="100%" class="table">
                <thead>
                    </tr>
                    <th>Cindication Room Id </th>
                    <th>Volunteer Capacity</th>
                    <th>Placed Volunteer</th>
                    <th>Action</th>
                    {{-- <th><i class="menu-icon flaticon-list"></i> </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse ($syndicationRooms as $syndicationRoom)
                        <tr>
                            <td>{{ $syndicationRoom->syndicationRoom->number }}</td>
                            <td>{{ $syndicationRoom->syndicationRoom->number_of_volunteers }}</td>
                            <td>{{ count($syndicationRoom->syndicationRoom->volunteers) }}</td>
                            <td>
                                <a
                                    href="{{ route('session.cindication_room.show', ['training_session' => Request::route('training_session')->id, 'training_center' => $trainingCenter->id, 'cindication_room' => $syndicationRoom->syndicationRoom->id]) }}">
                                    <i class="fal fa-eye"></i>
                                </a>
                                <a
                                    href="{{ route('session.cindication_room.export', ['training_session' => Request::route('training_session')->id, 'training_center' => $trainingCenter->id, 'cindication_room' => $syndicationRoom->syndicationRoom->id]) }}">
                                    <i class="fal fa-users"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr style="font-size: 13px;" class="text-center">
                            <td colspan="3" style="">No cindication room</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
