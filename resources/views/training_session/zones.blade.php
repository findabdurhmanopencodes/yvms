@extends('layouts.app')
@section('title','Region list')
@section('content')
<div class="card card-custom">
    <div class="card-header flex-wrap  pt-6 ">
        <div class="card-title mr-0">
            <h3 class="card-label">{{ $region->name }} - zones</h3>
        </div>
        <div class="card-tool">
        </div>
    </div>
    <div class="card-body">
        <table width="100%" class="table ">
            <thead>
                </tr>
                    <th> # </th>
                    <th> Name </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($zones as $key => $zone)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $zone->name }}</td>
                        <td>
                            <a href="{{ route('session.deployment.zone.woredas', ['training_session'=>Request::route('training_session')->id,'zone'=>$zone->id]) }}" class="btn btn-icon">
                                <span class="fa fa-eye"></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="m-auto col-6 mt-3">
        {{-- {{ $masters->withQueryString()->links() }} --}}
    </div>
</div>
@endsection
