.b<x-admin-layout>
    @push('styles')
    @endpush
    <x-slot name="title">Edit permission</x-slot>
    <x-slot name="breadcrumbTitle">Edit permission</x-slot>
    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item"><a href="{{route('permission.index')}}">Permissions</a></li>
        <li class="breadcrumb-item active">{{$permission->name}}</li>
        <li class="breadcrumb-item active">Edit</li>
    </x-slot>
    <div class="row">
        <div class="col-12">
            {!! Form::model($permission, ['route'=>['permission.update','permission'=>$permission->id],'method'=>'PATCH']) !!}
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
                    <i class="fal fa-sync"></i> Update Permission
                </button>
            </form>
        </div>
    </div>
</x-admin-layout>
