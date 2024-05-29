@php
    use App\Models\User;
    /** @var \App\Models\Material[]|\Illuminate\Database\Eloquent\Collection $materials */
@endphp
@extends('layout.main')
@section('title')
    Материалы
@endsection
@section('content')
    <div class="container">
        @if($materials->isNotEmpty())
            <div class="row">
                <div class="col-12 col-md mb-5">
                    {{--<h3 class="mb-5">Материалы</h3>--}}
                    @foreach($materials as $item)
                        <div class="card shadow-sm mb-5">
                            <div class="card-body">
                                {{--<div class="text-muted opacity-50">Материал</div>--}}
                                <div class="card-title h5">{{ $item->subject }}</div>
                                <div class="card-subtitle text-muted"><i class="far fa-clock"></i> {{ $item->updated_at }}</div>
                                <div class="my-3 card-text">{{ Str::limit($item->text, 300, ' ...') }}</div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col"></div>
                                    <div class="col text-end">
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('material-show', ['id' => $item]) }}">Подробнее →</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-muted">Нет опубликованных материалов.</div>
        @endif
    </div>
@endsection
