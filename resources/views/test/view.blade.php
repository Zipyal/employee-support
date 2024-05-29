@php
    use App\Models\Permission;
    use App\Models\Test;
    use App\Models\User;

    /** @var Test $test */
@endphp
@extends('layout.main')
@section('title')
    Тест: {{ $test->subject }}
@endsection
@section('buttons')
    @can(Permission::TEST_EDIT)
        <a class="btn btn-outline-dark" href="{{ route('test-edit', ['id' => $test]) }}"><i
                class="fas fa-pencil-alt"></i></a>
    @endcan
    @can(Permission::TEST_DELETE)
        <form method="post" class="d-inline" action="{{ route('test-delete', ['id' => $test]) }}"
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
                <div>{{ $test->created_at }}</div>
            </div>

            <div class="col-12 col-md-3 mb-2">
                <div class="text-muted fw-light">Обновлено:</div>
                <div>@if($test->created_at != $test->updated_at)
                        {{ $test->updated_at }}
                    @endif</div>
            </div>

            <div class="col-12 col-md-3 mb-2">
                <div class="text-muted fw-light">Автор:</div>
                <div>{{ $test->author?->employee?->lastFirstName ?? $test->author?->name }}</div>
            </div>

            <div class="col-12 col-md-3 mb-2">
                <div class="text-muted fw-light">Категория</div>
                <div>{{ $test->category }}</div>
            </div>

            @if(!isset($result['is_closed']))
                <div class="col-12 mb-2">
                    <a class="btn btn-outline-success" href="{{ route('test-solve', ['id' => $test]) }}"><i class="fas fa-graduation-cap"></i> Пройти тест</a>
                </div>
            @endif
        </div>



        <div class="row my-4">
            @if($test->questions->isNotEmpty())
                <div class="col-12">
                    <table class="table table-borderless">
                        @foreach($test->questions as $question)
                            <tr>
                                <td class="col-11 pb-5 pt-3">
                                    <div class="mb-2 h5">{{ $loop->index+1 .'. '. $question->text }}</div>
                                    @php $lastAnswerIndex = -1 @endphp
                                    @if($question->answerVariants->isNotEmpty())
                                        @foreach($question->answerVariants as $variant)
                                            @php
                                                $isChosen = isset($result->answers[$question->uuid]['answers'][$variant->uuid]);
                                                $lastAnswerIndex = $loop->index
                                            @endphp
                                            <div class="align-middle ms-5 px-2 my-1 position-relative @if($isChosen) bg-light-primary @endif">
                                                <i class="checkmark @if($isChosen) fas fa-check text-primary @endif"></i> {{ $variant->text }}
                                            </div>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
        </div>
    </div>

@endsection
