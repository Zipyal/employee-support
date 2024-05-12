@extends('layout.main')
@section('content')

    @php
        /** @var $test \App\Models\Test[]|\Illuminate\Database\Eloquent\Collection */
    @endphp


    <div class="container">
        <div class="row mt-2 mb-5">
            <div class="col">
                <h1>Тесты</h1>
            </div>
            <div class="col text-end">
                <a class="btn btn-sm btn-success" href="{{ route('test-add') }}"><strong
                        class="fs-1 m-0 lh-1">+</strong></a>
            </div>
        </div>
    </div>

    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Объект</th>
            <th scope="col">Категория</th>
            <th scope="col">Текст</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tests as $i => $test)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $test->subject }}</td>
                <td>{{ $test->category }}</td>
                <td>{{ $test->text }}</td>
                <td>
                    <a class="btn btn-sm btn-outline-dark"
                       href="{{ route('test-show', ['id' => $test]) }}">👁</a>
                    <a class="btn btn-sm btn-outline-dark"
                       href="{{ route('test-edit', ['id' => $test]) }}">✎</a>
                    <form method="post" class="d-inline" action="{{ route('test-delete', ['id' => $test]) }}"
                          onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">@csrf <input
                            type="submit" class="btn btn-sm btn-danger" value="🗑"></form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
