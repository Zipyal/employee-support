@php
    /** @var \App\Models\Briefing[]|\Illuminate\Database\Eloquent\Collection $briefings */
@endphp
@extends('layout.main')
@section('title')Инструктажи@endsection
@section('buttons')
    <a class="btn btn-sm btn-outline-success" href="{{ route('briefing-add') }}"><i class="fas fa-plus"></i></a>
@endsection
@section('content')

    <div class="container">
        @if($briefings->isNotEmpty())
        <table class="table table-hover mt-5">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Тема</th>
                <th scope="col">Текст</th>
                <th scope="col">Добавлено</th>
                <th scope="col">Обновлено</th>
                <th scope="col">Автор</th>
                <th scope="col" class="text-end">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($briefings as $briefing)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $briefing->subject }}</td>
                    <td>{{ Str::limit($briefing->text, 50, ' ...') }}</td>
                    <td>{{ $briefing->created_at }}</td>
                    <td>{{ $briefing->updated_at }}</td>
                    <td>{{ $briefing->author?->fullName }}</td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-dark" href="{{ route('briefing-show', ['id' => $briefing]) }}"><i class="far fa-eye"></i></a>
                        <a class="btn btn-sm btn-outline-dark" href="{{ route('briefing-edit', ['id' => $briefing]) }}"><i class="fas fa-pencil-alt"></i></a>
                        <form method="post" class="d-inline" action="{{ route('briefing-delete', ['id' => $briefing]) }}" onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
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
