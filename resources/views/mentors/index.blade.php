@extends('layout.main')
@section('content')

    @php
        /** @var $mentors \App\Models\Mentor[]|\Illuminate\Database\Eloquent\Collection */
    @endphp

    <div class="row">
        <div class="col">
            <h1>Наставники</h1>
        </div>
        <div class="col text-end">
            <a class="btn btn-sm btn-success" href="{{ route('mentor-add') }}"><strong class="fs-1 m-0 lh-1">+</strong></a>
        </div>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">ФИО</th>
            <th scope="col">Телефон</th>
            <th scope="col">Эл. почта</th>
            <th scope="col">Роль</th>
            <th scope="col">Должность</th>
            <th scope="col">Отдел</th>
            <th scope="col">Образование</th>
            <th scope="col">Доп. образование</th>
            <th scope="col">Опыт работы</th>
            <th scope="col">Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($mentors as $i => $mentor)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $mentor->last_name . ' ' . $mentor->first_name . ' ' . $mentor->patronymic }}</td>
                <td>{{ $mentor->phone }}</td>
                <td>{{ $mentor->email }}</td>
                <td>{{ $mentor->role }}</td>
                <td>{{ $mentor->position }}</td>
                <td>{{ $mentor->department }}</td>
                <td>{{ $mentor->education }}</td>
                <td>{{ $mentor->add_education }}</td>
                <td>{{ $mentor->experience }}</td>
                <td>
                    <a class="btn btn-sm btn-outline-dark" href="{{ route('mentor-show', ['id' => $mentor]) }}">👁</a>
                    <a class="btn btn-sm btn-outline-dark" href="{{ route('mentor-edit', ['id' => $mentor]) }}">✎</a>
                    <form method="post" class="d-inline" action="{{ route('mentor-delete', ['id' => $mentor]) }}"
                          onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">@csrf <input
                            type="submit" class="btn btn-sm btn-danger" value="🗑"></form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
