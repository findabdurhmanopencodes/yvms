@extends('layouts.app')
@push('css')  
@endpush
@section('content')

<div class="py-2 pr-4">
    <a href="{{ route('educational_level.create') }}" class="float-right btn btn-sm btn-primary"><i class="fal fa-plus"></i>
        Add Level of Education</a>
    <div class="clearfix"></div>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Level of Education</h3>
    </div>
    <div class="p-0 card-body">
        <table class="table table-striped table-striped table-bordered table-hover dataTable no-footer">
            <thead>
                <tr>
                    <th style="width: 1%">#</th>
                    <th style="width: 20%">Name</th>
                    <th style="width: 20%">Created At </th>
                    <th style="width: 10%">Action </th>
                </tr>
            </thead>
            <tbody>
                @if (count($educational_levels) == 0)
                    <tr>
                        <td colspan="4" class="text-center"><b> No educational level available!</b></td>
                    </tr>
                @endif
                @foreach ($educational_levels as $key => $educational_level)
               
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <a>{{ $educational_level->name }}</a>
                        </td>
                        <td>{{ $educational_level->created_at }}</td>
                        <td class="text-right project-actions">
                            <a class="btn btn-sm btn-primary btn-round" href="#">
                                {{-- {{ route('Level of Education.edit', ['educationalLevel' => $educational_levels->id]) }} --}}
                                <i class="fa fa-pencil"></i>
                                Edit
                            </a>
                            <a class="btn btn-sm btn-danger btn-round" href="#" onclick="DeleteEducationalLevel({{ $educational_level->id }},this);">
                                <i class="fad fa-trash"></i>
                                Delete
                            </a>

     
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>

<form method="POST" id="deleteForm">
    @method('delete')
    @csrf
</form>
@push('js')
    <script>
        function DeleteEducationalLevel(permissionId, parent) {
            event.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: '/permission/' + permissionId,
                        data: {
                            "id": permissionId,
                            "_method": 'DELETE',
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        dataType: 'json',
                        success: function(data) {
                            $(parent).closest('tr')[0].remove();
                            Swal.fire(
                                "Deleted!",
                                "Education level has been deleted.",
                                "success"
                            )
                        },
                        error: function(data) {
                            if (data.status) {
                                Swal.fire("Forbidden!", "You can't delete this permission!", "error");
                            }
                        }
                    });
                }
            });
        }

  
    </script>
@endpush
@endsection

@push('js')
    
@endpush