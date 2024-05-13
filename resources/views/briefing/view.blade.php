@php
    /** @var $briefing \App\Models\Briefing */
@endphp
@extends('layout.main')
@section('title')Инструктаж: {{ $briefing->subject }}@endsection
@section('buttons')
    <a class="btn btn-outline-dark" href="{{ route('briefing-edit', ['id' => $briefing]) }}"><i class="fas fa-pencil-alt"></i></a>
    <form method="post" class="d-inline" action="{{ route('briefing-delete', ['id' => $briefing]) }}"
          onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
        @csrf
        <button type="submit" class="btn btn-lg btn-danger"><i class="fas fa-trash-alt"></i></button>
    </form>
@endsection
@section('content')

    <div class="container">
        <div class="row py-2 bg-light">
            <div class="col-12 col-md-3 mb-2">
                <div class="text-muted fw-light">Добавлено: </div>
                <div>{{ $briefing->created_at }}</div>
            </div>

            <div class="col-12 col-md-3 mb-2">
                <div class="text-muted fw-light">Обновлено: </div>
                <div>@if($briefing->created_at != $briefing->updated_at) {{ $briefing->updated_at }} @endif</div>
            </div>

            <div class="col-12 col-md-3 mb-2">
                <div class="text-muted fw-light">Автор: </div>
                <div>{{ $briefing->author?->fullName }}</div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 my-5">{!! nl2br($briefing->text) !!}</div>
        </div>
    </div>

@endsection
