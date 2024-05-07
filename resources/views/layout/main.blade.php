<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
{{--            <a class="navbar-brand" href="#">Navbar</a>--}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Лента</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Инструктажы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Материалы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Тестирования</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Задания
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Список</a></li>
                            <li><a class="dropdown-item" href="#">Добавить</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Сотрудники</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('employee') }}">Сотрудники</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<div class="container">
    @yield('content')
</div>
</body>
</html>
