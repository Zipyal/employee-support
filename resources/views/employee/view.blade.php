@extends('layout.main')
@section('content')

    @php
        /** @var $mentor \App\Models\Mentor */
    @endphp

    <div class="row">
        <div class="col">
            <h1>{{ $mentor->last_name . ' ' . $mentor->first_name . ' ' . $mentor->patronymic }}</h1>
        </div>
        <div class="col text-end">
            <a class="btn btn-sm btn-outline-dark" href="{{ route('mentor-edit', ['id' => $mentor]) }}">✎</a>
            <form method="post" class="d-inline" action="{{ route('mentor-delete', ['id' => $mentor]) }}"
                  onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">@csrf <input
                    type="submit" class="btn btn-sm btn-danger" value="🗑"></form>
        </div>
    </div>

    <table class="table table-hover">
        <tr>
            <th>ФИО</th>
            <td>{{ $mentor->last_name . ' ' . $mentor->first_name . ' ' . $mentor->patronymic }}</td>
        </tr>
        <tr>
            <th>Телефон</th>
            <td>{{ $mentor->phone }}</td>
        </tr>
        <tr>
            <th>Эл. почта</th>
            <td>{{ $mentor->email }}</td>
        </tr>
        <tr>
            <th>Роль</th>
            <td>{{ $mentor->role }}</td>
        </tr>
        <tr>
            <th>Должность</th>
            <td>{{ $mentor->position }}</td>
        </tr>
        <tr>
            <th>Отдел</th>
            <td>{{ $mentor->department }}</td>
        </tr>
        <tr>
            <th>Образование</th>
            <td>{{ $mentor->education }}</td>
        </tr>
        <tr>
            <th>Доп. образование</th>
            <td>{{ $mentor->add_education }}</td>
        </tr>
        <tr>
            <th>Опыт работы</th>
            <td>{{ $mentor->experience }}</td>
        </tr>
    </table>

@endsection
