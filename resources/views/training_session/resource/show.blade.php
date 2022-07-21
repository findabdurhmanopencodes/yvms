@extends('layouts.app')
@section('title', 'All resources')
@section('breadcrumbList')
    <li class="active">resources</li>
@endsection
@section('breadcrumbTitle', 'resources')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Resources</a>
    </li>
@endsection



<div id="assignResource" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('session.resource.assign', ['training_session' => Request::route('training_session')]) }}"
            method="post">
            @csrf
            <input type="hidden" name="resource_id" value="{{ $resource->id }}">
            <input type="hidden" id="training_center_id" name="training_center_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bg-red-600">Assign {{ $resource->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div>
                        <label>Amount:</label>
                        <input type="number" name="amount" class="form-control">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Submit</button>

                </div>
            </div>
        </form>
    </div>
</div>
<div id="updateResource" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('session.resource.update', ['training_session' => Request::route('training_session')]) }}"
            method="post">
            @csrf
            <input type="hidden" name="resource_id" value="{{ $resource->id }}">
            <input type="hidden" id="training_center_update_id" name="training_center_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bg-red-600">Update {{ $resource->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div>
                        <label>Amount:</label>
                        <input type="number" name="amount" class="form-control">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Submit</button>

                </div>
            </div>
        </form>
    </div>
</div>
@section('content')
    <div class="card">

        <div class="card-body">
            <h5 class="card-title"><span class="text text-primary">{{ $resource->name }}</span> Resource Allocation
                For
                Universities</h5>
            <ul class="list-group">

                @foreach ($trainingCenters as $trainingCenter)
                    <li class="h4">
                        {{ $trainingCenter->name }} ({{ $trainingCenter->code }})
                        <div class="list-group-item d-flex justify-content-md-between">
                            @php
                                $centers = $trainingCenter->resources()->where('resources.id', $resource->id)->get();
                                if(count($centers)>0){
                                    $latestResourceBalance = $centers[count($centers)-1];
                                }
                            @endphp
                            {{-- @dd($latestResourceBalance) --}}
                            <span
                                class="badge badge-primary badge-pill">{{ count($trainingCenter->resources()->where('resources.id', $resource->id)->get()) > 0? $latestResourceBalance->pivot->current_balance. ' Item': '0 Item' }}</span>
                            @if (count(
                                $trainingCenter->resources()->where('resources.id', $resource->id)->get()) < 1)
                                <a class="btn btn-primary" data-toggle="modal" data-target="#assignResource"
                                    onclick="getCenterId({{ $trainingCenter->id }});"><i class="fa fa-plus"></i>Add</a>
                            @else
                                <a class="btn btn-warning" data-toggle="modal" data-target="#updateResource"
                                    onclick="getCenterId({{ $trainingCenter->id }});"><i class="fa fa-edit"></i>Edit</a>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function getCenterId(training_center) {
            console.log(training_center)
            $('#training_center_id').val(training_center);
            $('#training_center_update_id').val(training_center);
        }
    </script>
@endpush
