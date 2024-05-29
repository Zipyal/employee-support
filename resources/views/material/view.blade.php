@php
    use App\Models\Material;
    use App\Models\Permission;
    use App\Models\User;

    /** @var Material $material */
@endphp
@extends('layout.main')
@section('title')
    {{ $material->subject }}
@endsection
@section('buttons')
    @can(Permission::MATERIAL_EDIT)
        <a class="btn btn-outline-dark" href="{{ route('material-edit', ['id' => $material]) }}"><i
                class="fas fa-pencil-alt"></i></a>
    @endcan
    @can(Permission::MATERIAL_DELETE)
        <form method="post" class="d-inline" action="{{ route('material-delete', ['id' => $material]) }}"
              onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
            @csrf
            <button type="submit" class="btn btn-lg btn-danger"><i class="fas fa-trash-alt"></i></button>
        </form>
    @endcan
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

            <div class="col-12 col-md-2 mb-2">
                <div class="text-muted fw-light">Категория</div>
                <div>{{ $material->category }}</div>
            </div>

            <div class="col-12 col-md-1 mb-2">
                <div class="text-muted fw-light">Опубликовано:</div>
                <div>@if($material->published)
                        <span class="text-success">да</span>
                    @else
                        <span class="text-danger">нет</span>
                    @endif</div>
            </div>
        </div>

        <div class="row my-5">
            <div class="col-12">
                @include('_images_gallary', ['images' => $material->images])
            </div>
            <div class="col-12 my-3">{!! nl2br($material->text) !!}</div>
        </div>
    </div>

@endsection
