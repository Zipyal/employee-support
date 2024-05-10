@extends('layout.main')
@section('content')

    @php
        /** @var $briefing \App\Models\Briefing */
    @endphp

    <div class="row">
        <div class="col">
            <h1>{{ $briefing->subject }}</h1>
        </div>
        <div class="col text-end">
            <a class="btn btn-sm btn-outline-dark" href="{{ route('briefing-edit', ['id' => $briefing]) }}">✎</a>
            <form method="post" class="d-inline" action="{{ route('briefing-delete', ['id' => $briefing]) }}"
                  onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">@csrf <input
                    type="submit" class="btn btn-sm btn-danger" value="🗑"></form>
        </div>
    </div>



    <table class="table table-hover">
        <tr>
            <th>Объект</th>
            <td>{{ $briefing->subject }}</td>
        </tr>
        <tr>
            <th>Категория</th>
            <td>{{ $briefing->category }}</td>
        </tr>
        <tr>
            <th>Текст</th>
            <td>{{ $briefing->text }}</td>
        </tr>
    </table>

@endsection
