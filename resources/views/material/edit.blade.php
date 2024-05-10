@extends('layout.main')
@section('content')

    {{--@dd($roles)--}}

    <h1>{{ $material->uuid ? 'Редактирование' : 'Создание' }} Материала</h1>

    @php
        if (isset($material->uuid)) {
            $formUrl = route('material-update', ['id' => $material->uuid]);
        } else {
            $formUrl = route('material-store');
        }
    @endphp



    <form method="post" action="{{ $formUrl }}" class="row g-3 needs-validation">
        @csrf
        <div class="col-12 col-md-4">
            <label for="subject" class="form-label">Объект</label>
            <div class="input-group has-validation">
                <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject"
                       name="subject" value="{{ old('subject') ?? $material->subject }}">
                @error('subject')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-4">
            <label for="category" class="form-label">Категория</label>
            <div class="input-group has-validation">
                <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" value="{{ old('category')  ?? $material->category }}">
                @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-4">
            <label for="text" class="form-label">Текст</label>
            <div class="input-group has-validation">
                <input type="text" class="form-control @error('text') is-invalid @enderror" id="text" name="text" value="{{ old('text') ?? $material->text }}">
                @error('text')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>

@endsection
