@extends('layouts.app')
@section('title', 'Translation Texts')
@section('content')
    <div class="card card-custom">

        <div class="card-header">
            <div class="card-title">
                <h3 class="title-label">Translation texts</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('translation.create', []) }}" class="btn btn-primary"><i class="fa fa-plus"></i>Add new translation</a>
            </div>
        </div>
        <div class="card-body">
            <table width="100%" class="table">
                <thead>
                    </tr>
                    {{-- <th>Title</th> --}}
                    <th>Language</th>
                    <th>Type</th>
                    <th>Action</th>
                    {{-- <th><i class="menu-icon flaticon-list"></i> </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($translationTexts as $translationText)
                        <tr>
                            <td>{{ $translationText->language->name }}</td>
                            <td>{{ $translationText->trasnslationType() }}</td>
                            {{-- <td>{{ count($translationText->volunteers) }}</td> --}}
                            <td>
                                {{-- <a href="#"
                                    onclick="confirmDeleteRoom('{{ route('session.cindication_room.destroy', ['training_session' => Request::route('training_session')->id, 'training_center' => $trainingCenter->id, 'cindication_room' => $translation.0Text->id]) }}')">
                                    <i class="fal fa-trash"></i>
                                </a>
                                <a
                                    href="{{ route('session.cindication_room.show', ['training_session' => Request::route('training_session')->id, 'training_center' => $trainingCenter->id, 'cindication_room' => $translationText->id]) }}">
                                    <i class="fal fa-eye"></i>
                                </a> --}}
                            </td>
                        </tr>
                    @endforeach

                    @if (count($translationTexts) <= 0)
                        <tr style="font-size: 13px;" class="text-center">
                            <td colspan="3" style="">No cindication room</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
