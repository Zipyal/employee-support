@php
    use App\Models\Permission;
    use App\Models\Task;
    use App\Models\User;

    /** @var Task $task */
    /** @var string[] $statuses */
    /** @var string[] $priorities */
    /** @var string[] $types */
    /** @var string[] $employees */
    /** @var string[] $briefings */
    /** @var string[] $materials */
    /** @var string[] $tests */
@endphp
@extends('layout.main')
@section('title')
    {{ $task->id ? 'Редактирование' : 'Создание' }} задачи {{ $task->id }}
@endsection
@if($task->id)
    @section('buttons')
        @canany([Permission::TASK_SEE_ALL, Permission::TASK_SEE_OWN, Permission::TASK_SEE_ASSIGNED])
            <a class="btn btn-outline-dark" href="{{ route('task-show', ['id' => $task->id]) }}"><i class="far fa-eye"></i></a>
        @endcanany
        @can(Permission::TASK_DELETE)
            <form method="post" class="d-inline" action="{{ route('task-delete', ['id' => $task]) }}"
                  onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
                @csrf
                <button type="submit" class="btn btn-lg btn-danger"><i class="fas fa-trash-alt"></i></button>
            </form>
        @endcan
    @endsection
@endif
@section('content')

    @php
        if (isset($task->id)) {
            $formUrl = route('task-update', ['id' => $task->id]);
        } else {
            $formUrl = route('task-store');
        }
    @endphp

    <div class="container">
        <form method="post" action="{{ $formUrl }}" enctype="multipart/form-data" class="row g-3 needs-validation">
            @csrf

            <input type="hidden" name="author_id" value="{{ auth()->user()->id }}">

            <div class="col-12">
                <label for="subject" class="form-label">Тема</label>
                <div class="input-group has-validation">
                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject"
                           name="subject" value="{{ old('subject')  ?? $task->subject }}">
                    @error('subject')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <label for="status" class="form-label">Статус</label>
                <div class="input-group has-validation">
                    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror"
                            @if(!$task->id) disabled @endif>
                        <option value=""> - Не выбрано -</option>
                        @foreach ($statuses as $status)
                            <option
                                value="{{ $status }}" {{ (old('status') ?? $task->status) == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            @if(!$task->id)
                <input type="hidden" name="status" value="{{ $task->status }}">
            @endif

            <div class="col-12 col-md-4">
                <label for="priority" class="form-label">Приоритет</label>
                <div class="input-group has-validation">
                    <select id="priority" name="priority" class="form-select @error('priority') is-invalid @enderror">
                        @foreach ($priorities as $priority)
                            <option class="{{ Task::PRIORITY_CSS_CLASSES[$priority] }}"
                                    value="{{ $priority }}" {{ (old('priority') ?? $task->priority) == $priority ? 'selected' : '' }}>
                                {{ $priority }}
                            </option>
                        @endforeach
                    </select>
                    @error('priority')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            @if(!$task->id)
                <input type="hidden" name="priority" value="{{ $task->priority }}">
            @endif

            <div class="col-12 col-md-4">
                <label for="type" class="form-label">Тип</label>
                <div class="input-group has-validation">
                    <select id="type" name="type" class="form-select @error('type') is-invalid @enderror">
                        <option value=""> - Не выбрано -</option>
                        @foreach ($types as $type)
                            <option value="{{ $type }}" {{ (old('type') ?? $task->type) == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <label for="start_date" class="form-label">Планируемая дата начала</label>
                <div class="input-group has-validation">
                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                           name="start_date" value="{{ old('start_date') ?? $task->start_date?->toDateString() }}">
                    @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <label for="end_date" class="form-label">Планируемая дата завершения</label>
                <div class="input-group has-validation">
                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date"
                           name="end_date" value="{{ old('end_date') ?? $task->end_date }}">
                    @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-4">
                <label for="employee_uuid" class="form-label">Назначена</label>
                <div class="input-group has-validation">
                    <select id="type" name="employee_uuid"
                            class="form-select @error('employee_uuid') is-invalid @enderror">
                        <option value=""> - Не выбрано -</option>
                        @php $prevRoleId = null; @endphp
                        @foreach ($employees as $i => $employee)
                            @php $roleId = $employee->user?->role_id @endphp
                            @if($loop->first || $roleId != $prevRoleId)
                                @if(!$loop->first)</optgroup>@endif
                        <optgroup label="{{ null !== $roleId ? User::ROLES[$roleId] : 'Без роли' }}">
                            @endif
                            <option
                                value="{{ $employee->uuid }}" {{ (old('employee_uuid') ?? $task->employee_uuid) == $employee->uuid ? 'selected' : '' }}>{{ $employee->fullName }}</option>
                            @if($loop->last)</optgroup>@endif
                        @php $prevRoleId = $roleId; @endphp
                        @endforeach
                    </select>
                    @error('employee_uuid')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <div class="row bg-light py-3">
                    <div class="col-12 col-md-4">
                        <label for="briefing_uuid" class="form-label"><i class="fas fa-paperclip"></i> Прикрепить
                            инструктаж</label>
                        <div class="input-group has-validation">
                            <select id="type" name="briefing_uuid"
                                    class="form-select @error('briefing_uuid') is-invalid @enderror">
                                <option value=""> - Не выбрано -</option>
                                @foreach ($briefings as $uuid => $subject)
                                    <option
                                        value="{{ $uuid }}" {{ (old('briefing_uuid') ?? $task->briefing_uuid) == $uuid ? 'selected' : '' }}>{{ $subject }}</option>
                                @endforeach
                            </select>
                            @error('briefing_uuid')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="test_uuid" class="form-label"><i class="fas fa-paperclip"></i> Прикрепить
                            тест</label>
                        <div class="input-group has-validation">
                            <select id="type" name="test_uuid"
                                    class="form-select @error('test_uuid') is-invalid @enderror">
                                <option value=""> - Не выбрано -</option>
                                @foreach ($tests as $uuid => $subject)
                                    <option
                                        value="{{ $uuid }}" {{ (old('test_uuid') ?? $task->test_uuid) == $uuid ? 'selected' : '' }}>{{ $subject }}</option>
                                @endforeach
                            </select>
                            @error('test_uuid')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="material_uuid" class="form-label"><i class="fas fa-paperclip"></i> Прикрепить
                            материал</label>
                        <div class="input-group has-validation">
                            <select id="type" name="material_uuid"
                                    class="form-select @error('material_uuid') is-invalid @enderror">
                                <option value=""> - Не выбрано -</option>
                                @foreach ($materials as $uuid => $subject)
                                    <option
                                        value="{{ $uuid }}" {{ (old('material_uuid') ?? $task->material_uuid) == $uuid ? 'selected' : '' }}>{{ $subject }}</option>
                                @endforeach
                            </select>
                            @error('material_uuid')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                @include('_form_upload_image', ['images' => $task->images])
            </div>

            <div class="col-12">
                <label for="description" class="form-label">Описание</label>
                <div class="input-group has-validation">
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                              name="description">{{ old('description') ?? $task->description }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 mt-5">
                <div class="row">
                    <div class="col text-start">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Сохранить</button>
                    </div>
                    <div class="col text-center">
                        <button type="submit" name="stay-here" class="btn btn-outline-primary" value="1"><i
                                class="fas fa-save"></i> Сохранить и продолжить редактирование
                        </button>
                    </div>
                    <div class="col text-end">
                        @if($task->id)
                            <a class="btn btn-outline-warning" href="{{ route('task-show', ['id' => $task->id]) }}"><i
                                    class="fas fa-ban"></i> Отмена</a>
                        @else
                            <button type="reset" class="btn btn-outline-danger"><i class="fas fa-eraser"></i> Очистить
                                форму
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
