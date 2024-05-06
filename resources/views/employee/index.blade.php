@extends('layout.main')
@section('content')

    @php
        /** @var $employees \App\Models\Employee[]|\Illuminate\Database\Eloquent\Collection */
    @endphp

    <div class="row">
        <div class="col">
            <h1>Наставники</h1>
        </div>
        <div class="col text-end">
            <a class="btn btn-sm btn-success" href="{{ route('employee-add') }}"><strong class="fs-1 m-0 lh-1">+</strong></a>
        </div>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">ФИО</th>
            <th scope="col">Телефон</th>
            <th scope="col">Эл. почта</th>
            <th scope="col">Роль</th>
            <th scope="col">Должность</th>
            <th scope="col">Отдел</th>
            <th scope="col">Образование</th>
            <th scope="col">Доп. образование</th>
            <th scope="col">Опыт работы</th>
            <th scope="col">Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($employees as $i => $employee)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $employee->last_name . ' ' . $employee->first_name . ' ' . $employee->patronymic }}</td>
                <td>{{ $employee->phone }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->role }}</td>
                <td>{{ $employee->position }}</td>
                <td>{{ $employee->department }}</td>
                <td>{{ $employee->education }}</td>
                <td>{{ $employee->add_education }}</td>
                <td>{{ $employee->experience }}</td>
                <td>
                    <a class="btn btn-sm btn-outline-dark" href="{{ route('employee-show', ['id' => $employee]) }}">👁</a>
                    <a class="btn btn-sm btn-outline-dark" href="{{ route('employee-edit', ['id' => $employee]) }}">✎</a>
                    <form method="post" class="d-inline" action="{{ route('employee-delete', ['id' => $employee]) }}"
                          onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">@csrf <input
                            type="submit" class="btn btn-sm btn-danger" value="🗑"></form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
