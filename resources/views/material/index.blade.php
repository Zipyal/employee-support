@php
    /** @var \App\Models\Material[]|\Illuminate\Database\Eloquent\Collection $materials */
@endphp
@extends('layout.main')
@section('title')Материалы@endsection
@section('buttons')
    <a class="btn btn-sm btn-outline-success" href="{{ route('material-add') }}"><i class="fas fa-plus"></i></a>
@endsection
@section('content')

    <div class="container">
        @if($materials->isNotEmpty())
            <table class="table table-hover mt-5">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Категория</th>
                    <th scope="col">Тема</th>
                    <th scope="col">Текст</th>
                    <th scope="col">Добавлено</th>
                    <th scope="col">Обновлено</th>
                    <th scope="col">Автор</th>
                    <th scope="col" class="text-end">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($materials as $material)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $material->category }}</td>
                        <td>{{ $material->subject }}</td>
                        <td>{{ Str::limit($material->text, 50, ' ...') }}</td>
                        <td>{{ $material->created_at }}</td>
                        <td>{{ $material->updated_at }}</td>
                        <td>{{ $material->author?->fullName }}</td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-dark" href="{{ route('material-show', ['id' => $material]) }}"><i class="far fa-eye"></i></a>
                            <a class="btn btn-sm btn-outline-dark" href="{{ route('material-edit', ['id' => $material]) }}"><i class="fas fa-pencil-alt"></i></a>
                            <form method="post" class="d-inline" action="{{ route('material-delete', ['id' => $material]) }}" onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                            </form>
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
