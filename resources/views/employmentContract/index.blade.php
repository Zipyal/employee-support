@extends('layout.main')
@section('title')Сотрудники@endsection
@section('buttons')
    <a class="btn btn-sm btn-outline-success" href="{{ route('employee-add') }}"><i class="fas fa-plus"></i></a>
@endsection
@section('filter')
    <div class="container">
        <div class="row">
            <form method="get" action="{{ url()->current() }}">
                <label class="text-muted" for="filter-role">Роль: </label>
                <select id="filter-role" class="form-control form-select" name="role" onchange="this.form.submit()">
                    <option value="">- не выбрано -</option>

                    @foreach($roles as $role)
                        <option value="{{ $role }}" {{ request('role') != $role ?: 'selected' }}>{{ $role }}</option>
                    @endforeach

                </select>
            </form>
        </div>
    </div>
@endsection
@section('content')

    @php
        /** @var $employee \App\Models\Employee[]|\Illuminate\Database\Eloquent\Collection */
    @endphp

    <table class="table table-hover mt-5">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">ФИО</th>
            <th scope="col">Телефон</th>
            <th scope="col">Эл. почта</th>
            <th scope="col">Дата рождения</th>
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
        @foreach($employees as $employee)
            <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>{{ $employee->last_name . ' ' . $employee->first_name . ' ' . $employee->patronymic }}</td>
                <td>{{ $employee->phone }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->birth_date }}</td>
                <td>{{ $employee->role }}</td>
                <td>{{ $employee->position }}</td>
                <td>{{ $employee->department }}</td>
                <td>{{ $employee->education }}</td>
                <td>{{ $employee->add_education }}</td>
                <td>{{ $employee->experience }}</td>
                <td>
                    <a class="btn btn-sm btn-outline-dark" href="{{ route('employee-show', ['id' => $employee]) }}"><i class="far fa-eye"></i></a>
                    <a class="btn btn-sm btn-outline-dark" href="{{ route('employee-edit', ['id' => $employee]) }}"><i class="fas fa-pencil-alt"></i></a>
                    <form method="post" class="d-inline" action="{{ route('employee-delete', ['id' => $employee]) }}" onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
