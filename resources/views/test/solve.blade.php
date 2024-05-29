@php
    use App\Models\Permission;
    use App\Models\Test;
    use App\Models\TestAnswerVariant;
    use App\Models\User;
    use Illuminate\Support\Str;

    /** @var Test $test */
@endphp
@extends('layout.main')
@section('title')
    Тест: {{ $test->subject }}
@endsection
@section('content')

    <div class="container noselect">
        <div class="alert alert-primary align-items-center" role="alert">
            <i class="fas fa-info-circle"></i> <span>Выделите нужные варианты ответов и нажмите кнопку отправки внизу.</span>
        </div>

        <div class="alert alert-warning align-items-center" role="alert">
            <i class="fas fa-info-circle"></i> <span>Пока не нажата кнопка отправки можно менять свои ответы сколько угодно раз.</span>
        </div>

        <div class="row my-4">
            @if($test->questions->isNotEmpty())
                <form method="post" action="{{ route('test-solve', ['id' => $test->uuid]) }}">
                    @csrf
                    <input type="hidden" name="test_uuid" value="{{ $test->uuid }}">
                    <div class="col-12">
                        <table class="table table-borderless">
                            @foreach($test->questions as $i => $question)
                                <tr>
                                    <td class="col-11 pb-5 pt-3">
                                        <div class="mb-2 h5">{{ $loop->index+1 .'. '. $question->text }}</div>
                                        @if($question->answerVariants->isNotEmpty())
                                            @foreach($question->answerVariants as $j => $variant)
                                                {{--@php $variantLetter = Str::lower(TestAnswerVariant::RUS_LETTERS[$j]) @endphp--}}
                                                <div class="form-check">
                                                    <input class="form-check-input check-with-label d-none" type="checkbox" value="{{ $variant->uuid }}" name="questions[{{ $question->uuid }}][]" id="question-{{ $i }}-variant-{{ $j }}">
                                                    <label class="form-check-label px-1 hover-bg-light" for="question-{{ $i }}-variant-{{ $j }}"><i class="checkmark fas fa-check text-primary"></i> {{--<span class="text-primary">{{ $variantLetter }})</span>--}} {{ $variant->text }}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-primary">Отправить ответы</button>
                    </div>
                </form>
            @endif
        </div>
    </div>

@endsection
