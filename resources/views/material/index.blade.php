@extends('layout.main')
@section('content')

    @php
        /** @var $material \App\Models\Material[]|\Illuminate\Database\Eloquent\Collection */
    @endphp


    <div class="container">
        <div class="row mt-2 mb-5">
            <div class="col">
                <h1>Материалы</h1>
            </div>
            <div class="col text-end">
                <a class="btn btn-sm btn-success" href="{{ route('material-add') }}"><strong
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
        @foreach($materials as $i => $material)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $material->subject . ' ' . $material->first_name . ' ' . $material->patronymic }}</td>
                <td>{{ $material->category }}</td>
                <td>{{ $material->text }}</td>
                <td>
                    <a class="btn btn-sm btn-outline-dark"
                       href="{{ route('material-show', ['id' => $material]) }}">👁</a>
                    <a class="btn btn-sm btn-outline-dark"
                       href="{{ route('material-edit', ['id' => $material]) }}">✎</a>
                    <form method="post" class="d-inline" action="{{ route('material-delete', ['id' => $material]) }}"
                          onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">@csrf <input
                            type="submit" class="btn btn-sm btn-danger" value="🗑"></form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
