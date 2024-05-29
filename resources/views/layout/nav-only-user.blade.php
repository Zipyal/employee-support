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
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                <i class="fas fa-sign-out-alt"></i>Выход
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
