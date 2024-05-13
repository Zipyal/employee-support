@php
    /** @var \App\Models\Test $test */
@endphp
@extends('layout.main')
@section('title')Тест: {{ $test->subject }}@endsection
@section('buttons')
    <a class="btn btn-outline-dark" href="{{ route('test-edit', ['id' => $test]) }}"><i class="fas fa-pencil-alt"></i></a>
    <form method="post" class="d-inline" action="{{ route('test-delete', ['id' => $test]) }}"
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
                <div>{{ $test->created_at }}</div>
            </div>

            <div class="col-12 col-md-3 mb-2">
                <div class="text-muted fw-light">Обновлено: </div>
                <div>@if($test->created_at != $test->updated_at) {{ $test->updated_at }} @endif</div>
            </div>

            <div class="col-12 col-md-3 mb-2">
                <div class="text-muted fw-light">Автор: </div>
                <div>{{ $test->author?->fullName }}</div>
            </div>

            <div class="col-12 col-md-3 mb-2">
                <div class="text-muted fw-light">Категория</div>
                <div>{{ $test->category }}</div>
            </div>
        </div>

        <div class="row mb-4">
            @if($test->questions->isNotEmpty())
                <div class="col-12">
                    <table class="table table-borderless">
                    @foreach($test->questions as $question)
                        <tr>
                            <td class="col-11 pb-5 pt-3">
                                <div class="mb-2 h5">{{ $loop->index+1 .'. '. $question->text }}</div>
                                <table class="table table-borderless">
                                    @php $lastAnswerIndex = -1 @endphp
                                    @if($question->answerVariants->isNotEmpty())
                                        @foreach($question->answerVariants as $variant)
                                            @php $lastAnswerIndex = $loop->index @endphp
                                            <tr>
                                                <td class="align-middle p-1 m-0">
                                                    <div class="px-1" style="@if($variant->is_correct) background: rgba(0,197,43,0.34); @endif">
                                                        <span class="d-inline-block" style="width: 1.25em">{{ Str::upper(\App\Models\TestAnswerVariant::RUS_LETTERS[$lastAnswerIndex]) }})</span>
                                                        <span class="">{{ $variant->text }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </td>
                        </tr>
                        <tr>

                        </tr>
                    @endforeach
                    </table>
                </div>
            @endif
        </div>
    </div>

@endsection
