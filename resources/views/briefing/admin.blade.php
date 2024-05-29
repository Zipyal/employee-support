@php
    use App\Models\Briefing;
    use App\Models\Permission;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Collection;

    /** @var Briefing[]|Collection $briefings */
@endphp
@extends('layout.main')
@section('title')
    Инструктажи
@endsection
@section('buttons')
    @can(Permission::BRIEFING_ADD)
        <a class="btn btn-sm btn-outline-success" href="{{ route('briefing-add') }}"><i class="fas fa-plus"></i></a>
    @endcan
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
                    <th scope="col"></th>
                    <th scope="col" class="text-end">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($briefings as $briefing)
                    <tr data-id="{{ $briefing->uuid }}">
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $briefing->subject }}</td>
                        <td>{{ Str::limit($briefing->text, 50, ' ...') }}</td>
                        <td class="created_at">{{ $briefing->created_at }}</td>
                        <td class="updated_at">{{ $briefing->updated_at }}</td>
                        <td>{{ $briefing->author?->employee?->fullName ?? $briefing->author?->name }}</td>
                        <td>
                            @canany([Permission::BRIEFING_EDIT, Permission::BRIEFING_EDIT_OWN])
                                <input type="checkbox"
                                       data-toggle="toggle"
                                       data-size="small"
                                       data-onlabel="опубликовано" data-onstyle="success"
                                       data-offlabel="скрыто" data-offstyle="secondary"
                                       class="toggle-publish"
                                       data-url="{{ route('briefing-publish', ['id' => $briefing->uuid]) }}"
                                       data-id="{{ $briefing->uuid }}"
                                       @if($briefing->published) checked @endif>
                            @else
                                @if($briefing->published)
                                    <span class="text-success">опубликовано</span>
                                @else
                                    <span class="text-danger">скрыто</span>
                                @endif
                            @endcanany
                        </td>
                        <td class="text-end text-nowrap">
                            @canany([Permission::BRIEFING_SEE_ALL, Permission::BRIEFING_SEE_OWN, Permission::BRIEFING_SEE_PUBLISHED])
                                <a class="btn btn-sm btn-outline-dark" href="{{ route('briefing-show', ['id' => $briefing]) }}"><i class="far fa-eye"></i></a>
                            @endcanany
                            @canany([Permission::BRIEFING_EDIT, Permission::BRIEFING_EDIT_OWN])
                                <a class="btn btn-sm btn-outline-dark" href="{{ route('briefing-edit', ['id' => $briefing]) }}"><i class="fas fa-pencil-alt"></i></a>
                            @endcanany
                            @canany([Permission::BRIEFING_DELETE, Permission::BRIEFING_DELETE_OWN])
                                <form method="post" class="d-inline" action="{{ route('briefing-delete', ['id' => $briefing]) }}"
                                      onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            @endcanany
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="text-muted">Данные отсутствуют.</div>
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
                        headers: {
                            'Content-Type': 'application/json'
                        },
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
