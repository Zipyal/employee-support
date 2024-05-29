@php
    use App\Models\Permission;
    use App\Models\Task;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Collection;

    /** @var $tasks Task[]|Collection */
@endphp
@extends('layout.main', ['filterContainerClass' => 'container-fluid'])
@section('title')
    Задачи
@endsection
@section('buttons')
    @can(Permission::TASK_ADD)
        <a class="btn btn-sm btn-outline-success" href="{{ route('task-add') }}"><i class="fas fa-plus"></i></a>
    @endif
@endsection
@section('filter')
    <div class="col-12 col-sm-3">
        <label class="text-muted" for="filter-subject">Тема: </label>
        <input id="filter-subject" class="form-control" name="subject" type="text" onchange="this.form.submit()"
               value="{{ request('subject') }}">
    </div>
    <div class="col-12 col-sm-2">
        <label class="text-muted" for="filter-status">Статус: </label>
        <select id="filter-status" class="form-control form-select" name="status" onchange="this.form.submit()">
            <option value="">- не выбрано -</option>
            @foreach($statuses as $status)
                <option value="{{ $status }}" {{ request('status') != $status ?: 'selected' }}>{{ $status }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-sm-2">
        <label class="text-muted" for="filter-type">Тип: </label>
        <select id="filter-type" class="form-control form-select" name="type" onchange="this.form.submit()">
            <option value="">- не выбрано -</option>
            @foreach($types as $type)
                <option value="{{ $type }}" {{ request('type') != $type ?: 'selected' }}>{{ $type }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-sm-3">
        <label class="text-muted" for="filter-employee">Назначена: </label>
        <select id="filter-employee" class="form-control form-select" name="employee" onchange="this.form.submit()">
            <option value="">- не выбрано -</option>
            @foreach($employees as $uuid => $name)
                <option value="{{ $uuid }}" {{ request('employee') != $uuid ?: 'selected' }}>{{ $name }}</option>
            @endforeach
        </select>
    </div>
@endsection
@section('content')

    @if($tasks->isNotEmpty())
        <table class="table table-hover mt-5">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Тема</th>
                <th scope="col">Статус</th>
                <th scope="col">Тип</th>
                <th scope="col">Приоритет</th>
                <th scope="col">Дата начала</th>
                <th scope="col">Дата окончания</th>
                <th scope="col">Назначена</th>
                {{--<th scope="col">Описание</th>--}}
                <th scope="col">Добавлено</th>
                <th scope="col">Обновлено</th>
                <th scope="col">Автор</th>
                <th scope="col" class="text-end">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->subject }}</td>
                    <td>{{ $task->status }}</td>
                    <td>{{ $task->type }}</td>
                    <td>{{ $task->priority }}</td>
                    <td>{{ $task->start_date }}</td>
                    <td>{{ $task->end_date }}</td>
                    <td>{{ $task->employee?->fullName }}</td>
                    <td>{{ $task->created_at }}</td>
                    <td>{{ $task->updated_at }}</td>
                    <td>{{ $task->author?->employee?->lastFirstName ?? $task->author?->name }}</td>
                    <td class="text-end text-nowrap">
                        @canany([Permission::TASK_SEE_ALL, Permission::TASK_SEE_OWN, Permission::TASK_SEE_ASSIGNED])
                            <a class="btn btn-sm btn-outline-dark" href="{{ route('task-show', ['id' => $task]) }}"><i
                                class="far fa-eye"></i></a>
                        @endcanany
                        @canany([Permission::TASK_EDIT, Permission::TASK_EDIT_OWN])
                            <a class="btn btn-sm btn-outline-dark" href="{{ route('task-edit', ['id' => $task]) }}"><i
                                class="fas fa-pencil-alt"></i></a>
                        @endcanany
                        @can(Permission::TASK_DELETE)
                            <form method="post" class="d-inline" action="{{ route('task-delete', ['id' => $task]) }}"
                                  onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="container">
            <div class="text-muted">Задачи не найдены.</div>
        </div>
    @endif
@endsection
