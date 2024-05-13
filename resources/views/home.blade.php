@php
    /** @var \App\Models\Material[]|\Illuminate\Database\Eloquent\Collection $materials */
@endphp
@extends('layout.main')
@section('title')Лента@endsection
@section('content')
    <div class="container">
    @if($materials->isNotEmpty())
        <div class="row">
        @foreach($materials as $material)
            <div class="col-12 mb-5 p-3 shadow-sm">
                <div class="h5">{{ $material->subject }}</div>
                <div class="my-1 text-muted"><i class="far fa-clock"></i> {{ $material->created_at }}</div>
                <div class="my-3">{{ Str::limit($material->text, 300, ' ...') }}</div>
                <div class="mt-2"><a class="btn btn-sm btn-outline-primary" href="{{ route('material-show', ['id' => $material]) }}">Подробнее →</a></div>
            </div>
        @endforeach
        </div>
    @else
        <div class="text-muted">Данные отсутствуют.</div>
    @endif
    </div>
@endsection
