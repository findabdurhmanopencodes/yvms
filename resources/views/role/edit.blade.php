<x-admin-layout>
    @push('styles')
    @endpush
    <x-slot name="title">Edit role</x-slot>
    <x-slot name="breadcrumbTitle">Edit role</x-slot>
    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item"><a href="{{route('role.index')}}">Roles</a></li>
        <li class="breadcrumb-item active">{{$role->name}}</li>
        <li class="breadcrumb-item active">Edit</li>
    </x-slot>
    <div class="row">
        <div class="col-12">
            {!! Form::model($role, ['route'=>['role.update','role'=>$role->id],'method'=>'PATCH']) !!}
                @method('patch')
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
                    <i class="fal fa-sync"></i> Update Role
                </button>
            </form>
        </div>
    </div>
</x-admin-layout>
