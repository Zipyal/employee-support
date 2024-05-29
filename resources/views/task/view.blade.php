@php
    use App\Models\Permission;
    use \App\Models\Task;
    use \App\Models\User;use Rolandstarke\Thumbnail\Facades\Thumbnail;

    /** @var $task Task */
    /** @var $task User */
@endphp
@extends('layout.main')
@section('title')
    Задача {{ $task->id .': '. $task->subject }}
@endsection
@section('buttons')
    @canany([Permission::TASK_EDIT, Permission::TASK_EDIT_OWN])
        <a class="btn btn-outline-dark" href="{{ route('task-edit', ['id' => $task]) }}"><i
                class="fas fa-pencil-alt"></i></a>
    @endcanany
    @can(Permission::TASK_DELETE)
        <form method="post" class="d-inline" action="{{ route('task-delete', ['id' => $task]) }}"
              onSubmit="if(!confirm('Вы действительно хотите удалить?')){return false;}">
            @csrf
            <button type="submit" class="btn btn-lg btn-danger"><i class="fas fa-trash-alt"></i></button>
        </form>
    @endcan
@endsection
@section('content')

    <div class="container">
        <div class="row py-2 mb-3 border {{ Task::PRIORITY_CSS_CLASSES[$task->priority] }}">
            <div class="col-12 col-md-4 mb-3">
                <div class="text-muted fw-light">Статус</div>
                <div>{{ $task->status }}</div>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <div class="text-muted fw-light">Приоритет</div>
                <div>{{ $task->priority }}</div>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <div class="text-muted fw-light">Тип</div>
                <div>{{ $task->type }}</div>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <div class="text-muted fw-light">Планируемая дата начала</div>
                <div>{{ $task->start_date?->format('d.m.Y') }}</div>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <div class="text-muted fw-light">Планируемая дата завершения</div>
                <div>{{ $task->end_date?->format('d.m.Y') }}</div>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <div class="text-muted fw-light">Назначена</div>
                <div>{{ $task->employee?->fullName }}</div>
            </div>

            <div class="col-12 mt-3">
                <hr>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <div class="text-muted fw-light">Добавлено:</div>
                <div>{{ $task->created_at?->format('d.m.Y - H:i') }}</div>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <div class="text-muted fw-light">Обновлено:</div>
                <div>@if($task->created_at != $task->updated_at)
                        {{ $task->updated_at?->format('d.m.Y - H:i') }}
                    @endif</div>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <div class="text-muted fw-light">Автор:</div>
                <div>{{ $task->author?->employee?->lastFirstName ?? $task->author?->name }}</div>
            </div>
        </div>

        <div class="row mb-4 py-2">
            @if($task->briefing_uuid)
                <div class="col-12 col-md-4 mb-1">
                    <div class="text-muted fw-light"><i class="fas fa-paperclip"></i> Инструктаж</div>
                    <div>
                        <a href="{{ route('briefing-show', ['id' => $task->briefing_uuid]) }}">{{ $task->briefing?->subject }}</a>
                    </div>
                </div>
            @endif
            @if($task->test_uuid)
                <div class="col-12 col-md-4 mb-1">
                    <div class="text-muted fw-light"><i class="fas fa-paperclip"></i> Тест</div>
                    <div><a href="{{ route('test-show', ['id' => $task->test_uuid]) }}">{{ $task->test?->subject }}</a>
                    </div>
                </div>
            @endif
            @if($task->material_uuid)
                <div class="col-12 col-md-4 mb-1">
                    <div class="text-muted fw-light"><i class="fas fa-paperclip"></i> Материал</div>
                    <div>
                        <a href="{{ route('material-show', ['id' => $task->material_uuid]) }}">{{ $task->material?->subject }}</a>
                    </div>
                </div>
            @endif
        </div>

        <div class="row my-5">
            <div class="col-12">
                @include('_images_gallary', ['images' => $task->images])
            </div>
            <div class="col-12 my-3">
                <div class="text-muted fw-light">Описание</div>
                <div>{!! nl2br($task->description) !!}</div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12 h5 mb-3">Комментарии</div>
            @if($task->comments->isNotEmpty())
                <div class="row">
                    @foreach($task->comments as $i => $comment)
                        @php $hexColor = '#' . (substr($comment->author_uuid ?? 'faa000', -6)); @endphp
                        <div class="col-12 py-4 hover-bg-light @if($i > 0) border-top @endif">
                            <div class="comment-info">
                                <div class="comment-author-avatar float-start">
                                    <img class="rounded-circle" width="42px" src="{{ Thumbnail::src($comment->author?->employee?->image_filepath ?? '/img/no_avatar.png', 'public')->crop(42, 42)->url() }}">
                                </div>
                                <div class="comment-author-name" style="color: {{ $hexColor }}">
                                    {{ $comment->author->employee->firstLastName ?? 'Неизвестный' }}
                                </div>
                                <div class="comment-dt text-muted small">
                                    {{ $comment->updated_at?->format('d.m.Y - H:i') ?? $comment->created_at?->format('d.m.Y H:i') }}
                                </div>
                            </div>
                            <div class="comment-text mt-3 text-dark">{!! nl2br($comment->text) !!}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="col-12 text-muted">Комментариев пока нет.</div>
            @endif

            @can(Permission::TASK_COMMENT)
                <div class="col-12 mt-5 bg-light py-3">
                    <form class="row" method="post" action="{{ route('task-add-comment') }}">
                        @csrf
                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                        <input type="hidden" name="author_uuid" value="{{ Auth::user()?->uuid }}">
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
                            <button type="submit" class="btn btn-sm btn-outline-success">Отправить <i
                                    class="fas fa-paper-plane" style="rotate: 45deg"></i></button>
                        </div>
                    </form>
                </div>
            @endcan
        </div>
    </div>

@endsection
