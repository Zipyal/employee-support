@extends('layout.main')

@section('title', '404')
@section('subtitle', __('Страница не найдена'))

@section('content')
    <div class="container">
        <p>Попробуйте начать с <a href="{{ route('home') }}">главной страницы</a></p>
    </div>
@endsection
