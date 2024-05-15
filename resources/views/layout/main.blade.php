<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Support</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('libs/fontawesome/js/all.min.js') }}" defer></script>
</head>
<body>
    @if(Auth::guest() !== true)
        @include('layout.nav')
    @endif

@hasSection('title')
    <div class="container">
        <div class="row my-3">
            <div class="col">
                @hasSection('title')
                    <h1>@yield('title')</h1>
                @endif
                @hasSection('subtitle')
                    <h2>@yield('subtitle')</h2>
                @endif
            </div>
            @hasSection('buttons')
                <div class="col text-end btn-group-lg">
                    @yield('buttons')
                </div>
            @endif
        </div>
    </div>
@endif

@hasSection('filter')
    <div class="container p-3 mb-3 bg-light">
        <form method="get" action="{{ url()->current() }}" class="row">
            @yield('filter')
            <div class="col mt-auto text-end">
                <a class="btn btn-sm btn-outline-dark d-inline-block position-relative py-2 px-4" href="{{ url()->current() }}" title="Сбросить фильтр">
                    <span class="fa-stack fa-stack-2x small">
                        <i class="fas fa-filter fa-stack-1x" style="scale: 0.8;"></i><i class="fas fa-times fa-stack-1x text-danger" style="scale: 1.2; padding-left:14px;padding-top:14px;"></i>
                    </span>&nbsp;
                </a>
            </div>
        </form>
    </div>
@endif

@hasSection('content')
    <div class="container-fluid">
        @yield('content')
    </div>
@endif
</body>
</html>
