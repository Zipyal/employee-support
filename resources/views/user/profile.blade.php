@php
    use App\Models\User;
@endphp
@extends('layout.main')
@section('title')
    Профиль
@endsection
@section('content')

    <div class="container">
        @if(null !== $employee)
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
                <tr>
                    <th>Дата рождения</th>
                    <td>{{ $employee->birth_date }}</td>
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
                <tr>
                    <th>Роль</th>
                    <td>{{ User::ROLES[$employee->user->role_id] ?? null }}</td>
                </tr>
                <tr>
                    <th>Должность</th>
                    <td>{{ $employee->lastContract()?->position }}</td>
                </tr>
                <tr>
                    <th>Отдел</th>
                    <td>{{ $employee->lastContract()?->department }}</td>
                </tr>
            </table>
        @else
            <div class="text-muted">Ваш профиль пока не заполнен.<br> Обратитесь к администратору.</div>
        @endif
    </div>

@endsection
