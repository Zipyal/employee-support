@extends('layout.main')
@section('content')

    @php
        /** @var $task \App\Models\Task[]|\Illuminate\Database\Eloquent\Collection */
    @endphp


    <div class="container">
        <div class="row mt-2 mb-5">
            <div class="col">
                <h1>Инструктажи</h1>
            </div>
            <div class="col text-end">
                <a class="btn btn-sm btn-success" href="{{ route('task-add') }}"><strong
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
        @foreach($tasks as $i => $task)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $task->subject . ' ' . $task->first_name . ' ' . $task->patronymic }}</td>
                <td>{{ $task->category }}</td>
                <td>{{ $task->text }}</td>
                <td>
                    <a class="btn btn-sm btn-outline-dark"
                       href="{{ route('task-show', ['id' => $task]) }}">👁</a>
                    <a class="btn btn-sm btn-outline-dark"
                       href="{{ route('task-edit', ['id' => $task]) }}">✎</a>
                    <form method="post" class="d-inline" action="{{ route('task-delete', ['id' => $task]) }}"
                          onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">@csrf <input
                            type="submit" class="btn btn-sm btn-danger" value="🗑"></form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
