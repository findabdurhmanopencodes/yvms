@extends('layouts.app')
@section('title', 'All Users')
@section('breadcrumb-list')
    <li class=""><a href="{{ route('user.index', []) }}">Users</a></li>
    <li class="active">Add User</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">

            <form method="POST" class="row" action="{{ route('register') }}">
                @csrf
                <div class="col-md-4">
                    <x-jet-label for="first_name" value="{{ __('First Name') }}" />
                    <x-jet-input id="first_name" class="form-control" type="text" name="first_name" :value="old('first_name')"
                        required autofocus autocomplete="first_name" />
                </div>
                <div class="col-md-4">
                    <x-jet-label for="father_name" value="{{ __('Father Name') }}" />
                    <x-jet-input id="father_name" class="form-control" type="text" name="father_name" :value="old('father_name')"
                        required autofocus autocomplete="father_name" />
                </div>
                <div class="col-md-4">
                    <x-jet-label for="grand_father_name" value="{{ __('Grand Father Name') }}" />
                    <x-jet-input id="grand_father_name" class="form-control" type="text" name="grand_father_name"
                        :value="old('grand_father_name')" required autofocus autocomplete="grand_father_name" />
                </div>

                <div class="col-md-4">
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <x-jet-input id="email" class="form-control" type="email" name="email" :value="old('email')" required />
                </div>

                <div class="col-md-4">
                    <x-jet-label for="password" value="{{ __('Password') }}" />
                    <x-jet-input id="password" class="form-control" type="password" name="password" required
                        autocomplete="new-password" />
                </div>

                <div class="col-md-4">
                    <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-jet-input id="password_confirmation" class="form-control" type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                </div>
                <div class="col-md-4">
                    <x-jet-label for="roles" value="{{ __('Roles') }}" />
                    <select name="roles" id="roles">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ Str::upper($role->name) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12" style="margin-top:5px;">
                    <x-jet-button class="ml-4 btn btn-sm btn-primary">
                        {{ __('Register') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </div>
@endsection
