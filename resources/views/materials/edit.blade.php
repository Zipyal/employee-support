@php
    /** @var $material \App\Models\Material */
@endphp

<h1>{{ 'Редактирование материала' }}</h1>

@php
    if (isset($material->ID_Статьи)) {
        $formUrl = route('material-update', ['id' => $material->ID_Статьи]);
    } else {
        $formUrl = route('material-create');
    }
@endphp


<form method="post" action="{{ $formUrl }}">
    @csrf

    <div>
        <label for="Категория"><b>Категория:</b></label><br>
        <input type="text" name="Категория" value="{{ $material->Категория }}">
    </div>
    <br>

    <div>
        <label for="Тема"><b>Тема:</b></label><br>
        <input type="text" name="Тема" value="{{ $material->Тема }}">
    </div>

    <div>
        <label for="ID_Наставника"><b>ID_Наставника:</b></label><br>
        <input type="text" name="ID_Наставника" value="{{ $material->ID_Наставника }}">
    </div>

    <br>
    <br>
    <br>
    <div>
        <input type="submit" value="Сохранить">
    </div>
</form>
