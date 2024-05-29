@php
    use App\Models\Material;
    use App\Models\Permission;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Collection;

    /** @var Material[]|Collection $materials */
@endphp
@extends('layout.main')
@section('title')
    Материалы
@endsection
@section('buttons')
    @can(Permission::MATERIAL_ADD)
        <a class="btn btn-sm btn-outline-success" href="{{ route('material-add') }}"><i class="fas fa-plus"></i></a>
    @endcan
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
                    <th scope="col"></th>
                    <th scope="col" class="text-end">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($materials as $material)
                    <tr data-id="{{ $material->uuid }}">
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $material->category }}</td>
                        <td>{{ $material->subject }}</td>
                        <td>{{ Str::limit($material->text, 50, ' ...') }}</td>
                        <td class="created_at">{{ $material->created_at }}</td>
                        <td class="updated_at">{{ $material->updated_at }}</td>
                        <td>{{ $material->author?->employee?->fullName ?? $material->author?->name }}</td>
                        <td>
                            @can(Permission::MATERIAL_EDIT)
                                <input type="checkbox"
                                       data-toggle="toggle"
                                       data-size="small"
                                       data-onlabel="опубликовано" data-onstyle="success"
                                       data-offlabel="скрыто" data-offstyle="secondary"
                                       class="toggle-publish"
                                       data-url="{{ route('material-publish', ['id' => $material->uuid]) }}"
                                       data-id="{{ $material->uuid }}"
                                       @if($material->published) checked @endif>
                            @else
                                @if($material->published)
                                    <span class="text-success">опубликовано</span>
                                @else
                                    <span class="text-danger">скрыто</span>
                                @endif
                            @endcan
                        </td>
                        <td class="text-end text-nowrap">
                            @canany([Permission::MATERIAL_SEE_ALL, Permission::MATERIAL_SEE_OWN, Permission::MATERIAL_SEE_PUBLISHED])
                                <a class="btn btn-sm btn-outline-dark" href="{{ route('material-show', ['id' => $material]) }}"><i class="far fa-eye"></i></a>
                            @endcanany
                            @can(Permission::MATERIAL_EDIT)
                                <a class="btn btn-sm btn-outline-dark" href="{{ route('material-edit', ['id' => $material]) }}"><i class="fas fa-pencil-alt"></i></a>
                            @endcan
                            @can(Permission::MATERIAL_DELETE)
                                <form method="post" class="d-inline" action="{{ route('material-delete', ['id' => $material]) }}"
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
            <div class="text-muted">Нет опубликованных материалов.</div>
        @endif
    </div>

    <script>
        document.querySelectorAll('.toggle-publish').forEach(function (toggleElement) {
            toggleElement.addEventListener('change', async function () {
                try {
                const id = this.dataset.id;
                const postData = {
                    published: this.checked,
                    _token: "{{ csrf_token() }}"
                };

                    const response = await fetch(this.dataset.url, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(postData)
                    });

                    const data = await response.json();
                    // console.log(data);

                    const updatedAt = document.querySelector('tr[data-id="' + id + '"] > td.updated_at');
                    updatedAt.textContent = data['updated_at'];

                } catch (e) {
                    console.error(e);
                }
            });
        });
    </script>
@endsection
