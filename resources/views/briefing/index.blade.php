@php
    use App\Models\Briefing;
    use App\Models\BriefingEmployee;
    use App\Models\Employee;
    use App\Models\Permission;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Collection;

    /** @var Briefing[]|Collection $briefings */
@endphp
@extends('layout.main')
@section('title')
    Инструктажи
@endsection
@section('content')
    <div class="container">
        @if($briefings->isNotEmpty())
            <div class="row">
                <div class="col-12 col-md mb-5">
                    {{--<h3 class="mb-5">Материалы</h3>--}}
                    @foreach($briefings as $item)
                        @php $isRead = $item->isReadByEmployee(auth()->user()?->employee?->uuid); @endphp
                        <div class="card shadow-sm mb-5 @if($isRead) text-bg-light-success @endif">
                            <div class="card-body">
                                {{--<div class="text-muted opacity-50">Материал</div>--}}
                                <div class="card-title h5">{{ $item->subject }}</div>
                                <div class="card-subtitle text-muted"><i
                                        class="far fa-clock"></i> {{ $item->updated_at }}</div>
                                <div class="my-3 card-text">{{ Str::limit($item->text, 300, ' ...') }}</div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col text-start">
                                        @if($isRead)
                                            <span class="text-success">Прочитано <i class="fas fa-check"></i></span>
                                        @endif
                                    </div>
                                    <div class="col text-end">
                                        <a class="btn btn-sm btn-outline-primary"
                                           href="{{ route('briefing-show', ['id' => $item]) }}">Подробнее →</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-muted">Нет опубликованных инструктажей.</div>
        @endif
    </div>
@endsection
