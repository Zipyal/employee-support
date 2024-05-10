@extends('layout.main')
@section('content')

    @php
        /** @var $task \App\Models\Task */
    @endphp

    <div class="row">
        <div class="col">
            <h1>{{ $task->subject }}</h1>
        </div>
        <div class="col text-end">
            <a class="btn btn-sm btn-outline-dark" href="{{ route('task-edit', ['id' => $task]) }}">✎</a>
            <form method="post" class="d-inline" action="{{ route('task-delete', ['id' => $task]) }}"
                  onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">@csrf <input
                    type="submit" class="btn btn-sm btn-danger" value="🗑"></form>
        </div>
    </div>



    <table class="table table-hover">
        <tr>
            <th>Объект</th>
            <td>{{ $task->subject }}</td>
        </tr>
        <tr>
            <th>Категория</th>
            <td>{{ $task->category }}</td>
        </tr>
        <tr>
            <th>Текст</th>
            <td>{{ $task->text }}</td>
        </tr>
    </table>

@endsection
