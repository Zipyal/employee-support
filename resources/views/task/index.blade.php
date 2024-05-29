@php
    use App\Models\User;
    use App\Models\Task;
    /** @var \App\Models\Task[]|\Illuminate\Database\Eloquent\Collection $tasks */
@endphp
@extends('layout.main')
@section('title')
    Задачи
@endsection
@section('filter')
    <div class="col-12 col-sm-3">
        <label class="text-muted" for="filter-subject">Тема: </label>
        <input id="filter-subject" class="form-control" name="subject" type="text" onchange="this.form.submit()"
               value="{{ request('subject') }}">
    </div>
    <div class="col-12 col-sm-2">
        <label class="text-muted" for="filter-status">Статус: </label>
        <select id="filter-status" class="form-control form-select" name="status" onchange="this.form.submit()">
            <option value="">- не выбрано -</option>
            @foreach($statuses as $status)
                <option value="{{ $status }}" {{ request('status') != $status ?: 'selected' }}>{{ $status }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-sm-2">
        <label class="text-muted" for="filter-type">Тип: </label>
        <select id="filter-type" class="form-control form-select" name="type" onchange="this.form.submit()">
            <option value="">- не выбрано -</option>
            @foreach($types as $type)
                <option value="{{ $type }}" {{ request('type') != $type ?: 'selected' }}>{{ $type }}</option>
            @endforeach
        </select>
    </div>
    @if(in_array(auth()?->user()?->role_id, [User::ROLE_ADMIN, User::ROLE_MENTOR]))
        <div class="col-12 col-sm-3">
            <label class="text-muted" for="filter-employee">Назначена: </label>
            <select id="filter-employee" class="form-control form-select" name="employee" onchange="this.form.submit()">
                <option value="">- не выбрано -</option>
                @foreach($employees as $uuid => $name)
                    <option value="{{ $uuid }}" {{ request('employee') != $uuid ?: 'selected' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>
    @endif
@endsection
@section('content')

    @if($tasks->isNotEmpty())
    <div class="container-fluid">
        <table id="task-board" class="table">
            <thead>
            <tr class="sticky-top">
                @foreach($statuses as $status)
                    <th scope="col"
                        class="text-center bg-light border-start border-end fw-normal">{{ $status }}</th>
                @endforeach
            </tr>
            <thead>
            <tbody>
            <tr class="draggable-container" style="min-height: 300px!important;">
                @foreach($statuses as $status)
                    <td class="sortable" data-task-status="{{ $status }}" style="overflow-y: hidden; min-height: 300px!important">
                        @foreach($tasks->where('status', '=', $status) as $task)
                            <div class="card mb-3 draggable {{ Task::PRIORITY_CSS_CLASSES[$task->priority] }}" data-id="{{ $task->id }}">
                                <div class="card-header bg-transparent row mx-0 px-1">
                                    <div class="task-type col-8 text-start">{{ $task->type }}</div>
                                    <div class="task-id col-4 text-end">#<span class="h4 m-0 p-0">{{ $task->id }}</span></div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-subtitle text-muted small"></h5>
                                    <h5 class="card-title fw-normal lh-1">
                                        <a class="text-decoration-none hover-underline" href="{{ route('task-show', ['id' => $task->id ]) }}">{{ $task->subject }}</a>
                                    </h5>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div><span class="opacity-50">Приоритет:</span> <span class="task-priority">{{ $task->priority }}</span></div>
                                    <div><span class="opacity-50">Автор:</span> <span class="task-user">{{ $task->employee?->lastFirstName }}</span></div>
                                    <div><span class="opacity-50">Срок:</span> <span class="task-user">{{ $task->end_date?->format('j F Y') ?? '---' }}</span></div>
                                </div>
                            </div>
                        @endforeach
                    </td>
                @endforeach
            </tr>
            </tbody>
        </table>
    </div>
    @else
        <div class="container">
            <div class="text-muted">У вас нет задач.</div>
        </div>
    @endif

    <link rel="stylesheet" href="{{ asset('libs/jquery-ui/jquery-ui.min.css') }}">
    <style>
        .ui-draggable {
            cursor: grab;
            z-index: 10!important;
        }

        .ui-draggable-dragging {
            cursor: grabbing;
            z-index: 99999!important;
        }
    </style>
    <script src="{{ asset('libs/jquery-ui/external/jquery/jquery.js') }}"></script>
    <script src="{{ asset('libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $(function () {

            const boardWidth = $('#task-board').width();
            const boardColumns = $('#task-board > thead > tr > th').length;
            const columnWidth = parseInt(boardWidth / boardColumns, 10);
            console.log(`${boardWidth} / ${boardColumns} = ${columnWidth}`);

            $('table th').css('width', columnWidth);

            $('.sortable').sortable({
                helper: "clone"
            });
            $('.draggable').disableSelection().draggable({
                containment: '.draggable-container',
                connectToSortable: '.sortable',
                // zIndex: 9999999
            }).on('dragstop', function (event, ui) {

                const card = $(this);
                const oldStatus = $(this).find('.task-status').text();
                const newStatus = $(this).parent().attr('data-task-status');

                if (oldStatus !== newStatus) {
                    const taskId = $(this).attr('data-id');
                    const postData = {
                        status: newStatus,
                        _token: "{{ csrf_token() }}"
                    };

                    const url = `/tasks/${taskId}/update-status`;

                    fetch(url, {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
                        body: JSON.stringify(postData)

                    }).then(function (response) {
                        $(card).find('.task-status').text(newStatus);

                    }).catch(function (e) {
                        console.error(e);
                        console.error(response);
                    });
                }
            });
        });
    </script>
@endsection
