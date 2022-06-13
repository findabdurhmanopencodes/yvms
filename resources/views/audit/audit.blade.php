@extends('layouts.app')
@section('title', 'Audit')
@push('js')
    <script>
        $(document).ready(function() {
            $('#user_id').select2({
                placeholder: "Select a User"
            });
            $('#action').select2({
                placeholder: "Select a Action"
            });
            $('#model').select2({
                placeholder: "Select a Model"
            });


        });
    </script>
@endpush
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

@section('content')
    <div class="accordion accordion-solid accordion-toggle-plus " id="accordionExample6">

        <div class="card ">
            <div id="headingThree6" class="card-header text-white" style="background-color: rgba(15, 69, 105, 0.6);">
                <div class="card-title collapsed text-white" data-toggle="collapse" data-target="#collapseThree6"
                    style="background-color: rgba(15, 69, 105, 0.6);">
                    <i class="flaticon2-search fa-2x text-white"></i> Filter audit(Logs)
                </div>
            </div>
            <div id="collapseThree6" class="collapse" data-parent="#accordionExample6">
                <div class="card-body">

                    <form action="{{ route('audit.index') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="user_id" class=" col-sm-12 col-form-label">User</label>
                                <select class="form-control select2" id="user_id" name="user_id">
                                    <option value=0 disabled selected>Select user..</option>

                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="action" class=" col-sm-12 col-form-label">Event</label>
                                <select class="form-control select2" id="action" name="action">

                                    <option value=0 disabled selected>Select Event..</option>
                                    <option value="created">Created</option>
                                    <option value="updated">updated</option>
                                    <option value="deleted">deleted</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="model" class=" col-sm-12 col-form-label">Model</label>
                                <select class="form-control select2" id="model" name="model">

                                    <option value=0 disabled selected>Select Model..</option>
                                    @foreach ($models as  $model)
                                    <option value="{{$model}}">{{$model}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary  mx-4 my-4" name="filter" value="filter"><i
                                class="fa fa-search"></i> Search</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">All Model Audits</h5>
            <table class="table table-reponsive table-bordered" width="100">
                <thead class="thead-light-dark">
                    <tr>
                        <th scope="col">Model</th>
                        <th scope="col">Action</th>
                        <th scope="col">Responsible User</th>
                        <th scope="col">Time</th>
                        <th scope="col">Old Values</th>
                        <th scope="col">New Values</th>
                    </tr>
                </thead>
                <tbody id="audits">
                    @foreach ($audits as $audit)
                        <tr>
                            <td>{{ $audit->auditable_type }} (id: {{ $audit->auditable_id }})</td>
                            <td>{{ $audit->event }}</td>
                            <td>{{ $audit->user?->name }}</td>
                            <td>{{ $audit->created_at }}</td>
                            <td>
                                <table class="table">
                                    @foreach ($audit->old_values as $attribute => $value)
                                        <tr class="text text-danger font-bold">
                                            <td><b>{{ $attribute }}</b></td>
                                            @if (strlen($value) > 20)
                                                <td>
                                                    <details>
                                                        <summary> {{ str_limit($value, 20) }}
                                                        </summary>
                                                        {{ $value }}
                                                    </details>
                                                </td>
                                            @else
                                                <td>
                                                    {{ $value }}
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                            <td>
                                <table class="table">
                                    @foreach ($audit->new_values as $attribute => $value)
                                        <tr class="text text-success font-bold">
                                            <td><b>{{ $attribute }}</b></td>
                                            @if (strlen($value) > 10)
                                                <td>
                                                    <details>
                                                        <summary> {{ str_limit($value, 10) }}
                                                        </summary>
                                                        {{ $value }}
                                                    </details>
                                                </td>
                                            @else
                                                <td>
                                                    {{ $value }}
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach



                                </table>
                            </td>
                        </tr>
                    @endforeach
                    @if (count($audits) < 1)
                        <tr>
                            <td class="text text-danger">No Data Found!!</td>
                        </tr>
                    @endif
                </tbody>

            </table>
            <div class="d-flex justify-content-center">
                {!! $audits->links() !!}
            </div>
        </div>
    </div>
@endsection
