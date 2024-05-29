@extends('layout.main')
@section('content')
<div class="bg-light">
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3">
                <div class="card border border-light-subtle rounded-3 shadow-sm">
                    <div class="card-body p-3 p-md-4 p-xl-5">
                        <div class="text-center mb-3">
                            <i class="fas fa-4x fa-user-circle"></i>
                        </div>
                        <h2 class="fs-5 fw-normal text-center text-secondary mb-4">Пожалуйста, авторизуйтесь!</h2>
                        <form method="post" action="{{ route('login') }}" novalidate>
                            @csrf
                            <div class="row gy-2 overflow-hidden">
                                <div class="col-12">
                                    <div class="form-floating mb-3 has-validation">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="name@example.com" value="{{ old('email') }}">
                                        <label for="email" class="form-label">Эл. почта</label>
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3 has-validation">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" value="{{ old('password') }}" placeholder="Пароль">
                                        <label for="password" class="form-label">Пароль</label>
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex gap-2 justify-content-between">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="rememberMe" id="rememberMe" @if(old('rememberMe')) checked @endif>
                                            <label class="form-check-label text-secondary" for="rememberMe">Запомнить меня</label>
                                        </div>
                                        {{--<a href="#" class="link-primary text-decoration-none">Забыли пароль?</a>--}}
                                    </div>
                                </div>
                                @error('login')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="col-12">
                                    <div class="d-grid my-3">
                                        <button class="btn btn-primary btn-lg" type="submit">Войти</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
