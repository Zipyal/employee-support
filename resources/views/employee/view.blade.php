@extends('layout.main')
@section('content')

    @php
        /** @var $employee \App\Models\Employee */
    @endphp

    <div class="row">
        <div class="col">
            <h1>{{ $employee->last_name . ' ' . $employee->first_name . ' ' . $employee->patronymic }}</h1>
        </div>
        <div class="col text-end">
            <a class="btn btn-sm btn-outline-dark" href="{{ route('employee-edit', ['id' => $employee]) }}">✎</a>
            <form method="post" class="d-inline" action="{{ route('employee-delete', ['id' => $employee]) }}"
                  onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">@csrf <input
                    type="submit" class="btn btn-sm btn-danger" value="🗑"></form>
        </div>
    </div>



    <table class="table table-hover">
        <tr>
            <th>ФИО</th>
            <td>{{ $employee->last_name . ' ' . $employee->first_name . ' ' . $employee->patronymic }}</td>
        </tr>
        <tr>
            <th>Телефон</th>
            <td>{{ $employee->phone }}</td>
        </tr>
        <tr>
            <th>Эл. почта</th>
            <td>{{ $employee->email }}</td>
        </tr>
            <th>Эл. почта</th>
            <td>{{ $employee->birth_date }}</td>
        </tr>
        <tr>
            <th>Роль</th>
            <td>{{ $employee->role }}</td>
        </tr>
        <tr>
            <th>Должность</th>
            <td>{{ $employee->position }}</td>
        </tr>
        <tr>
            <th>Отдел</th>
            <td>{{ $employee->department }}</td>
        </tr>
        <tr>
            <th>Образование</th>
            <td>{{ $employee->education }}</td>
        </tr>
        <tr>
            <th>Доп. образование</th>
            <td>{{ $employee->add_education }}</td>
        </tr>
        <tr>
            <th>Опыт работы</th>
            <td>{{ $employee->experience }}</td>
        </tr>
    </table>

@endsection
