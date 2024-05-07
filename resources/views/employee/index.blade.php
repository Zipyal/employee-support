@extends('layout.main')
@section('content')

    @php
        /** @var $employee \App\Models\Employee[]|\Illuminate\Database\Eloquent\Collection */
    @endphp


        <div class="container">
            <div class="row mt-2 mb-5">
                <div class="col">
                    <h1>Сотрудники</h1>
                </div>
                <div class="col text-end">
                    <a class="btn btn-sm btn-success" href="{{ route('employee-add') }}"><strong class="fs-1 m-0 lh-1">+</strong></a>
                </div>
            </div>

            <div class="p-3 mb-3 bg-light row">
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
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
        </div>

    <table class="table table-hover">
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
        @foreach($employees as $i => $employee)
            <tr>
                <td>{{ $i+1 }}</td>
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
