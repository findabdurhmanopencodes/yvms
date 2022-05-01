<x-admin-layout>
    <x-slot name="title">Add role</x-slot>
    <x-slot name="breadcrumbTitle">Add new role</x-slot>
    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item"><a href="{{route('role.index')}}">Roles</a></li>
        <li class="breadcrumb-item active">New</li>
    </x-slot>
    <div class="row">
        <div class="col-12">
            <form  method="POST" action="{{ route('role.store', []) }}">
                @csrf
                <div class="row">
                    <div class="col-md-12 form-group">
                        <x-jet-label for="name" value="{{__('Name')}}"/>
                        {!! Form::text('name', null, ['class'=>'form-control '.($errors->has('name')?'is-invalid':''),'placeholder'=>'Name']) !!}
                        @error('name')
                        <small class="text-danger"><b>{{$message}}</b></small>
                        @enderror
                    </div>
                </div>
                <button class=" btn btn-outline-primary btn-rounded btn-floating">
                    <i class="fal fa-plus"></i> Add Role
                </button>
            </form>
        </div>
    </div>
</x-admin-layout>
