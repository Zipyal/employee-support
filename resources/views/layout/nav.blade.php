@php
    use App\Models\Permission;
    use App\Models\Role;
    use App\Models\User;

    /** @var User $currentUser */
    $currentUser = auth()->user();
@endphp
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container">
        {{--<a class="navbar-brand" href="/"><i class="fas fa-home"></i></a>--}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                @can(Permission::FEED_SEE)
                    <li class="nav-item">
                        <a class="nav-link px-3 @if(Route::is('home')) active text-bg-primary @endif"
                           aria-current="page"
                           href="{{ route('home') }}"><i class="fas fa-list"></i> Лента</a>
                    </li>
                @endcan
                @canany(Permission::BRIEFING_PERMISSIONS)
                    <li class="nav-item dropdown">
                        @canany([Permission::BRIEFING_SEE_ALL, Permission::BRIEFING_SEE_OWN, Permission::BRIEFING_SEE_PUBLISHED])
                            <a class="nav-link px-3 @if(Route::is('briefing')) active text-bg-primary @elseif(Route::is('briefing*')) bg-light-primary @endif"
                               href="{{ route('briefing') }}" role="button" aria-expanded="false"><i
                                    class="fas fa-chalkboard-teacher"></i> Инструктажи</a>
                        @else
                            <a class="nav-link px-3 @if(Route::is('briefing')) active text-bg-primary @elseif(Route::is('briefing*')) bg-light-primary @endif"
                               href="#" role="button" aria-expanded="false"><i class="fas fa-chalkboard-teacher"></i>
                                Инструктажи</a>
                        @endcanany
                        @canany([Permission::BRIEFING_ADD, Permission::BRIEFING_EDIT, Permission::BRIEFING_DELETE, Permission::BRIEFING_SEE_ALL])
                            <ul class="dropdown-menu">
                                @canany([Permission::BRIEFING_EDIT, Permission::BRIEFING_DELETE, Permission::BRIEFING_SEE_ALL])
                                    <li class="@if(Route::is('briefing-manage')) active @endif">
                                        <a class="dropdown-item @if(Route::is('briefing-manage')) text-bg-primary @endif"
                                           href="{{ route('briefing-manage') }}">Управление инструктажами</a>
                                    </li>
                                @endcanany
                                @can(Permission::BRIEFING_ADD)
                                    <li class="@if(Route::is('briefing-add')) active @endif">
                                        <a class="dropdown-item @if(Route::is('briefing-add')) text-bg-primary @endif"
                                           href="{{ route('briefing-add') }}">Создать инструктаж</a>
                                    </li>
                                @endcan
                            </ul>
                        @endcan
                    </li>
                @endcan
                @canany(Permission::MATERIAL_PERMISSIONS)
                    <li class="nav-item dropdown">
                        @canany([Permission::MATERIAL_SEE_ALL, Permission::MATERIAL_SEE_OWN, Permission::MATERIAL_SEE_PUBLISHED])
                            <a class="nav-link px-3 @if(Route::is('material')) active text-bg-primary @elseif(Route::is('material*')) bg-light-primary @endif"
                               href="{{ route('material') }}" role="button" aria-expanded="false"><i
                                    class="far fa-newspaper"></i> Материалы</a>
                        @endcanany
                        @canany([Permission::MATERIAL_EDIT, Permission::MATERIAL_DELETE, Permission::MATERIAL_SEE_ALL])
                            <ul class="dropdown-menu">
                                @canany([Permission::MATERIAL_EDIT, Permission::MATERIAL_DELETE, Permission::MATERIAL_SEE_ALL])
                                    <li class="@if(Route::is('material-manage')) active @endif">
                                        <a class="dropdown-item @if(Route::is('material-manage')) text-bg-primary @endif"
                                           href="{{ route('material-manage') }}">Управление материалами</a>
                                    </li>
                                @endcanany
                                @can(Permission::MATERIAL_ADD)
                                    <li class="@if(Route::is('material-add')) active @endif">
                                        <a class="dropdown-item @if(Route::is('material-add')) text-bg-primary @endif"
                                           href="{{ route('material-add') }}">Создать материал</a>
                                    </li>
                                @endcan
                            </ul>
                        @endcanany
                    </li>
                @endcanany
                @canany(Permission::TEST_PERMISSIONS)
                    <li class="nav-item dropdown">
                        @canany([Permission::TEST_SEE_ALL, Permission::TEST_SEE_OWN, Permission::TEST_SEE_ASSIGNED])
                            <a class="nav-link px-3 @if(Route::is('test')) active text-bg-primary @elseif(Route::is('test*')) bg-light-primary @endif"
                               href="{{ route('test') }}"><i class="fas fa-spell-check"></i> Тесты</a>
                        @else
                            <a class="nav-link px-3 @if(Route::is('test')) active text-bg-primary @elseif(Route::is('test*')) bg-light-primary @endif"
                               href="#"><i class="fas fa-spell-check"></i> Тесты</a>
                        @endcanany
                        @canany([Permission::TEST_EDIT, Permission::TEST_DELETE])
                            <ul class="dropdown-menu">
                                @canany([Permission::TEST_ADD, Permission::TEST_EDIT, Permission::TEST_DELETE])
                                    <li class="@if(Route::is('test-manage')) active @endif">
                                        <a class="dropdown-item @if(Route::is('test-manage')) text-bg-primary @endif"
                                           href="{{ route('test-manage') }}">Управление тестами</a>
                                    </li>
                                @endcanany
                                @can(Permission::TEST_ADD)
                                    <li class="@if(Route::is('test-add')) active @endif">
                                        <a class="dropdown-item @if(Route::is('test-add')) text-bg-primary @endif"
                                           href="{{ route('test-add') }}">Создать тест</a>
                                    </li>
                                @endcan
                            </ul>
                        @endcanany
                    </li>
                @endcanany
                @canany(Permission::TASK_PERMISSIONS)
                    <li class="nav-item dropdown">
                        @canany([Permission::TASK_SEE_ALL, Permission::TASK_SEE_ASSIGNED, Permission::TASK_SEE_OWN])
                            <a class="nav-link px-3 @if(Route::is('task')) active text-bg-primary @elseif(Route::is('task*')) bg-light-primary @endif"
                               href="{{ route('task') }}"><i class="fas fa-tasks"></i> Задачи</a>
                        @else
                            <a class="nav-link px-3 @if(Route::is('task')) active text-bg-primary @elseif(Route::is('task*')) bg-light-primary @endif"
                               href="#"><i class="fas fa-tasks"></i> Задачи</a>
                        @endcanany
                        @canany([Permission::TASK_ADD, Permission::TASK_EDIT, Permission::TASK_DELETE, Permission::TASK_SEE_ALL])
                            <ul class="dropdown-menu">
                                @canany([Permission::TASK_EDIT, Permission::TASK_DELETE, Permission::TASK_SEE_ALL])
                                    <li class="@if(Route::is('task-manage')) active @endif">
                                        <a class="dropdown-item @if(Route::is('task-manage')) text-bg-primary @endif"
                                           href="{{ route('task-manage') }}">Управление задачами</a>
                                    </li>
                                @endcanany
                                @can(Permission::TASK_ADD)
                                    <li class="@if(Route::is('task-add')) active @endif">
                                        <a class="dropdown-item @if(Route::is('task-add')) text-bg-primary @endif"
                                           href="{{ route('task-add') }}">Создать задачу</a>
                                    </li>
                                @endcan
                            </ul>
                        @endcanany
                    </li>
                @endcanany
                @canany(Permission::EMPLOYEE_PERMISSIONS)
                    <li class="nav-item dropdown">
                        @canany([Permission::EMPLOYEE_SEE_ALL, Permission::EMPLOYEE_SEE_OWN_INTERNS])
                            <a class="nav-link px-3 @if(Route::is('employee')) active text-bg-primary @elseif(Route::is('employee*')) bg-light-primary @endif"
                               href="{{ route('employee') }}"><i class="fas fa-users"></i> Сотрудники</a>
                        @else
                            <a class="nav-link px-3 @if(Route::is('employee')) active text-bg-primary @elseif(Route::is('employee*')) bg-light-primary @endif"
                               href="#"><i class="fas fa-users"></i> Сотрудники</a>
                        @endcanany
                        @canany([Permission::EMPLOYEE_ADD, Permission::EMPLOYEE_EDIT, Permission::EMPLOYEE_DELETE, Permission::EMPLOYEE_SEE_ALL])
                            <ul class="dropdown-menu">
                                @canany([Permission::EMPLOYEE_EDIT, Permission::EMPLOYEE_DELETE, Permission::EMPLOYEE_SEE_ALL])
                                    <li class="@if(Route::is('employee-manage')) active @endif">
                                        <a class="dropdown-item @if(Route::is('employee-manage')) text-bg-primary @endif"
                                           href="{{ route('employee-manage') }}">Управление сотрудниками</a>
                                    </li>
                                @endcanany
                                @can(Permission::EMPLOYEE_ADD)
                                    <li class="@if(Route::is('employee-add')) active @endif">
                                        <a class="dropdown-item @if(Route::is('employee-add')) text-bg-primary @endif"
                                           href="{{ route('employee-add') }}">Добавить сотрудника</a>
                                    </li>
                                @endcan
                            </ul>
                        @endcanany
                    </li>
                @endcanany
                @canany(Permission::ROLE_PERMISSIONS)
                    <li class="nav-item dropdown">
                        @canany([Permission::ROLE_ADD, Permission::ROLE_EDIT, Permission::ROLE_DELETE, Permission::ROLE_SEE_ALL])
                            <a class="nav-link px-3 @if(Route::is('role-manage')) active text-bg-primary @elseif(Route::is('role*')) bg-light-primary @endif"
                               href="{{ route('role-manage') }}"><i class="fas fa-tags"></i> Роли</a>
                        @else
                            <a class="nav-link px-3 @if(Route::is('role-manage')) active text-bg-primary @elseif(Route::is('role*')) bg-light-primary @endif"
                               href="#"><i class="fas fa-tags"></i> Роли</a>
                        @endcanany
                        @can(Permission::ROLE_ADD)
                            <ul class="dropdown-menu">
                                <li class="@if(Route::is('role-add')) active @endif">
                                    <a class="dropdown-item @if(Route::is('role-add')) text-bg-primary @endif"
                                       href="{{ route('role-add') }}">Создать роль</a>
                                </li>
                            </ul>
                        @endcan
                    </li>
                @endcanany
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 profile-menu">
                <li class="nav-item dropdown">
                    <a class="nav-link @if(Route::is('user*')) active bg-light-primary @endif" href="#"
                       id="user-nav-dropdown" role="button" aria-expanded="false">
                        <i class="fas fa-user"></i> {{ $currentUser?->employee?->lastFirstName ?? $currentUser?->name }}
                        @if($currentUser->roles->isNotEmpty())
                            ({{ $currentUser->roles?->pluck('name')->implode(', ') }})
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="user-nav-dropdown">
                        <li class="@if(Route::is('user*')) active @endif">
                            <a class="dropdown-item @if(Route::is('user*')) text-bg-primary @endif"
                               href="{{ route('profile') }}"><i class="fas fa-user-circle"></i> Профиль</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i>
                                Выход</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
