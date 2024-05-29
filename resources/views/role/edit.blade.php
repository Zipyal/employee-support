@php

    use App\Models\Permission;
    use App\Models\Role;
    use Illuminate\Database\Eloquent\Collection;

    /** @var Role $role */
    /** @var Permission[]|Collection $permissions */

@endphp
@extends('layout.main')
@section('title')
    {{ $role->uuid ? 'Редактирование' : 'Создание' }} роли
@endsection
@section('buttons')
    @if($role->uuid)
        <form method="post" class="d-inline" action="{{ route('role-delete', ['id' => $role]) }}"
              onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
            @csrf
            <button type="submit" class="btn btn-lg btn-danger"><i class="fas fa-trash-alt"></i></button>
        </form>
    @endif
@endsection
@section('content')

    @php
        if (isset($role->uuid)) {
            $formUrl = route('role-update', ['id' => $role->uuid]);
        } else {
            $formUrl = route('role-store');
        }
    @endphp

    <div class="container">
        <form method="post" action="{{ $formUrl }}" class="row g-3 needs-validation">
            @csrf
            <div class="col-12">
                <label for="name" class="form-label">Название</label>
                <div class="input-group has-validation">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                           name="name" value="{{ old('name') ?? $role->name }}">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 mt-5">
                <div class="row">
                    <div class="dual-list list-right col-md-6 mb-5 mb-md-0">
                        <div class="well">
                            <div class="row">
                                <div class="col-12 form-group">
                                    <label for="search_in_left_list" class="form-label">Выберите разрешения</label>
                                    <div class="input-group">
                                        <span class="input-group-text search-icon bg-transparent"><i class="fas fa-search"></i></span>
                                        <input type="text" id="search_in_left_list" name="search_in_left_list" class="form-control search-in-list" placeholder="Поиск" value="">
                                        <button class="btn btn-outline-secondary selector" type="button" title="Выбрать все"><i class="far fa-check-square"></i></button>
                                        <button class="btn btn-outline-secondary move-left" type="button" title="Добавить выбранные"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-group mt-3" id="dual-list-right">
                                @foreach($permissions as $permission)
                                    <li class="list-group-item" data-value="{{ $permission->uuid }}">{{ $permission->name }}</li>
                                @endforeach
                            </ul>
                            <div class="empty-text text-muted" style="{{ $permissions->isEmpty() ? '' : 'display: none' }}">Все разрешения уже привязаны к роли.</div>
                        </div>
                    </div>

                    <div class="dual-list list-left col-md-6">
                        <div class="well text-right">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="search_in_right_list" class="form-label">Разрешения, привязанные к роли</label>
                                    <div class="input-group">
                                        <span class="input-group-text search-icon bg-transparent"><i class="fas fa-search"></i></span>
                                        <input type="text" id="search_in_right_list" name="search_in_right_list" class="form-control search-in-list" placeholder="Поиск" value="">
                                        <button class="btn btn-outline-secondary selector" type="button" title="Выбрать все"><i class="far fa-check-square"></i></button>
                                        <button class="btn btn-outline-secondary move-right" type="button" title="Удалить выбранные"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-group mt-3" id="dual-list-left">
                                @foreach($rolePermissions as $permission)
                                    <li class="list-group-item" data-value="{{ $permission->uuid }}">{{ $permission->name }}</li>
                                @endforeach
                            </ul>
                            <div class="empty-text text-muted" style="{{ $rolePermissions->isEmpty() ? '' : 'display: none' }}">Нет привязанных к роли разрешений.</div>
                        </div>
                    </div>

                    <select id="permissions" name="permissions[]" multiple="multiple" style="display: none;" size="10">
                        @foreach($rolePermissions as $permission)
                            <option value="{{ $permission->uuid }}" selected="selected">{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-12 mt-5">
                <div class="row">
                    <div class="col text-center text-sm-start">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Сохранить</button>
                    </div>
                    <div class="col text-center">
                        <button type="submit" name="stay-here" class="btn btn-outline-primary" value="1"><i class="fas fa-save"></i> Сохранить и продолжить редактирование</button>
                    </div>
                    <div class="col text-center text-sm-end">
                        @if($role->uuid)
                            <a class="btn btn-outline-warning" href="{{ route('role-manage') }}"><i
                                    class="fas fa-ban"></i> Отмена</a>
                        @else
                            <button type="reset" class="btn btn-outline-danger"><i class="fas fa-eraser"></i> Очистить
                                форму
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="{{ asset('libs/jquery-ui/external/jquery/jquery.js') }}"></script>
    <script src="{{ asset('libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $(function () {
            var move_left = '<span class="float-end dual-list-move-left" title="Добавить" style="cursor: pointer"><i class="fas fa-plus"></i></span>';
            var move_right = '<span class=" float-end dual-list-move-right" title="Удалить" style="cursor: pointer"><i class="fas fa-minus"></i></span>';




            $('body').on('click', '.list-group .list-group-item', function () {
                $(this).toggleClass('active');
            });


            $('body').on('click', '.dual-list-move-right', function (e) {
                e.preventDefault();

                actives = $(this).parent();
                $(this).parent().find("span").remove();
                $(move_left).clone().appendTo(actives);
                actives.clone().appendTo('.list-right ul').removeClass("active");
                actives.remove();

                sortUnorderedList("dual-list-right");

                updateSelectedOptions();
            });


            $('body').on('click', '.dual-list-move-left', function (e) {
                e.preventDefault();

                actives = $(this).parent();
                $(this).parent().find("span").remove();
                $(move_right).clone().appendTo(actives);
                actives.clone().appendTo('.list-left ul').removeClass("active");
                actives.remove();

                updateSelectedOptions();
            });


            $('body').on('DOMSubtreeModified', '#dual-list-left, #dual-list-right', function () {
                if ($(this).find('li').length > 0) {
                    $(this).parent().find('.empty-text').hide();
                } else {
                    $(this).parent().find('.empty-text').show();
                }
            });


            $('.move-right, .move-left').click(function () {
                let $button = $(this),
                    actives = '';

                if ($button.hasClass('move-left')) {
                    actives = $('.list-right ul li.active');
                    actives.find(".dual-list-move-left").remove();
                    actives.append($(move_right).clone());
                    actives.clone().appendTo('.list-left ul').removeClass("active");
                    actives.remove();

                } else if ($button.hasClass('move-right')) {
                    actives = $('.list-left ul li.active');
                    actives.find(".dual-list-move-right").remove();
                    actives.append($(move_left).clone());
                    actives.clone().appendTo('.list-right ul').removeClass("active");
                    actives.remove();
                }

                updateSelectedOptions();
            });

            function updateSelectedOptions() {
                $('#permissions').find('option').remove();

                $('.list-left ul li').each(function (idx, opt) {
                    $('#permissions').append($("<option></option>")
                        .attr("value", $(opt).data("value"))
                        .text($(opt).text())
                        .prop("selected", "selected")
                    );
                });
            }


            $('.dual-list .selector').click(function () {
                var $checkBox = $(this);
                if (!$checkBox.hasClass('selected')) {
                    $checkBox.addClass('selected').closest('.well').find('ul li:not(.active)').addClass('active');
                    $checkBox.children('i').removeClass('glyphicon-unchecked').addClass('glyphicon-check');
                } else {
                    $checkBox.removeClass('selected').closest('.well').find('ul li.active').removeClass('active');
                    $checkBox.children('i').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
                }
            });


            $('.search-in-list').keyup(function (e) {
                var code = e.keyCode || e.which;
                if (code == '9') return;
                if (code == '27') $(this).val(null);
                var $rows = $(this).closest('.dual-list').find('.list-group li');
                var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
                $rows.show().filter(function () {
                    var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                    return !~text.indexOf(val);
                }).hide();
            });


            $(".search-icon").on("click", function () {
                $(this).next("input").focus();
            });


            function sortUnorderedList(ul, sortDescending) {
                $("#" + ul + " li").sort(sort_li).appendTo("#" + ul);

                function sort_li(a, b) {
                    return ($(b).data('value')) < ($(a).data('value')) ? 1 : -1;
                }
            }


            $("#dual-list-left li").append(move_right);
            $("#dual-list-right li").append(move_left);


            /*

                $(".dual-list.list-left .list-group").sortable({
                    stop: function (event, ui) {
                        updateSelectedOptions();
                    }
                });

                // let the gallery items be draggable
                $( ".dual-list.list-left .list-group .list-group-item" ).draggable({
                  cancel: "a.ui-icon", // clicking an icon won't initiate dragging
                  revert: "invalid", // when not dropped, the item will revert back to its initial position
                  containment: "document",
                  helper: "clone",
                  cursor: "move"
                });

                $( ".dual-list.list-right .list-group .list-group-item" ).draggable({
                  //connectToSortable: ".dual-list.list-right .list-group",
                  cancel: "a.ui-icon", // clicking an icon won't initiate dragging
                  revert: "invalid", // when not dropped, the item will revert back to its initial position
                  containment: "document",
                  helper: "clone",
                  cursor: "move"
                });

                // let the trash be droppable, accepting the gallery items
                $( ".dual-list.list-right .list-group .list-group-item" ).droppable({
                  accept: ".dual-list.list-left .list-group .list-group-item",
                  drop: function( event, ui ) {
                    //deleteImage( ui.draggable );
                    console.log(this);
                    console.log(event);
                    console.log(ui);

                    moveItem(ui.draggable);
                  }
                });

                // let the trash be droppable, accepting the gallery items
                $( ".dual-list.list-left .list-group .list-group-item" ).droppable({
                  accept: ".dual-list.list-right .list-group .list-group-item",
                  drop: function( event, ui ) {
                    //deleteImage( ui.draggable );
                    console.log(this);
                    console.log(event);
                    console.log(ui);

                    moveItem(ui.draggable);
                  }
                });


                // let the gallery be droppable as well, accepting items from the trash
                $gallery.droppable({
                  accept: "#trash li",
                  activeClass: "custom-state-active",
                  drop: function( event, ui ) {
                    recycleImage( ui.draggable );
                  }
                });


                function moveItem(item) {
                    console.log("move item");
                    console.log($(item));
                    var from = $(item).closest(".dual-list").hasClass("list-left") ? "left" : "right"
                    var to = $(item).closest(".dual-list").hasClass("list-left") ? "right" : "left"
                    console.log(from, to);

                    if (to == "left") {
                        $(item).find("span.dual-list-move-left").remove();
                        $(item).append($(move_right).clone());
                        $(item).appendTo('.list-' + to + ' ul');

                    } else if (to == "right") {
                        $(item).find("span.dual-list-move-right").remove();
                        $(item).append($(move_left).clone());
                        $(item).appendTo('.list-' + to + ' ul');

                    }


                }


            */


        });
    </script>
@endsection
