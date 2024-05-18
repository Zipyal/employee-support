@php
    use \App\Models\Task;
    use \App\Models\User;
    /** @var $task Task */
    /** @var $task User */
@endphp
@extends('layout.main')
@section('title')Задача {{ $task->id .': '. $task->subject }}@endsection
@section('buttons')
    @if(in_array(auth()?->user()?->role_id, [User::ROLE_ADMIN, User::ROLE_MENTOR]))
    <a class="btn btn-outline-dark" href="{{ route('task-edit', ['id' => $task]) }}"><i class="fas fa-pencil-alt"></i></a>
    <form method="post" class="d-inline" action="{{ route('task-delete', ['id' => $task]) }}"
          onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
        @csrf
        <button type="submit" class="btn btn-lg btn-danger"><i class="fas fa-trash-alt"></i></button>
    </form>
    @endif
@endsection
@section('content')

    <div class="container">
        <div class="row py-2 bg-light">
            <div class="col-12 col-md-4 mb-2">
                <div class="text-muted fw-light">Статус</div>
                <div>{{ $task->status }}</div>
            </div>

            <div class="col-12 col-md-4 mb-2">
                <div class="text-muted fw-light">Тип</div>
                <div>{{ $task->type }}</div>
            </div>

            <div class="col-12 col-md-4 mb-2">
                <div class="text-muted fw-light">Назначена</div>
                <div>{{ $task->employee?->fullName }}</div>
            </div>

            <div class="col-12 col-md-4 mb-2">
                <div class="text-muted fw-light">Планируемая дата начала</div>
                <div>{{ $task->start_date }}</div>
            </div>

            <div class="col-12 col-md-4 mb-2">
                <div class="text-muted fw-light">Планируемая дата завершения</div>
                <div>{{ $task->end_date }}</div>
            </div>

            <div class="col-12 col-md-4 mb-2"></div>

            <div class="col-12 col-md-4 mb-2">
                <div class="text-muted fw-light">Добавлено: </div>
                <div>{{ $task->created_at }}</div>
            </div>

            <div class="col-12 col-md-4 mb-2">
                <div class="text-muted fw-light">Обновлено: </div>
                <div>@if($task->created_at != $task->updated_at) {{ $task->updated_at }} @endif</div>
            </div>

            <div class="col-12 col-md-4 mb-2">
                <div class="text-muted fw-light">Автор: </div>
                <div>{{ $task->author?->employee?->lastFirstName ?? $task->author?->name }}</div>
            </div>
        </div>

        <div class="row mb-4 py-2">
            <div class="col-12 my-5">
                <div class="text-muted fw-light">Описание</div>
                <div>{!! nl2br($task->description) !!}</div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12 h5">Комментарии</div>
            @if($task->comments->isNotEmpty())
                <div class="row">
                    @foreach($task->comments as $comment)
                    <div class="col-12 mb-3 py-3 shadow-sm">
                        <div class="comment-info" style="color: #@php echo substr(dechex(crc32($comment->author_id ?? 'unknown')), 0, 6); @endphp">
                            <div class="comment-author"><i class="far fa-user-circle"></i> {{ $comment->author?->employee?->fullName ?? 'Неизвестный' }}</div>
                            <div class="comment-dt"><i class="far fa-clock"></i> {{ $comment->updated_at }}</div>
                        </div>
                        <div class="comment-text mt-3 text-dark">{!! nl2br($comment->text) !!}</div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="col-12 text-muted">Комментариев пока нет.</div>
            @endif
            <div class="col-12 mt-5 bg-light py-3">
                <form class="row" method="post" action="{{ route('task-add-comment') }}">
                    @csrf
                    <input type="hidden" name="task_id" value="{{ $task->id }}">
                    <input type="hidden" name="author_id" value="{{ Auth::user()?->id }}">
                    <div class="col-12">
                        <label for="comment-text">Ваш комментарий:</label>
                        <textarea class="form-control" name="text" id="comment-text"></textarea>
                    </div>
                    <script>
                        document.querySelector('#comment-text').addEventListener('keydown', function (e) {
                            // console.log(e);
                            if (e.ctrlKey && e.keyCode === 13) {
                                this.form.submit();
                            }
                        });
                    </script>
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-sm btn-outline-success">Отправить <i class="fas fa-paper-plane" style="rotate: 45deg"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
