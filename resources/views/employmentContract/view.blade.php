@extends('layout.main')
@section('title'){{ $employee->last_name . ' ' . $employee->first_name . ' ' . $employee->patronymic }}@endsection
@section('buttons')
    <a class="btn btn-outline-dark" href="{{ route('employee-edit', ['id' => $employee]) }}"><i class="fas fa-pencil-alt"></i></a>
    <form method="post" class="d-inline" action="{{ route('employee-delete', ['id' => $employee]) }}"
          onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
        @csrf
        <button type="submit" class="btn btn-lg btn-danger"><i class="fas fa-trash-alt"></i></button>
    </form>
@endsection
@section('content')

    @php
        /** @var $employee \App\Models\Employee */
    @endphp

    <div class="container">
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
    </div>

@endsection
