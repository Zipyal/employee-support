@extends('layout.main')
@section('content')

    @php
        /** @var $material \App\Models\Material */
    @endphp

    <div class="row">
        <div class="col">
            <h1>{{ $material->subject }}</h1>
        </div>
        <div class="col text-end">
            <a class="btn btn-sm btn-outline-dark" href="{{ route('material-edit', ['id' => $material]) }}">✎</a>
            <form method="post" class="d-inline" action="{{ route('material-delete', ['id' => $material]) }}"
                  onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">@csrf <input
                    type="submit" class="btn btn-sm btn-danger" value="🗑"></form>
        </div>
    </div>



    <table class="table table-hover">
        <tr>
            <th>Объект</th>
            <td>{{ $material->subject }}</td>
        </tr>
        <tr>
            <th>Категория</th>
            <td>{{ $material->category }}</td>
        </tr>
        <tr>
            <th>Текст</th>
            <td>{{ $material->text }}</td>
        </tr>
    </table>

@endsection
