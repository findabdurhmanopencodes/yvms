@extends('layouts.app')
@section('title', 'Screening Applicant')
@section('breadcrumb-list')
    <li class="active">Screening</li>
@endsection
@section('breadcrumbTitle', 'Applicant Detail')
@section('breadcrumbList')

    <li class="breadcrumb-item">
        <a href="" class="text-muted">Applicant Screening</a>
    </li>
    <li class="breadcrumb-item">
        <a href="" class="text-muted">{{ $applicant->first_name }} {{ $applicant->father_name }}</a>
    </li>
@endsection
@push('js')
    <script>
        var HOST_URL = "{{ route('role.index') }}";

        function accept(roleId, parent) {
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
                        url: '/role/' + roleId,
                        data: {
                            "id": roleId,
                            "_method": 'DELETE',
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        dataType: 'json',
                        success: function(data) {
                            $(parent).closest('tr')[0].remove();
                            Swal.fire(
                                "Deleted!",
                                "Role has been deleted.",
                                "success"
                            )
                        },
                        error: function(data) {
                            if (data.status) {
                                Swal.fire("Forbidden!", "You can't delete this role!", "error");
                            }
                        }
                    });
                }
            });
        }
    </script>
@endpush

@section('content')
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-body">
                    <!--begin::Details-->
                    <div class="d-flex mb-9">
                        <!--begin: Pic-->
                        {{-- @dd($applicant->picture()->file_path)
                        @dd(asset($applicant->picture()->file_path) ) --}}
                        <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                            <div class="symbol symbol-40 symbol-lg-90">
                                <img src="{{ asset($applicant->picture()->file_path) }}" alt="image">
                            </div>
                            <div class="symbol symbol-50 symbol-lg-120 symbol-primary d-none">
                                <span class="font-size-h3 symbol-label font-weight-boldest"></span>
                            </div>
                        </div>
                        <!--end::Pic-->
                        <!--begin::Info-->
                        <div class="flex-grow-1">
                            <!--begin::Title-->
                            <div class="d-flex justify-content-between flex-wrap mt-1">
                                <div class="d-flex mr-3">
                                    <a href="#"
                                        class="text-dark-75 text-hover-primary font-size-h5 font-weight-bold mr-3">{{ $applicant->first_name }}
                                        {{ $applicant->father_name }} {{ $applicant->father_grand_name }}</a>
                                    <a href="#">
                                        <i class="flaticon2-correct text-success font-size-h5"></i>
                                    </a>
                                </div>
                                <div class="">


                                </div>
                                {{-- @dd($applicant->status) --}}
                                @if ($applicant->status?->acceptance_status == 0 || $applicant->status?->acceptance_status == 2)
                                    <form
                                        action="{{ route('session.applicant.screen', ['training_session' => Request::route('training_session'), 'applicant_id' => $applicant->id]) }}"
                                        method="POST">
                                        @csrf
                                        <button class="btn btn-bg btn-info font-weight-bolder" type="submit"><i
                                                class="fa fa-check"></i>Accept Aplicant</button>
                                        <input type="hidden" value="accept" name="type">

                                    </form>
                                @endif
                                @if ($applicant->status?->acceptance_status == 0 || $applicant->status?->acceptance_status == 1)
                                    <button class="btn btn-bg btn-danger font-weight-bolder" data-toggle="modal"
                                        data-target="#reject_button" value="reject"><i class=""></i>Reject
                                        Applicant</button>
                                @endif
                            </div>
                            <!--end::Title-->
                            <!--begin::Content-->
                            <div class="d-flex flex-wrap justify-content-between mt-4">
                                <div class="d-flex flex-column flex-grow-1 pr-8">
                                    <div class="d-flex flex-wrap mb-4">
                                        <a href="#"
                                            class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                            <i
                                                class="flaticon2-user-outline-symbol mr-2 font-size-lg"></i>{{ $applicant->gender == 'f' || 'F' ? 'Femail' : 'Male' }}</a>
                                        <a href="#"
                                            class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                            <i
                                                class="flaticon2-new-email mr-2 font-size-lg"></i>{{ $applicant->email }}</a>
                                        <a href="#"
                                            class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                            <i class="flaticon2-phone mr-2 font-size-lg"></i>{{ $applicant->phone }}</a>
                                        <a href="#" class="text-dark-50 text-hover-primary font-weight-bold">
                                            <i
                                                class="flaticon2-placeholder mr-2 font-size-lg"></i>{{ $applicant->woreda->name }},
                                            {{ $applicant->woreda->zone->name }}
                                            {{ $applicant->woreda->zone->region->name }}</a>
                                    </div>

                                </div>

                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Details-->
                    <div class="separator separator-solid"></div>
                    <!--begin::Items-->
                    <div class="d-flex align-items-center flex-wrap mt-8">
                        <!--begin::Item-->
                        <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                            <span class="mr-4">
                                <i class="flaticon-file display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">Educationl Level</span>
                                <span class="font-weight-bolder font-size-h5">
                                    <span
                                        class="text-dark-50 font-weight-bold"></span>{{ $applicant->educationalLevel()[$applicant->educational_level] }}</span>
                            </div>
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                            <span class="mr-4">
                                <i class="flaticon-book display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">Field Of Study</span>
                                <span class="font-weight-bolder font-size-h5">
                                    <span
                                        class="text-dark-50 font-weight-bold"></span>{{ $applicant->fieldOfStudy->name }}</span>
                            </div>
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                            <span class="mr-4">
                                <i class="flaticon-book display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">Gpa</span>
                                <span class="font-weight-bolder font-size-h5">
                                    <span class="text-dark-50 font-weight-bold"></span>{{ $applicant->gpa }}</span>
                            </div>
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                            <span class="mr-4">
                                <i class="flaticon-avatar display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">Conatct Name</span>
                                <span class="font-weight-bolder font-size-h5">
                                    <span
                                        class="text-dark-50 font-weight-bold"></span>{{ $applicant->contact_name }}</span>
                            </div>
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                            <span class="mr-4">
                                <i class="flaticon2-phone display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">Conatct Phone</span>
                                <span class="font-weight-bolder font-size-h5">
                                    <span
                                        class="text-dark-50 font-weight-bold"></span>{{ $applicant->contact_phone }}</span>
                            </div>
                        </div>
                        <!--end::Item-->

                    </div>
                    <!--begin::Items-->
                </div>
            </div>
            <!--end::Card-->
            <!--begin::Row-->
            <div class="row">
                <div class="col-lg-12">
                    <!--begin::Advance Table Widget 2-->
                    <div class="card card-custom card-stretch gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                Documents
                            </h3>

                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-3 pb-0">
                            <!--begin::Table-->
                            <div class="table-responsive">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless table-vertical-center">
                                            <h4>Educational Documents</h4>
                                            <thead>
                                                <tr>
                                                    <th class="p-0" style="width: 50px"></th>
                                                    <th class="p-0" style="min-width: 200px"></th>
                                                    <th class="p-0" style="min-width: 100px"></th>
                                                    <th class="p-0" style="min-width: 125px"></th>
                                                    <th class="p-0" style="min-width: 110px"></th>
                                                    <th class="p-0" style="min-width: 150px"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <div class="col-4">
                                                    <tr>
                                                        <td class="pl-0 py-4">
                                                            <div class="symbol symbol-50 symbol-light mr-1">
                                                                <span class="symbol-label">
                                                                    <img src="{{ asset('assets/media/svg/misc/007-disqus.svg') }}"
                                                                        class="h-50 align-self-center" alt="">
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td class="pl-0">
                                                            <a href="#"
                                                                class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">8th
                                                                Grade Ministry File</a>
                                                            <div>
                                                                <span class="font-weight-bolder">Size:</span>
                                                                {{-- {{ $applicant->getMinistryFileSize() }} --}}
                                                                22 Kb
                                                            </div>
                                                        </td>

                                                        <td class="text-right">
                                                            <span class="label label-lg label-light-primary label-inline"><a
                                                                    href="{{ asset($applicant->picture()->file_path) }}"
                                                                    target="_blank">Open
                                                                    File</a></span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td class="pl-0 py-4">
                                                            <div class="symbol symbol-50 symbol-light mr-1">
                                                                <span class="symbol-label">
                                                                    <img src="{{ asset('assets/media/svg/misc/007-disqus.svg') }}"
                                                                        class="h-50 align-self-center" alt="">
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td class="pl-0">
                                                            <a href="#"
                                                                class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">
                                                                Bsc Degree Documnet File</a>
                                                            <div>
                                                                <span class="font-weight-bolder">Size:</span>
                                                                {{-- {{ $applicant->getMinistryFileSize() }} --}}
                                                                22 Kb
                                                            </div>
                                                        </td>
                                                        @if ($applicant->getBsc() != null)
                                                            <td class="text-right">
                                                                <span
                                                                    class="label label-lg label-light-primary label-inline"><a
                                                                        href="{{ asset($applicant->getBsc()->file_path) }}"
                                                                        target="_blank">Open
                                                                        File</a></span>
                                                            </td>
                                                        @else
                                                            <td class="text-right">
                                                                <span class="badge badge-danger badge-pill">Not
                                                                    Available</span>
                                                            </td>
                                                        @endif



                                                    </tr>
                                                    <tr>
                                                        <td class="pl-0 py-4">
                                                            <div class="symbol symbol-50 symbol-light mr-1">
                                                                <span class="symbol-label">
                                                                    <img src="{{ asset('assets/media/svg/misc/007-disqus.svg') }}"
                                                                        class="h-50 align-self-center" alt="">
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td class="pl-0">
                                                            <a href="#"
                                                                class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">
                                                                Msc Degree Documnet File</a>
                                                            <div>
                                                                <span class="font-weight-bolder">Size:</span>
                                                                {{-- {{ $applicant->getMinistryFileSize() }} --}}
                                                                22 Kb
                                                            </div>
                                                        </td>
                                                        @if ($applicant->getMsc() != null)
                                                            <td class="text-right">
                                                                <span
                                                                    class="label label-lg label-light-primary label-inline"><a
                                                                        href="{{ asset($applicant->getMsc()->file_path) }}"
                                                                        target="_blank">Open
                                                                        File</a></span>
                                                            </td>
                                                        @else
                                                            <td class="text-right">
                                                                <span class="badge badge-danger badge-pill">Not
                                                                    Available</span>
                                                            </td>
                                                        @endif



                                                    </tr>

                                                    <tr>
                                                        <td class="pl-0 py-4">
                                                            <div class="symbol symbol-50 symbol-light mr-1">
                                                                <span class="symbol-label">
                                                                    <img src="{{ asset('assets/media/svg/misc/007-disqus.svg') }}"
                                                                        class="h-50 align-self-center" alt="">
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td class="pl-0">
                                                            <a href="#"
                                                                class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">
                                                                Msc Degree Documnet File</a>
                                                            <div>
                                                                <span class="font-weight-bolder">Size:</span>
                                                                {{-- {{ $applicant->getMinistryFileSize() }} --}}
                                                                22 Kb
                                                            </div>
                                                        </td>
                                                        @if ($applicant->getPhd() != null)
                                                            <td class="text-right">
                                                                <span
                                                                    class="label label-lg label-light-primary label-inline"><a
                                                                        href="{{ asset($applicant->getPhd()->file_path) }}"
                                                                        target="_blank">Open
                                                                        File</a></span>
                                                            </td>
                                                        @else
                                                            <td class="text-right">
                                                                <span class="badge badge-danger badge-pill">Not
                                                                    Available</span>
                                                            </td>
                                                        @endif



                                                    </tr>

                                                </div>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless table-vertical-center">
                                            <thead>
                                                <h4>Personal Documents</h4>

                                                <tr>
                                                    <th class="p-0" style="width: 50px"></th>
                                                    <th class="p-0" style="min-width: 200px"></th>
                                                    <th class="p-0" style="min-width: 100px"></th>
                                                    <th class="p-0" style="min-width: 125px"></th>
                                                    <th class="p-0" style="min-width: 110px"></th>
                                                    <th class="p-0" style="min-width: 150px"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($applicant->gender == 'F' || $applicant->gender == 'f')
                                                    <tr>
                                                        <td class="pl-0 py-4">
                                                            <div class="symbol symbol-50 symbol-light mr-1">
                                                                <span class="symbol-label">
                                                                    <img src="{{ asset('assets/media/svg/misc/007-disqus.svg') }}"
                                                                        class="h-50 align-self-center" alt="">
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td class="pl-0">
                                                            <a href="#"
                                                                class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">
                                                                Non- Pregenant Document</a>
                                                            <div>
                                                                <span class="font-weight-bolder">Size:</span>
                                                                {{-- {{ $applicant->getMinistryFileSize() }} --}}
                                                                22 Kb
                                                            </div>
                                                        </td>
                                                        @if ($applicant->getPregnant() != null)
                                                            <td class="text-right">
                                                                <span
                                                                    class="label label-lg label-light-primary label-inline"><a
                                                                        href="{{ asset($applicant->getPregnant()->file_path) }}"
                                                                        target="_blank">Open
                                                                        File</a></span>
                                                            </td>
                                                        @else
                                                            <td class="text-right">
                                                                <span class="badge badge-danger badge-pill">Not
                                                                    Available</span>
                                                            </td>
                                                        @endif



                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td class="pl-0 py-4">
                                                        <div class="symbol symbol-50 symbol-light mr-1">
                                                            <span class="symbol-label">
                                                                <img src="{{ asset('assets/media/svg/misc/007-disqus.svg') }}"
                                                                    class="h-50 align-self-center" alt="">
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="pl-0">
                                                        <a href="#"
                                                            class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">
                                                            Ethical Licence Document</a>
                                                        <div>
                                                            <span class="font-weight-bolder">Size:</span>
                                                            {{-- {{ $applicant->getMinistryFileSize() }} --}}
                                                            22 Kb
                                                        </div>
                                                    </td>
                                                    @if ($applicant->getEthical() != null)
                                                        <td class="text-right">
                                                            <span
                                                                class="label label-lg label-light-primary label-inline"><a
                                                                    href="{{ asset($applicant->getEthical()->file_path) }}"
                                                                    target="_blank">Open
                                                                    File</a></span>
                                                        </td>
                                                    @else
                                                        <td class="text-right">
                                                            <span class="badge badge-danger badge-pill">Not
                                                                Available</span>
                                                        </td>
                                                    @endif



                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--end::Table-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Advance Table Widget 2-->
                </div>

            </div>
            <!--end::Row-->
            <!--begin::Row-->

            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>



    <div class="modal fade" id="reject_button" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                @can('Volunteer.Screen')
                    <form method="POST"
                        action="{{ route('session.applicant.screen', ['training_session' => Request::route('training_session'), 'applicant_id' => $applicant->id]) }}">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Rejection Reason</h5>
                            <button type="button" class="close" data-dismiss="modal" -label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group mb-1">
                                <label for="exampleTextarea">Rejection Reason</label>
                                <textarea class="form-control" id="exampleTextarea" rows="3" name="rejection_reason"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold"
                                data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary font-weight-bold" value="reject" name="type">Save
                                changes</button>
                        </div>
                    </form>
                @endcan
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/pages/crud/forms/widgets/select2.js') }}"></script>
@endpush
