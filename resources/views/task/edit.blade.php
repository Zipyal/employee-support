@extends('layout.main')
@section('content')

    {{--@dd($roles)--}}

    <h1>{{ $task->uuid ? 'Редактирование' : 'Создание' }} Материала</h1>

    @php
        if (isset($task->uuid)) {
            $formUrl = route('task-update', ['id' => $task->uuid]);
        } else {
            $formUrl = route('task-store');
        }
    @endphp



    <form method="post" action="{{ $formUrl }}" class="row g-3 needs-validation">
        @csrf
        <div class="col-12 col-md-4">
            <label for="status" class="form-label">Объект</label>
            <div class="input-group has-validation">
                <input type="start_date" class="form-control @error('status') is-invalid @enderror" id="status"
                       name="status" value="{{ old('status') ?? $task->status }}">
                @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-4">
            <label for="type" class="form-label">Категория</label>
            <div class="input-group has-validation">
                <input type="start_date" class="form-control @error('type') is-invalid @enderror" id="type" name="type" value="{{ old('type')  ?? $task->type }}">
                @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-4">
            <label for="start_date" class="form-label">Текст</label>
            <div class="input-group has-validation">
                <input type="start_date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') ?? $task->start_date }}">
                @error('start_date')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-4">
            <label for="end_date" class="form-label">Текст</label>
            <div class="input-group has-validation">
                <input type="end_date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') ?? $task->end_date }}">
                @error('end_date')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>


        <div class="col-12 col-md-4">
            <label for="description" class="form-label">Текст</label>
            <div class="input-group has-validation">
                <input type="description" class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{ old('description') ?? $task->description }}">
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>

@endsection
