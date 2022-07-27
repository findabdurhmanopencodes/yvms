@extends('layouts.app')
@section('title', 'Resource Assignment')

@section('breadcrumbTitle', 'Resource Assignment')
@section('breadcrumbList')
    <li class="breadcrumb-item">
        <a href="" class="text-muted"></a>
    </li>
@endsection
@section('content')
    <div class="card">
        @if(count($errors) > 0 )
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul class="p-0 m-0" style="list-style: none;">
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card-body">
            <h5 class="card-title">Available Resource On Training Center {{ $training_center->name }}
                ({{ $training_center->code }})</h5>
            <div>
                <ul class="list-group">
                    @foreach ($training_center->resources as $resource)
                        @if (count(
                            $volunteer->resourceHistories()->where('resource_id', $resource->id)->get(),
                        ) < 1)
                            <li class="list-group-item">
                                {{ $resource->name }}
                                <span class="badge badge-info badge-pill my-2">{{ $resource->pivot->current_balance }}
                                    Items</span>

                                <form
                                    action="{{ route('session.VolunteerResourceHistory.store', ['training_session' => Request::route('training_session')]) }}"
                                    method="post">
                                    @csrf

                                    <div class="row">
                                        <input class="form-control col-xl-3 mx-4" type="number" value="1" name="amount">
                                        <input type="hidden" value="{{ $training_center->id }}" name="training_center">
                                        <input type="hidden" value="{{ $resource->id }}" name="resource_id">
                                        <input type="hidden" value="{{ $volunteer->id }}" name="volunteer_id">
                                        <input type="hidden" name="training_session"
                                            value={{ Request::route('training_session') }}>
                                        <button class="btn btn-primary" type="submit">Assign</button>
                                    </div>
                                </form>
                            @else
                            </li>
                        @endif
                        </li>
                    @endforeach


                </ul>
            </div>
        </div>
    </div>

    <div class="card">


        <div class="card-body">
            <h5 class="card-title">Resources Recived By {{ $volunteer->name() }}</h5>
            <div>
                <ul class="list-group">

                    @foreach ($volunteer->resourceHistories as $resource)
                        <li class="list-group-item">
                            {{ $resource->resource->name }}
                            <span class="badge badge-info badge-pill my-2">{{ $resource->amount }}
                                Items</span>


                        </li>
                    @endforeach
                    @if (count($volunteer->resourceHistories) < 1)
                        <li class="text text-danger">
                            No Resource Recived !!
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('.select2').select2({});
    </script>
@endpush
