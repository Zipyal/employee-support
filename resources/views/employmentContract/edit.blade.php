@extends('layout.main')
@section('title'){{ $employmentContract->uuid ? 'Редактирование' : 'Создание' }} трудового договора@endsection
@section('subtitle'){{ $employee->fullName }}@endsection
@section('content')

    @php
        /** @var \App\Models\Employee $employee */
        /** @var \App\Models\EmploymentContract $employmentContract */

        if (isset($employmentContract->uuid)) {
            $formUrl = route('employee-update-contract', ['employeeId' => $employee->uuid, 'contractId' => $employmentContract->uuid]);
        } else {
            $formUrl = route('employee-store-contract', ['employeeId' => $employee->uuid]);
        }
    @endphp

    <div class="container">
        <form method="post" action="{{ $formUrl }}" class="row g-3 needs-validation">
            @csrf
            <input type="hidden" name="employee_uuid" value="{{ $employee->uuid }}">

            <div class="col-12 col-md-3">
                <label for="number" class="form-label">Номер</label>
                <div class="input-group has-validation">
                    <input type="text" class="form-control @error('number') is-invalid @enderror" id="number"
                           name="number" value="{{ old('number') ?? $employmentContract->number }}">
                    @error('number')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-3">
                <label for="register_date" class="form-label">Дата регистрации</label>
                <div class="input-group has-validation">
                    <input type="date" class="form-control @error('register_date') is-invalid @enderror" id="register_date" name="register_date" value="{{ old('register_date') ?? $employmentContract->register_date }}">
                    @error('register_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-3">
                <label for="end_date" class="form-label">Дата окончания</label>
                <div class="input-group has-validation">
                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') ?? $employmentContract->end_date }}">
                    @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-3">
                <label for="register_address" class="form-label">Место регистрации</label>
                <div class="input-group has-validation">
                    <input type="text" class="form-control @error('register_address') is-invalid @enderror" id="register_address" name="register_address" value="{{ old('register_address') ?? $employmentContract->register_address }}">
                    @error('register_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-3">
                <label for="position" class="form-label">Должность</label>
                <div class="input-group has-validation">
                    <input type="text" class="form-control @error('position') is-invalid @enderror" id="position"
                           name="position" value="{{ old('position') ?? $employmentContract->position }}">
                    @error('position')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-3">
                <label for="department" class="form-label">Отдел</label>
                <div class="input-group has-validation">
                    <input type="text" class="form-control @error('department') is-invalid @enderror" id="department" name="department" value="{{ old('department')  ?? $employmentContract->department }}">
                    @error('department')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-3">
                <label for="salary" class="form-label">Зарплата, руб.</label>
                <div class="input-group has-validation">
                    <input type="number" step="0.1" class="form-control @error('salary') is-invalid @enderror" id="salary" name="salary" value="{{ old('salary') ?? $employmentContract->salary }}">
                    @error('salary')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-3">
                <label for="rate" class="form-label">Ставка, час.</label>
                <div class="input-group has-validation">
                    <input type="number" min="1" max="24" class="form-control @error('rate') is-invalid @enderror" id="rate" name="rate" value="{{ old('rate') ?? $employmentContract->rate }}">
                    @error('rate')
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
                        @if(!$employmentContract->uuid)
                            <button type="reset" class="btn btn-outline-danger"><i class="fas fa-eraser"></i> Очистить форму</button>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
