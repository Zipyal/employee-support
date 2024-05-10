@extends('layout.main')
@section('content')

    @php
        /** @var $briefing \App\Models\Briefing[]|\Illuminate\Database\Eloquent\Collection */
    @endphp


    <div class="container">
        <div class="row mt-2 mb-5">
            <div class="col">
                <h1>Материалы</h1>
            </div>
            <div class="col text-end">
                <a class="btn btn-sm btn-success" href="{{ route('briefing-add') }}"><strong
                        class="fs-1 m-0 lh-1">+</strong></a>
            </div>
        </div>
    </div>

    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Объект</th>
            <th scope="col">Категория</th>
            <th scope="col">Текст</th>
        </tr>
        </thead>
        <tbody>
        @foreach($briefings as $i => $briefing)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $briefing->subject . ' ' . $briefing->first_name . ' ' . $briefing->patronymic }}</td>
                <td>{{ $briefing->category }}</td>
                <td>{{ $briefing->text }}</td>
                <td>
                    <a class="btn btn-sm btn-outline-dark"
                       href="{{ route('briefing-show', ['id' => $briefing]) }}">👁</a>
                    <a class="btn btn-sm btn-outline-dark"
                       href="{{ route('briefing-edit', ['id' => $briefing]) }}">✎</a>
                    <form method="post" class="d-inline" action="{{ route('briefing-delete', ['id' => $briefing]) }}"
                          onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">@csrf <input
                            type="submit" class="btn btn-sm btn-danger" value="🗑"></form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
