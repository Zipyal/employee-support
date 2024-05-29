@php
    use App\Models\Permission;
    use App\Models\Role;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Collection;

    /** @var Role[]|Collection $roles  */
@endphp
@extends('layout.main', ['filterContainerClass' => 'container-fluid'])
@section('title')
    Роли
@endsection
@section('buttons')
    <a class="btn btn-sm btn-outline-success" href="{{ route('role-add') }}"><i class="fas fa-plus"></i></a>
@endsection
@section('content')

    <div class="container">
        @if($roles->isNotEmpty())
            <table class="table table-hover mt-5">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Название</th>
                    <th scope="col">Разрешения</th>
                    <th scope="col">Создано</th>
                    <th scope="col">Изменено</th>
                    <th scope="col" class="text-end">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            @if($role->permissions->isNotEmpty())
                                <ul class="list-unstyled">
                                    @foreach(Permission::PERMISSIONS_GROUPED as $groupName => $groupPermissions)
                                        @php
                                            $permissionsFromGroup = array_intersect($groupPermissions, $role->permissions?->pluck('name')->toArray() ?? []);
                                        @endphp
                                        @if(count($permissionsFromGroup))
                                            <li><span class="fw-semibold">{{ $groupName }}</span>
                                                <ul class="mb-2">
                                                    @foreach($permissionsFromGroup as $permission)
                                                        <li>{{ $permission }}</li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-danger">нет</span>
                            @endif
                        </td>
                        <td>{{ $role->created_at }}</td>
                        <td>{{ $role->updated_at }}</td>
                        <td class="text-end text-nowrap">
                            <a class="btn btn-sm btn-outline-dark"
                               href="{{ route('role-edit', ['id' => $role]) }}"><i
                                    class="fas fa-pencil-alt"></i></a>
                            <form method="post" class="d-inline"
                                  action="{{ route('role-delete', ['id' => $role]) }}"
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
        @else
            <div class="text-muted">Данные отсутствуют.</div>
        @endif
    </div>

@endsection
