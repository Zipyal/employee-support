@php
    use App\Models\Employee;
    use App\Models\User;

    /** @var Employee $employee */
@endphp
@extends('layout.main')
@section('title')
    Профиль
@endsection
@section('content')

    <div class="container">
        @if(null !== $employee)
            <div class="row">
                <div class="col-12 col-sm-4">
                    <img src="{{ asset($employee->image_filepath ?? '/img/no_avatar.png') }}"
                         class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-12 col-sm-8">
                    <table class="table table-hover">
                        <tr>
                            <th>ФИО</th>
                            <td>{{ $employee->last_name . ' ' . $employee->first_name . ' ' . $employee->patronymic }}</td>
                        </tr>
                        <tr>
                            <th>Пол</th>
                            <td>{{ Employee::GENDERS_FULL[$employee->gender] ?? $employee->gender }}</td>
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
                            <td>{{ $employee->user->roles->pluck('name')->implode(', ') }}</td>
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
                </div>
            </div>
        @else
            <div class="text-muted">Ваш профиль пока не заполнен.<br> Обратитесь к администратору.</div>
        @endif
    </div>

@endsection
