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

        <div class="p-3 mb-3 bg-light row">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <form method="get" action="{{ url()->current() }}">
                    <label class="text-muted" for="filter-role">Роль: </label>
                    <select id="filter-role" class="form-control form-select" name="role" onchange="this.form.submit()">
                        <option value="">- не выбрано -</option>
                    </select>
                </form>
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
