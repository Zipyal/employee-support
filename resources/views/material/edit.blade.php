@php
    use App\Models\Material;
    use App\Models\Permission;

    /** @var Material $material */
@endphp
@extends('layout.main')
@section('title')
    {{ $material->uuid ? 'Редактирование' : 'Создание' }} материала
@endsection
@if(Route::is('material-edit'))
    @section('buttons')
        @canany([Permission::MATERIAL_SEE_ALL, Permission::MATERIAL_SEE_OWN, Permission::MATERIAL_SEE_PUBLISHED])
            <a class="btn btn-outline-dark" href="{{ route('material-show', ['id' => $material->uuid]) }}"><i
                    class="far fa-eye"></i></a>
        @endcanany
        @can(Permission::MATERIAL_DELETE)
            <form method="post" class="d-inline" action="{{ route('material-delete', ['id' => $material]) }}"
                  onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
                @csrf
                <button type="submit" class="btn btn-lg btn-danger"><i class="fas fa-trash-alt"></i></button>
            </form>
        @endcan
    @endsection
@endif
@section('content')

    @php
        if (isset($material->uuid)) {
            $formUrl = route('material-update', ['id' => $material->uuid]);
        } else {
            $formUrl = route('material-store');
        }
    @endphp

    <div class="container">
        <form method="post" action="{{ $formUrl }}" enctype="multipart/form-data" class="row g-3 needs-validation">
            @csrf
            <div class="col-12 col-md-8">
                <label for="subject" class="form-label">Тема</label>
                <div class="input-group has-validation">
                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject"
                           name="subject" value="{{ old('subject') ?? $material->subject }}">
                    @error('subject')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <label for="category" class="form-label">Категория</label>
                <div class="input-group has-validation">
                    <input type="text" class="form-control @error('category') is-invalid @enderror" id="category"
                           name="category" value="{{ old('category')  ?? $material->category }}">
                    @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                @include('_form_upload_image', ['images' => $material->images])
            </div>

            <div class="col-12">
                <label for="text" class="form-label">Текст</label>
                <div class="input-group has-validation">
                    <textarea class="form-control @error('text') is-invalid @enderror" id="text"
                              name="text">{{ old('text') ?? $material->text }}</textarea>
                    @error('text')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 mt-5">
                <div class="row">
                    <div class="col text-start">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Сохранить</button>
                    </div>
                    <div class="col text-center">
                        <button type="submit" name="stay-here" class="btn btn-outline-primary" value="1"><i class="fas fa-save"></i> Сохранить и продолжить редактирование</button>
                    </div>
                    <div class="col text-end">
                        @if($material->uuid)
                            <a class="btn btn-outline-warning"
                               href="{{ route('material-show', ['id' => $material->uuid]) }}"><i class="fas fa-ban"></i>
                                Отмена</a>
                        @else
                            <button type="reset" class="btn btn-outline-danger"><i class="fas fa-eraser"></i> Очистить
                                форму
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
