@php
    use App\Models\User;
    /** @var $material \App\Models\Material */
@endphp
@extends('layout.main')
@section('title')
    {{ $material->subject }}
@endsection
@section('buttons')
    @if(in_array(auth()?->user()?->role_id, [User::ROLE_ADMIN, User::ROLE_MENTOR]))
        <a class="btn btn-outline-dark" href="{{ route('material-edit', ['id' => $material]) }}"><i
                class="fas fa-pencil-alt"></i></a>
        <form method="post" class="d-inline" action="{{ route('material-delete', ['id' => $material]) }}"
              onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
            @csrf
            <button type="submit" class="btn btn-lg btn-danger"><i class="fas fa-trash-alt"></i></button>
        </form>
    @endif
@endsection
@section('content')

    <div class="container">
        <div class="row py-2 bg-light">
            <div class="col-12 col-md-3 mb-2">
                <div class="text-muted fw-light">Добавлено:</div>
                <div>{{ $material->created_at }}</div>
            </div>

            <div class="col-12 col-md-3 mb-2">
                <div class="text-muted fw-light">Обновлено:</div>
                <div>@if($material->created_at != $material->updated_at)
                        {{ $material->updated_at }}
                    @endif</div>
            </div>

            <div class="col-12 col-md-3 mb-2">
                <div class="text-muted fw-light">Автор:</div>
                <div>{{ $material->author?->employee?->fullName ?? $material->author?->name }}</div>
            </div>

            <div class="col-12 col-md-3 mb-2">
                <div class="text-muted fw-light">Категория</div>
                <div>{{ $material->category }}</div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 my-5">{!! nl2br($material->text) !!}</div>
        </div>
    </div>

@endsection
