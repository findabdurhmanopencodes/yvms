@extends('layouts.app')
@section('title', 'All Users')
@section('breadcrumb-list')
    <li class="active">Users</li>
@endsection
@section('content')
    <div class="py-2 pr-4">
        <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add User</a>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Users</h3>
        </div>
        <div class="p-0 card-body">
            <table class="table table-striped table-bordered table-hover dataTable no-footer table-striped projects">
                <thead>
                    <tr>
                        <th style="width: 1%">
                            #
                        </th>
                        <th style="width: 20%">
                            Full Name
                        </th>
                        <th style="width: 20%">
                            Email
                        </th>
                        <th style="width: 20%">
                            Created at
                        </th>
                        <th style="width: 10%">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <a>{{ $user->name() }}</a>
                            </td>
                            <td>
                                <a>{{ $user->email }}</a>
                            </td>
                            <td>{{ $user->created_at->diffForHumans() }}</td>
                            <td class="text-right project-actions">
                                <a class="btn btn-sm  btn-primary" href="{{ route('user.show', ['user' => $user->id]) }}">
                                    <i class="fa fa-eye">
                                    </i>
                                </a>
                                <a class="btn btn-sm  btn-primary" href="{{ route('user.edit', ['user' => $user->id]) }}">
                                    <i class="fa fa-pencil">
                                    </i>
                                </a>
                                <a class="btn btn-danger btn-sm" href="#" onclick="deleteUser({{ $user->id }},this);">
                                    <i class="fa fa-trash">
                                    </i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    @empty($users)
                        <tr>
                            <td colspan="3">
                                <b>Users not found</b>
                            </td>
                        </tr>
                    @endempty
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
@endsection
