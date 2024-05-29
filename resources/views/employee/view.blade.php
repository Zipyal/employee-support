@php
    use App\Models\Employee;
    use App\Models\EmploymentContract;
    use App\Models\Permission;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Collection;

    /** @var Employee $employee */
    /** @var EmploymentContract[]|Collection $contracts */
@endphp
@extends('layout.main')
@section('title')
    {{ $employee->last_name . ' ' . $employee->first_name . ' ' . $employee->patronymic }}
@endsection
@section('buttons')
    @can(Permission::EMPLOYEE_EDIT)
        <a class="btn btn-outline-dark" href="{{ route('employee-edit', ['id' => $employee]) }}"><i
            class="fas fa-pencil-alt"></i></a>
    @endcan
    @can(Permission::EMPLOYEE_DELETE)
        <form method="post" class="d-inline" action="{{ route('employee-delete', ['id' => $employee]) }}"
              onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
            @csrf
            <button type="submit" class="btn btn-lg btn-danger"><i class="fas fa-trash-alt"></i></button>
        </form>
    @endcan
@endsection
@section('content')

    <div class="container">
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
                        <th>Учётная запись</th>
                        <td>
                            @if(null === $employee->user_uuid)
                                <span class="badge text-bg-secondary"><i class="fas fa-minus"></i> не создана</span>
                            @elseif(null !== $employee->user?->deleted_at)
                                <span class="badge text-bg-danger"><i
                                        class="fas fa-ban"></i> заблокирована</span> {{ $employee->user?->deleted_at }}
                            @else
                                <span class="badge text-bg-success"><i class="fas fa-check"></i> активна</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Эл. почта</th>
                        <td>{{ $employee->email }}</td>
                    </tr>
                    <tr>
                        <th>Логин</th>
                        <td>{{ $employee->user?->name }}</td>
                    </tr>
                    <tr>
                        <th>Роль</th>
                        <td>{{ $employee->user->roles->pluck('name')->implode(', ') }}</td>
                    </tr>
                </table>
            </div>
        </div>


        <div class="row mt-5">
            <div class="col"><h3>Трудовые договоры сотрудника</h3></div>
            @can(Permission::EMPLOYEE_EDIT)
                <div class="col text-end">
                    <a class="btn btn-outline-success" href="{{ route('employee-add-contract', ['employeeId' => $employee->uuid]) }}"><i class="fas fa-plus"></i></a>
                </div>
            @endcan
        </div>

        @if($employee->contracts->isNotEmpty())
            <table class="table table-hover">
                <tr>
                    <th>Номер договора</th>
                    <th>Дата регистрации</th>
                    <th>Дата окончания</th>
                    <th>Место регистрации</th>
                    <th>Должность</th>
                    <th>Отдел</th>
                    <th>Зарплата, руб.</th>
                    <th>Ставка, час</th>
                    <th></th>
                </tr>
                @foreach($employee->contracts as $contract)
                    <tr>
                        <td>{{ $contract->number }}</td>
                        <td>{{ $contract->register_date }}</td>
                        <td>{{ $contract->end_date }}</td>
                        <td>{{ $contract->register_address }}</td>
                        <td>{{ $contract->position }}</td>
                        <td>{{ $contract->department }}</td>
                        <td>{{ number_format($contract->salary, 2, ',', ' ') }}</td>
                        <td>{{ $contract->rate }}</td>
                        <td class="text-end text-nowrap">
                            @can(Permission::EMPLOYEE_EDIT)
                                <a class="btn btn-sm btn-outline-dark"
                                   href="{{ route('employee-edit-contract', ['employeeId' => $employee->uuid, 'contractId' => $contract->uuid]) }}"><i
                                        class="fas fa-pencil-alt"></i></a>
                                <form method="post" class="d-inline"
                                      action="{{ route('employee-delete-contract', ['contractId' => $contract->uuid]) }}"
                                      onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <div class="text-muted">Данные отсутствуют.</div>
        @endif
    </div>

@endsection
