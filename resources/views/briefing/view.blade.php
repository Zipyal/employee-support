@php
    use App\Models\Briefing;
    use App\Models\BriefingEmployee;
    use App\Models\Permission;
    use Rolandstarke\Thumbnail\Facades\Thumbnail;

    /** @var $briefing Briefing */
@endphp
@extends('layout.main')
@section('title')
    Инструктаж: {{ $briefing->subject }}
@endsection
@section('buttons')
    @canany([Permission::BRIEFING_EDIT, Permission::BRIEFING_EDIT_OWN])
        <a class="btn btn-outline-dark" href="{{ route('briefing-edit', ['id' => $briefing]) }}"><i
                class="fas fa-pencil-alt"></i></a>
    @endcanany
    @canany([Permission::BRIEFING_DELETE, Permission::BRIEFING_DELETE_OWN])
        <form method="post" class="d-inline" action="{{ route('briefing-delete', ['id' => $briefing]) }}"
              onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
            @csrf
            <button type="submit" class="btn btn-lg btn-danger"><i class="fas fa-trash-alt"></i></button>
        </form>
    @endcanany
@endsection
@section('content')

    <div class="container">
        <div class="row py-2 bg-light">
            <div class="col-12 col-md-3 mb-2">
                <div class="text-muted fw-light">Добавлено:</div>
                <div>{{ $briefing->created_at }}</div>
            </div>

            <div class="col-12 col-md-3 mb-2">
                <div class="text-muted fw-light">Обновлено:</div>
                <div>@if($briefing->created_at != $briefing->updated_at)
                        {{ $briefing->updated_at }}
                    @endif</div>
            </div>

            <div class="col-12 col-md-3 mb-2">
                <div class="text-muted fw-light">Автор:</div>
                <div>{{ $briefing->author?->employee?->fullName ?? $briefing->author?->name }}</div>
            </div>

            <div class="col-12 col-md-3 mb-2">
                <div class="text-muted fw-light">Опубликовано:</div>
                <div>@if($briefing->published)
                        <span class="text-success">да</span>
                    @else
                        <span class="text-danger">нет</span>
                    @endif</div>
            </div>
        </div>

        <div class="row my-5">
            <div class="col-12">
                @include('_images_gallary', ['images' => $briefing->images])
            </div>
            <div class="col-12 my-3">
                {!! nl2br($briefing->text) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-12 text-center">
                @if(!BriefingEmployee::query()->where('briefing_uuid', '=', $briefing->uuid)->where('employee_uuid', '=', auth()->user()?->employee?->uuid)->count())
                    <form action="{{ route('briefing-read', ['id' => $briefing->uuid]) }}" method="post">
                        @csrf
                        <button class="btn btn-outline-success" type="submit">Подтвердить прочтение</button>
                    </form>
                @else
                    <div class="btn btn-success disabled">Прочитано <i class="fas fa-check"></i></div>
                @endif
            </div>
        </div>
    </div>

@endsection
