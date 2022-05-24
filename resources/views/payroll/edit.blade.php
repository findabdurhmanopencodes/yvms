.b<x-admin-layout>
    @push('styles')
    @endpush
    <x-slot name="title">Edit payroll</x-slot>
    <x-slot name="breadcrumbTitle">Edit payroll</x-slot>
    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item"><a href="{{route('permission.index')}}">Payrolls</a></li>
        <li class="breadcrumb-item active">{{$payroll->name}}</li>
        <li class="breadcrumb-item active">Edit</li>
    </x-slot>
    <div class="row">
        <div class="col-12">
            {!! Form::model($payroll, ['route'=>['payroll.update','payroll'=>$payroll->id],'method'=>'PATCH']) !!}
                @method('patch')
                @csrf
                <div class="row">
                    <div class="col-md-12 form-group">
                        <x-jet-label for="name" value="{{__('Name')}}"/>
                        {!! Form::text('name', null, ['class'=>'form-control '.($errors->has('name')?'is-invalid':''),'placeholder'=>'Code']) !!}
                        @error('name')
                        <small class="text-danger"><b>{{$message}}</b></small>
                        @enderror
                    </div>
                </div>
                <button class=" btn btn-outline-primary btn-rounded btn-floating">
                    <i class="fal fa-sync"></i> Update Payroll
                </button>
            </form>
        </div>
    </div>
</x-admin-layout>
