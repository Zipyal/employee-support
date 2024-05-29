@php
    use App\Models\Permission;
    use App\Models\Test;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Collection;

    /** @var Test[]|Collection $test */
@endphp
@extends('layout.main')
@section('title')
    Тесты
@endsection
@section('buttons')
    @can(Permission::TEST_ADD)
        <a class="btn btn-sm btn-outline-success" href="{{ route('test-add') }}"><i class="fas fa-plus"></i></a>
    @endcan
@endsection
@section('content')

    <div class="container">
        @if($tests->isNotEmpty())
            <table class="table table-hover mt-5">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Категория</th>
                    <th scope="col">Тема</th>
                    <th scope="col">Вопросов</th>
                    <th scope="col">Добавлено</th>
                    <th scope="col">Обновлено</th>
                    <th scope="col">Автор</th>
                    <th scope="col" class="text-end">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tests as $test)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $test->category }}</td>
                        <td>{{ $test->subject }}</td>
                        <td>{{ $test->questions?->count() }}</td>
                        <td>{{ $test->created_at }}</td>
                        <td>{{ $test->updated_at }}</td>
                        <td>{{ $test->author?->employee?->lastFirstName ?? $test->author?->name }}</td>
                        <td class="text-end text-nowrap">
                            @canany([Permission::TEST_SEE_ALL, Permission::TEST_SEE_OWN, Permission::TEST_SEE_ASSIGNED])
                                <a class="btn btn-sm btn-outline-dark" href="{{ route('test-show', ['id' => $test]) }}"><i class="far fa-eye"></i></a>
                            @endif
                            @can(Permission::TEST_EDIT)
                                <a class="btn btn-sm btn-outline-dark" href="{{ route('test-edit', ['id' => $test]) }}"><i class="fas fa-pencil-alt"></i></a>
                            @endcan
                            @can(Permission::TEST_DELETE)
                                <form method="post" class="d-inline" action="{{ route('test-delete', ['id' => $test]) }}"
                                      onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="text-muted">Данные отсутствуют.</div>
        @endif
    </div>

@endsection
