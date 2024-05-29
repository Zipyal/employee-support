@php
    use App\Models\Permission;
    use App\Models\Test;

    /** @var Test $test */
@endphp
@extends('layout.main')
@section('title')
    {{ $test->uuid ? 'Редактирование' : 'Создание' }} теста
@endsection
@if($test->uuid)
    @section('buttons')
        @canany([Permission::TEST_SEE_ALL, Permission::TEST_SEE_OWN, Permission::TEST_SEE_ASSIGNED])
            <a class="btn btn-outline-dark" href="{{ route('test-show', ['id' => $test->uuid]) }}"><i class="far fa-eye"></i></a>
        @endcanany
        @can(Permission::TEST_DELETE)
            <form method="post" class="d-inline" action="{{ route('test-delete', ['id' => $test]) }}"
                  onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
                @csrf
                <button type="submit" class="btn btn-lg btn-danger"><i class="fas fa-trash-alt"></i></button>
            </form>
        @endcan
    @endsection
@endif
@section('content')

    @php
        if (isset($test->uuid)) {
            $formUrl = route('test-update', ['id' => $test->uuid]);
        } else {
            $formUrl = route('test-store');
        }
    @endphp

    <div class="container">
        <form method="post" action="{{ $formUrl }}" class="row g-3 needs-validation">
            @csrf
            <div class="col-12 col-md-8">
                <label for="subject" class="form-label">Тема</label>
                <div class="input-group has-validation">
                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject"
                           name="subject" value="{{ old('subject') ?? $test->subject }}">
                    @error('subject')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <label for="category" class="form-label">Категория</label>
                <div class="input-group has-validation">
                    <input type="text" class="form-control @error('category') is-invalid @enderror" id="category"
                           name="category" value="{{ old('category')  ?? $test->category }}">
                    @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 mt-5">
                <div class="row">
                    <div class="col text-start">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Сохранить</button>
                    </div>
                    <div class="col text-end">
                        @if($test->uuid)
                            <a class="btn btn-outline-warning" href="{{ route('test-show', ['id' => $test->uuid]) }}"><i
                                    class="fas fa-ban"></i> Отмена</a>
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

    <div class="container mt-5">
        <div class="row mb-4">
            @if($test->questions->isNotEmpty())
                <div class="col-12">
                    <table class="table table-borderless w-100">
                        @foreach($test->questions as $question)
                            <tr>
                                <td class="col-11 pb-5 pt-3">
                                    <div class="mb-2 h5">{{ $loop->index+1 .'. '. $question->text }}</div>
                                    <table class="table table-borderless table-hover w-100">
                                        @php $lastAnswerIndex = -1 @endphp
                                        @if($question->answerVariants->isNotEmpty())
                                            @foreach($question->answerVariants as $variant)
                                                @php $lastAnswerIndex = $loop->index @endphp
                                                <tr>
                                                    <td class="w-100 align-middle">
                                                        <form method="post"
                                                              action="{{ route('test-edit-answer', ['id' => $variant->uuid]) }}">
                                                            @csrf
                                                            <input type="hidden" name="uuid"
                                                                   value="{{ $variant->uuid }}">
                                                            <input type="hidden" name="test_question_uuid"
                                                                   value="{{ $question->uuid }}">
                                                            <div class="input-group">
                                                                <span class="input-group-text"
                                                                      style="width: 2.25rem">{{ Str::upper(\App\Models\TestAnswerVariant::RUS_LETTERS[$lastAnswerIndex]) }}</span>
                                                                <input type="text" name="text" class="form-control"
                                                                       placeholder="Введите вариант ответа"
                                                                       value="{{ $variant->text }}">
                                                                <div class="input-group-text"
                                                                     title="Верный вариант ответа?">
                                                                    <input type="checkbox" name="is_correct"
                                                                           class="form-check-input mt-0" value="1"
                                                                           @if($variant->is_correct) checked @endif>
                                                                </div>
                                                                <div class="d-inline-flex ms-1">
                                                                    <button type="submit" class="btn text-success"><i
                                                                            class="fas fa-lg fa-save"></i></button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </td>
                                                    <td class="col text-end align-middle pt-1">
                                                        <form method="post"
                                                              action="{{ route('test-delete-answer', ['id' => $variant->uuid]) }}"
                                                              onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm text-danger"><i
                                                                    class="far fa-lg fa-trash-alt"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        <tr class="opacity-50">
                                            <td class="w-100 align-middle">
                                                <form method="post" action="{{ route('test-add-answer') }}">
                                                    @csrf
                                                    <input type="hidden" name="test_question_uuid"
                                                           value="{{ $question->uuid }}">
                                                    <div class="input-group">
                                                        <span class="input-group-text"
                                                              style="width: 2.25rem">{{ Str::upper(\App\Models\TestAnswerVariant::RUS_LETTERS[$lastAnswerIndex+1]) }}</span>
                                                        <input type="text" name="text" class="form-control"
                                                               placeholder="Введите вариант ответа" value="">
                                                        <div class="input-group-text">
                                                            <input type="checkbox" name="is_correct"
                                                                   class="form-check-input mt-0" value="1">
                                                        </div>
                                                        <div class="d-inline-flex ms-1">
                                                            <button type="submit" class="btn text-success"><i
                                                                    class="fas fa-lg fa-save"></i></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="col text-end">
                                    <form method="post"
                                          action="{{ route('test-delete-question', ['id' => $question->uuid]) }}"
                                          onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                                class="fas fa-times"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <tr>

                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif

            <div class="col-12 bg-light py-3">
                <form class="row" method="post" action="{{ route('test-add-question') }}">
                    @csrf
                    <input type="hidden" name="test_uuid" value="{{ $test->uuid }}">
                    <div class="col-12">
                        <label for="comment-text">Добавить вопрос:</label>
                        <textarea class="form-control" name="text" id="comment-text"></textarea>
                    </div>
                    <script>
                        const inputs = document.querySelectorAll('form textarea, form input');
                        inputs.forEach(input => {
                            input.addEventListener('keydown', function (e) {
                                if (e.ctrlKey && e.keyCode === 13) {
                                    this.form.submit();
                                }
                            });
                        });
                    </script>
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-sm btn-outline-success">Добавить <i
                                class="fas fa-plus"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
