@php
    use App\Models\Test;
    use App\Models\User;
    use App\Models\TestResult;
    use Illuminate\Database\Eloquent\Collection;

    /** @var Test[]|Collection $tests */
    /** @var User $currentUser */
    $currentUser = auth()->user();
@endphp
@extends('layout.main')
@section('title')
    Тесты
@endsection
@section('content')
    <div class="container">
        @if($tests->isNotEmpty())
            <div class="row">
                <div class="col-12 col-md mb-5">
                    {{--<h3 class="mb-5">Материалы</h3>--}}
                    @foreach($tests as $item)
                        <div class="card shadow-sm mb-5 @if($item->isSolvedByUser()) text-bg-light-success @endif">
                            <div class="card-body">
                                {{--<div class="text-muted opacity-50">Материал</div>--}}
                                <div class="card-title h5">{{ $item->subject }}</div>
                                <div class="card-subtitle text-muted"><i
                                        class="far fa-clock"></i> {{ $item->updated_at?->format('d.m.Y - H:i') }}</div>
                                <div class="mt-3 card-text">
                                    <div class="row">
                                        <div class="col-6">
                                            <table class="table table-sm">
                                                <tr>
                                                    <td class="col-3 text-end opacity-50">Категория:</td>
                                                    <td class="col-9">{{ $item->category }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-end opacity-50">Вопросов:</td>
                                                    <td>{{ $item->questions->count() }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col">
                                        @if($item->isSolvedByUser())
                                            <span class="text-success">Тест уже пройден <i class="fas fa-check"></i></span>
                                            @if($item->resultByUser()?->score)
                                                @php $score = round($item->resultByUser()?->score) @endphp
                                                <span class="ms-2 @if($score/TestResult::MAX_SCORE < 0.5) text-danger @elseif($score/TestResult::MAX_SCORE < 0.7) text-warning @else text-success @endif">{{ $score . '/' . TestResult::MAX_SCORE  }} бал.</span>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="col text-end">
                                        @if(!$item->isSolvedByUser())
                                            <a class="btn btn-sm btn-outline-success"
                                               href="{{ route('test-solve', ['id' => $item]) }}"><i
                                                    class="fas fa-graduation-cap"></i> Пройти тест</a>
                                        @endif
                                        <a class="btn btn-sm btn-outline-primary ms-3"
                                           href="{{ route('test-show', ['id' => $item]) }}">Подробнее →</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-muted">Нет назначенных вам (через задачи) тестов.</div>
        @endif
    </div>
@endsection
