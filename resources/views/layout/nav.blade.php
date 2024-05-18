@php use App\Models\User; @endphp
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container">
        {{--<a class="navbar-brand" href="/"><i class="fas fa-home"></i></a>--}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link px-3 @if(Route::is('home')) active text-bg-primary @endif" aria-current="page"
                       href="{{ route('home') }}"><i class="fas fa-list"></i> Лента</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 @if(Route::is('briefing*')) active text-bg-primary @endif"
                       href="{{ route('briefing') }}"><i class="fas fa-chalkboard-teacher"></i> Инструктажи</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 @if(Route::is('material*')) active text-bg-primary @endif"
                       href="{{ route('material') }}"><i class="far fa-newspaper"></i> Материалы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 @if(Route::is('test*')) active text-bg-primary @endif"
                       href="{{ route('test') }}"><i class="fas fa-spell-check"></i> Тесты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 @if(Route::is('task*')) active text-bg-primary @endif"
                       href="{{ route('task') }}"><i class="fas fa-tasks"></i> Задачи</a>
                </li>
                @if(in_array(auth()->user()->role_id, [User::ROLE_ADMIN, User::ROLE_MENTOR]))
                    <li class="nav-item">
                        <a class="nav-link px-3 @if(Route::is('employee*')) active text-bg-primary @endif"
                           href="{{ route('employee') }}"><i class="fas fa-users"></i> Сотрудники</a>
                    </li>
                @endif
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 profile-menu">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle @if(Route::is('user*')) active text-bg-primary @endif" href="#"
                       id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user"></i> {{ auth()->user()?->employee?->lastFirstName ?? auth()->user()?->name }} @if(auth()->user()?->role_id)({{ User::ROLES[auth()->user()?->role_id] }})@endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li class="@if(Route::is('user*')) active @endif">
                            <a class="dropdown-item @if(Route::is('user*')) text-bg-primary @endif"
                               href="{{ route('user-profile') }}"><i class="fas fa-user-circle"></i> Профиль</a>
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
