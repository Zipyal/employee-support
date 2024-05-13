@extends('layout.main')
@section('title'){{ $employee->uuid ? 'Редактирование' : 'Создание' }} сотрудника@endsection
@section('buttons')
    @if($employee->uuid)
    <a class="btn btn-outline-dark" href="{{ route('employee-show', ['id' => $employee->uuid]) }}"><i class="far fa-eye"></i></a>
    <form method="post" class="d-inline" action="{{ route('employee-delete', ['id' => $employee]) }}"
          onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
        @csrf
        <button type="submit" class="btn btn-lg btn-danger"><i class="fas fa-trash-alt"></i></button>
    </form>
    @endif
@endsection
@section('content')

    @php
        if (isset($employee->uuid)) {
            $formUrl = route('employee-update', ['id' => $employee->uuid]);
        } else {
            $formUrl = route('employee-store');
        }
    @endphp

    <div class="container">
        <form method="post" action="{{ $formUrl }}" class="row g-3 needs-validation">
            @csrf
            <div class="col-12 col-md-4">
                <label for="last_name" class="form-label">Фамилия</label>
                <div class="input-group has-validation">
                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                           name="last_name" value="{{ old('last_name') ?? $employee->last_name }}">
                    @error('last_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <label for="first_name" class="form-label">Имя</label>
                <div class="input-group has-validation">
                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name')  ?? $employee->first_name }}">
                    @error('first_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <label for="patronymic" class="form-label">Отчество</label>
                <div class="input-group has-validation">
                    <input type="text" class="form-control @error('patronymic') is-invalid @enderror" id="patronymic" name="patronymic" value="{{ old('patronymic') ?? $employee->patronymic }}">
                    @error('patronymic')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <label for="phone" class="form-label">Телефон</label>
                <div class="input-group has-validation">
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') ?? $employee->phone }}">
                    @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <label for="email" class="form-label">Почта</label>
                <div class="input-group has-validation">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') ?? $employee->email }}">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <label for="birth_date" class="form-label">Дата рождения</label>
                <div class="input-group has-validation">
                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date') ?? $employee->birth_date }}">
                    @error('birth_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <label for="education" class="form-label">Образование</label>
                <div class="input-group has-validation">
                    <input type="text" class="form-control @error('education') is-invalid @enderror" id="education" name="education" value="{{ old('education') ?? $employee->education }}">
                    @error('education')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <label for="add_education" class="form-label">Дополнительное образование</label>
                <div class="input-group has-validation">
                    <input type="text" class="form-control @error('add_education') is-invalid @enderror" id="add_education" name="add_education" value="{{ old('add_education') ?? $employee->add_education }}">
                    @error('add_education')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <label for="experience" class="form-label">Опыт работы</label>
                <div class="input-group has-validation">
                    <input type="number" class="form-control @error('experience') is-invalid @enderror" id="experience" name="experience" value="{{ old('experience') ?? $employee->experience }}">
                    @error('experience')
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
                            <option value="{{ $role }}" {{ (old('role') ?? $employee->role) == $role ? 'selected' : '' }}>
                                {{ $role }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 mt-5">
                <div class="row">
                    <div class="col text-start">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Сохранить</button>
                    </div>
                    <div class="col text-end">
                        @if($employee->uuid)
                            <a class="btn btn-outline-warning" href="{{ route('employee-show', ['id' => $employee->uuid]) }}"><i class="fas fa-ban"></i> Отмена</a>
                        @else
                            <button type="reset" class="btn btn-outline-danger"><i class="fas fa-eraser"></i> Очистить форму</button>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
