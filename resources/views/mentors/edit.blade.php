@extends('layout.main')
@section('content')

    {{--@dd($roles)--}}

    <h1>{{ $mentor->uuid ? 'Редактирование' : 'Создание' }} наставника</h1>

    @php
        if (isset($mentor->uuid)) {
            $formUrl = route('mentor-update', ['id' => $mentor->uuid]);
        } else {
            $formUrl = route('mentor-store');
        }
    @endphp



    <form method="post" action="{{ $formUrl }}" class="row g-3 needs-validation">
        @csrf
        <div class="col-12 col-md-4">
            <label for="last_name" class="form-label">Фамилия</label>
            <div class="input-group has-validation">
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                       name="last_name" value="{{ old('last_name') ?? $mentor->last_name }}">
                @error('last_name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-4">
            <label for="first_name" class="form-label">Имя</label>
            <div class="input-group has-validation">
                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name')  ?? $mentor->first_name }}">
                @error('first_name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-4">
            <label for="patronymic" class="form-label">Отчество</label>
            <div class="input-group has-validation">
                <input type="text" class="form-control @error('patronymic') is-invalid @enderror" id="patronymic" name="patronymic" value="{{ old('patronymic') ?? $mentor->patronymic }}">
                @error('patronymic')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-6">
            <label for="phone" class="form-label">Телефон</label>
            <div class="input-group has-validation">
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') ?? $mentor->phone }}">
                @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-6">
            <label for="email" class="form-label">Почта</label>
            <div class="input-group has-validation">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') ?? $mentor->email }}">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-4">
            <label for="role" class="form-label">Роль</label>
            <div class="input-group has-validation">
                <select id="role" name="role" class="form-select @error('role') is-invalid @enderror">
                    <option value=""> - Не выбрано -</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role }}" {{ (old('role') ?? $mentor->role) == $role ? 'selected' : '' }}>
                            {{ $role }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-4">
            <label for="position" class="form-label">Должность</label>
            <div class="input-group has-validation">
                <input type="text" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position') ?? $mentor->position }}">
                @error('position')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-4">
            <label for="department" class="form-label">Отдел</label>
            <div class="input-group has-validation">
                <input type="text" class="form-control @error('department') is-invalid @enderror" id="department" name="department" value="{{ old('department') ?? $mentor->department }}">
                @error('department')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-4">
            <label for="education" class="form-label">Образование</label>
            <div class="input-group has-validation">
                <input type="text" class="form-control @error('education') is-invalid @enderror" id="education" name="education" value="{{ old('education') ?? $mentor->education }}">
                @error('education')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-4">
            <label for="add_education" class="form-label">Дополнительное образование</label>
            <div class="input-group has-validation">
                <input type="text" class="form-control @error('add_education') is-invalid @enderror" id="add_education" name="add_education" value="{{ old('add_education') ?? $mentor->add_education }}">
                @error('add_education')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-4">
            <label for="experience" class="form-label">Опыт работы</label>
            <div class="input-group has-validation">
                <input type="number" class="form-control @error('experience') is-invalid @enderror" id="experience" name="experience" value="{{ old('experience') ?? $mentor->experience }}">
                @error('experience')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>

@endsection
