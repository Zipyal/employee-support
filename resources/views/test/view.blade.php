@extends('layout.main')
@section('content')

    @php
        /** @var $test \App\Models\Test */
    @endphp

    <div class="row">
        <div class="col">
            <h1>{{ $test->subject }}</h1>
        </div>
        <div class="col text-end">
            <a class="btn btn-sm btn-outline-dark" href="{{ route('test-edit', ['id' => $test]) }}">✎</a>
            <form method="post" class="d-inline" action="{{ route('test-delete', ['id' => $test]) }}"
                  onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">@csrf <input
                    type="submit" class="btn btn-sm btn-danger" value="🗑"></form>
        </div>
    </div>



    <table class="table table-hover">
        <tr>
            <th>Объект</th>
            <td>{{ $test->subject }}</td>
        </tr>
        <tr>
            <th>Категория</th>
            <td>{{ $test->category }}</td>
        </tr>
        <tr>
            <th>Текст</th>
            <td>{{ $test->text }}</td>
        </tr>
    </table>

@endsection
