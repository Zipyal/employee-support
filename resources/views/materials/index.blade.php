@php
    /** @var $materials \App\Models\Material[]|\Illuminate\Database\Eloquent\Collection */
@endphp
<h1>{{ 'Список материалов' }}</h1>

<div><a href="{{ route('material-add') }}">Создать материал</a></div>

<ul>
    @foreach($materials as $material)
        <li>
            <a href="{{ route('material-show', ['id' => $material->ID_Статьи]) }}">{{ $material->Тема }}</a>

            <br><button><a href="{{ route('material-edit', ['id' => $material->ID_Статьи]) }}">✎</a></button>

            <form method="post" action="{{ route('material-delete', ['id' => $material->ID_Статьи]) }}"
                  onSubmit="if(!confirm('Вы действительно хотите удалить материал?')){return false;}">@csrf <input
                    type="submit" value="🗑"></form>
        </li>
    @endforeach
</ul>
