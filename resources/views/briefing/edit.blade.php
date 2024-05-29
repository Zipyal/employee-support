@php
    use App\Models\Briefing;
    use App\Models\Permission;

    /** @var Briefing $briefing */
@endphp
@extends('layout.main')
@section('title')
    {{ $briefing->uuid ? 'Редактирование' : 'Создание' }} инструктажа
@endsection
@if(Route::is('briefing-edit'))
    @section('buttons')
        @canany([Permission::BRIEFING_SEE_ALL, Permission::BRIEFING_SEE_OWN, Permission::BRIEFING_SEE_PUBLISHED])
            <a class="btn btn-outline-dark" href="{{ route('briefing-show', ['id' => $briefing->uuid]) }}"><i
                    class="far fa-eye"></i></a>
        @endcanany
        @canany([Permission::BRIEFING_DELETE, Permission::BRIEFING_DELETE_OWN])
            <form method="post" class="d-inline" action="{{ route('briefing-delete', ['id' => $briefing]) }}"
                  onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
                @csrf
                <button type="submit" class="btn btn-lg btn-danger"><i class="fas fa-trash-alt"></i></button>
            </form>
        @endcan
    @endsection
@endif
@section('content')

    @php
        if (isset($briefing->uuid)) {
            $formUrl = route('briefing-update', ['id' => $briefing->uuid]);
        } else {
            $formUrl = route('briefing-store');
        }
    @endphp

    <div class="container">
        <form method="post" action="{{ $formUrl }}" enctype="multipart/form-data" class="row g-3 needs-validation">
            @csrf
            <div class="col-12">
                <label for="subject" class="form-label">Тема</label>
                <div class="input-group has-validation">
                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject"
                           name="subject" value="{{ old('subject') ?? $briefing->subject }}">
                    @error('subject')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                @include('_form_upload_image', ['images' => $briefing->images])
            </div>

            <div class="col-12">
                <label for="text" class="form-label">Текст</label>
                <div class="input-group has-validation">
                    <textarea class="form-control @error('text') is-invalid @enderror" id="text"
                              name="text">{{ old('text') ?? $briefing->text }}</textarea>
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
                        <button type="submit" name="stay-here" class="btn btn-outline-primary" value="1"><i
                                class="fas fa-save"></i> Сохранить и продолжить редактирование
                        </button>
                    </div>
                    <div class="col text-end">
                        @if($briefing->uuid)
                            <a class="btn btn-outline-warning"
                               href="{{ route('briefing-show', ['id' => $briefing->uuid]) }}"><i class="fas fa-ban"></i>
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
