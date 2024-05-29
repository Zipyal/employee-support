@php
    use App\Models\Role;
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Support</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/bootstrap-toggle/bootstrap5-toggle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('libs/fontawesome/js/all.min.js') }}" defer></script>
    <script src="{{ asset('libs/bootstrap-toggle/bootstrap5-toggle.ecmas.min.js') }}" defer></script>
</head>
<body>
@if(
    !auth()->guest()
    && (
        auth()->user()->hasRole(Role::ROLE_ADMIN)
        || auth()->user()->employee?->isAllPublishedBriefingsRead()
    )
)
    @include('layout.nav')
@elseif(!auth()->guest())
    @include('layout.nav-only-user')
@endif

{{--@hasSection('errors')
    @yield('errors')
@else
    @if($errors->any())
        @dump($errors)
        <div class="container my-4">
            {!! implode('', $errors->all(
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> :message
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'
            )) !!}
        </div>
    @endif
@endif--}}

@if(session()->hasAny(['error', 'warning', 'success', 'info']))
    <div class="container my-4">
        <div class="row">
            <div class="col-12 col-lg-6 offset-lg-3">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {!! session('error') !!}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {!! session('warning') !!}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {!! session('success') !!}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        {!! session('info') !!}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif

@hasSection('title')
    <div class="container">
        <div class="row my-3">
            <div class="col-8 col-md-10">
                @hasSection('title')
                    <h1>@yield('title')</h1>
                @endif
                @hasSection('subtitle')
                    <h2>@yield('subtitle')</h2>
                @endif
            </div>
            @hasSection('buttons')
                <div class="col-4 col-md-2 text-end btn-group-lg text-nowrap">
                    @yield('buttons')
                </div>
            @endif
        </div>
    </div>
@endif

@hasSection('filter')
    <div class="{{ $filterContainerClass ?? 'container' }} mb-5">
        <form method="get" action="{{ url()->current() }}" class="row p-3 bg-light">
            @yield('filter')
            <div class="col mt-auto text-end">
                <a class="btn btn-sm btn-outline-dark d-inline-block position-relative py-2 px-4"
                   href="{{ url()->current() }}" title="Сбросить фильтр">
                    <span class="fa-stack fa-stack-2x small">
                        <i class="fas fa-filter fa-stack-1x" style="scale: 0.8;"></i><i
                            class="fas fa-times fa-stack-1x text-danger"
                            style="scale: 1.2; padding-left:14px;padding-top:14px;"></i>
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

{{--<footer class="py-3 my-4">--}}
{{--    <p class="text-center text-muted">© 2022 Company, Inc</p>--}}
{{--</footer>--}}


<footer class="mt-5">
    <div class="container border-top pt-3 pb-5">
        <div class="text-center">
            <span
                class="mb-3 mb-md-0 text-muted">© {{ Config::get('app.name') }}, 2024{{ date('Y') != '2024' ? '–' . date('Y') : '' }}</span>
        </div>
    </div>
</footer>

</body>
</html>
