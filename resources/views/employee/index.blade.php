@php
    use App\Models\User;
    /** @var \App\Models\Employee[]|\Illuminate\Database\Eloquent\Collection $employees  */
@endphp
@extends('layout.main')
@section('title')
    Сотрудники
@endsection
@section('buttons')
    <a class="btn btn-sm btn-outline-success" href="{{ route('employee-add') }}"><i class="fas fa-plus"></i></a>
@endsection
@section('filter')
    <div class="col-12 col-sm-4">
        <label class="text-muted" for="filter-account">Учётная запись: </label>
        <select id="filter-account" class="form-control form-select" name="account" onchange="this.form.submit()">
            <option value="">- не выбрано -</option>
            <option value="{{ User::STATUS_NONE }}" @if(request('account') == User::STATUS_NONE) selected @endif>{{ User::STATUSES[User::STATUS_NONE] }}</option>
            <option value="{{ User::STATUS_BANNED }}" @if(request('account') == User::STATUS_BANNED) selected @endif>{{ User::STATUSES[User::STATUS_BANNED] }}</option>
            <option value="{{ User::STATUS_ACTIVE }}" @if(request('account') == User::STATUS_ACTIVE) selected @endif>{{ User::STATUSES[User::STATUS_ACTIVE] }}</option>
        </select>
    </div>
    <div class="col-12 col-sm-4">
        <label class="text-muted" for="filter-role">Роль: </label>
        <select id="filter-role" class="form-control form-select" name="role" onchange="this.form.submit()">
            <option value="">- не выбрано -</option>
            @foreach(User::ROLES as $roleId => $roleName)
                <option value="{{ $roleId }}" {{ request('role') != $roleId ?: 'selected' }}>{{ $roleName }}</option>
            @endforeach
        </select>
    </div>
@endsection
@section('content')

    @if($employees->isNotEmpty())
        <div class="container-fluid">
            <table class="table table-hover mt-5">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ФИО</th>
                    <th scope="col">Телефон</th>
                    <th scope="col">Эл. почта</th>
                    <th scope="col">Дата рождения</th>
                    <th scope="col">Образование</th>
                    <th scope="col">Доп. образование</th>
                    <th scope="col">Опыт работы</th>
                    <th scope="col">Должность</th>
                    <th scope="col">Отдел</th>
                    <th scope="col">Уч. запись</th>
                    <th scope="col">Роль</th>
                    <th scope="col" class="text-end">Действия</th>
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
                        <td>{{ $employee->education }}</td>
                        <td>{{ $employee->add_education }}</td>
                        <td>{{ $employee->experience }}</td>
                        <td>{{ $employee->lastContract()?->position }}</td>
                        <td>{{ $employee->lastContract()?->department }}</td>
                        <td>
                            @if(null === $employee->user_id)
                                <i class="fas fa-minus text-dark" title="Отсутствует"></i>
                            @elseif(null !== $employee->user?->deleted_at)
                                <i class="fas fa-ban text-danger" title="Заблокировано {{ $employee->user?->deleted_at }}"></i>
                            @else
                                <i class="fas fa-check text-success" title="{{ $employee->user?->name }}"></i>
                            @endif
                        </td>
                        <td>@if($employee->user_id) {{ User::ROLES[$employee->user?->role_id] ?? null }} @endif</td>
                        <td class="text-end text-nowrap">
                            <a class="btn btn-sm btn-outline-dark"
                               href="{{ route('employee-show', ['id' => $employee]) }}"><i class="far fa-eye"></i></a>
                            <a class="btn btn-sm btn-outline-dark"
                               href="{{ route('employee-edit', ['id' => $employee]) }}"><i
                                    class="fas fa-pencil-alt"></i></a>
                            <form method="post" class="d-inline"
                                  action="{{ route('employee-delete', ['id' => $employee]) }}"
                                  onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="container">
            <div class="text-muted">Данные отсутствуют.</div>
        </div>
    @endif

@endsection
